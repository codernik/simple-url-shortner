<!DOCTYPE html>
<html>
<head>
    <title>Update Link</title>
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
    <h1 class="text-center my-5">Update Link</h1>
    <form method="post" action="{{ route('links.update', $link) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" value="{{ $link->url }}" name="url" id="url" class="form-control">
        </div>
        <div class="form-group">
            <label for="path">Custom Path</label>
            <input name="path" id="path" class="form-control" value="{{ $link->hash }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>