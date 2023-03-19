<!DOCTYPE html>
<html>
<head>
    <title>List of Links</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script>
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: '51d37d23-563a-46c6-8647-d13a4e42dc08',
        });
        
        beamsClient.start()
            .then(() => beamsClient.addDeviceInterest('url-expire'))
            .then(() => console.log('Successfully registered and subscribed!'))
            .catch(console.error);
    </script>
</head>
<body>
<div class="container">
    <header><a href="{{ route('logout') }}">logout</a></header>
    <h1 class="text-center my-5">List of Links</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>URL</th>
                <th>Shorten Link</th>
                <th>Visitors</th>
                <th>Date</th>
                <th>Disabled?</th>
                <th>Expires At?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($links as $link)
                <tr>
                    <td>{{ $link->id }}</td>
                    <td><a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer">{{ $link->url }}</a></td>
                    <td><a href="{{ url('/') .'/'. $link->hash }}" target="_blank" rel="noopener noreferrer">{{ url('/') .'/'. $link->hash }}</a></td>
                    <td>{{ $link->views }}</td>
                    <td>{{ $link->created_at }}</td>
                    <td>{{ $link->disable == 0 ? 'No' : 'Yes' }}</td>
                    <td>{{ $link->expires_at }}</td>
                    <td>
                        <a href="{{ route('links.edit', $link) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('links.delete', $link->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        @if($link->disable)
                            <a href="{{ route('links.enable', $link->id) }}" class="btn btn-warning" onclick="return confirm('Are you sure?')">Enable</a>
                        @else
                            <a href="{{ route('links.disable', $link->id) }}" class="btn btn-warning" onclick="return confirm('Are you sure?')">Disable</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('links.create') }}" class="btn btn-success my-3">Create new link</a>
</div>
</body>
</html>
