@php use App\Helpers\CoreHelper; @endphp
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password Email</title>
</head>
<body>
<h1>{{ CoreHelper::getSetting('SETTING_SITE_TITLE') }}</h1>
<hr>
<h3>Forget Password Email</h3>
<p><b>Account Name: </b>{{ $account->name }}</p>
<p><b>Email Address: </b>{{ $account->email }}</p>
<p>You can reset your password by clicking the link below:</p>
<p><a href="{{ route('new_password', $token) }}"
      style="background:#689c38;color:#ffffff;padding: 8px 15px; font-size: 18px;border-radius:3px">Reset Password</a>
</p>

<br>

<p>{{ CoreHelper::getSetting('SETTING_SITE_COPYRIGHT') }}</p>
</body>
</html>
