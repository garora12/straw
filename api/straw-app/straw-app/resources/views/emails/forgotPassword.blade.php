<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Straw Forgot Password</title>
</head>
<body>
    <p>Click on the below link to create new password.</p>
    <p>
        <!-- <a href="http://203.100.79.185/straw-app/verifyForgotPasswordToken?token={{ $token }}">Create password</a> -->
        <a href="{{ url('/verifyForgotPasswordToken?token=' . $token) }}">Create password</a>
    </p>
</body>
</html>