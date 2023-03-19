<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Link;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::all();
        return view('links.index', [
            'links' => $links
        ]);
    }

    public function edit(Link $link)
    {
        return view('links.edit', [
            'link' => $link
        ]);
    }

    public function create(Link $link)
    {
        return view('links.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'url' => 'required|string',
            'path' => 'nullable|unique:links,hash',
        ]);

        $link = Link::makeLink($request->url, $request->path);
        $link->save();
        return redirect()->route('links.index');
    }

    public function update(Request $request, Link $link)
    {
        $validatedData = $request->validate([
            'url' => 'required|string',
            'path' => 'nullable|unique:links,hash',
        ]);

        $link = Link::makeLink($request->url, $request->path);
        $link->save();
        return redirect()->route('links.index');
    }

    public function delete($id)
    {
        $link = Link::find($id);
        $link->delete();
        return redirect()->route('links.index');
    }

    public function disable($id)
    {
        $link = Link::find($id);
        $link->disable = true;
        $link->save();
        return redirect()->route('links.index');
    }

    public function enable($id)
    {
        $link = Link::find($id);
        $link->disable = false;
        $link->save();
        return redirect()->route('links.index');
    }

    public function processLink($hash)
    {
        $link = Link::getByHash($hash);

        if (! $link) {
            return redirect('/')->with(['error' => 'This URL does not exist.']);
        }

        if ($link->disable) {
            return redirect('/')->with(['error' => 'This URL is disabled.']);
        }
        
        if ($link->expires_at < now()) {
            return redirect('/')->with(['error' => 'This URL is expired.']);
        }

        $link->update([
            'views'      => $link->views + 1,
        ]);

        return redirect()->away($link->url);
    }

}
