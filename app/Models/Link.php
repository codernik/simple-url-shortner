<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Utilities\HashGenerator;
use Carbon\Carbon;

class Link extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'url',
        'hash',
        'views',
        'disable',
        'expires_at',
    ];

    /**
     * Get the user that owns the Link
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function makeLink(string $url, string $hash = null)
    {
        $link = Link::where('url', $url)
            ->when($hash, function ($query) use ($hash) {
                $query->where('hash', $hash);
            })
            ->where('user_id', auth()->id())
            ->first();

        if ($link) {
            return $link;
        }

        if (! $hash) {
            $hash = HashGenerator::create($url);

            if (Link::where('hash', $hash)->exists()) {
                $hash = Str::random(6);
            }
        }

        $expires_at = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');

        return Link::create([
            'user_id' => auth()->id(),
            'url' => $url,
            'hash' => $hash,
            'expires_at' => $expires_at,
        ]);
    }

    public static function getByHash(string $hash)
    {
        return Link::where('hash', $hash)->first();
    }

}
