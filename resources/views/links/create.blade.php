<!DOCTYPE html>
<html>
<head>
    <title>Create Link</title>
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
    <h1 class="text-center my-5">Create Link</h1>
    <form method="post" action="{{ route('links.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="url">URL*</label>
            <input type="text" name="url" id="url" class="form-control">
        </div>
        <div class="form-group">
            <label for="path">Custom Path (Optional)</label>
            <input name="path" id="path" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
</body>
</html>