<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
    <h1 class="text-center my-5">Login</h1>
    <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <p>Don't have an account? Register <a href="{{ route('register') }}">here</a></p>
    </form>
</div>
</body>
</html>
