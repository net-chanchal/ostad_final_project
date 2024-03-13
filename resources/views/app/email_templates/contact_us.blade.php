<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif;">

<h2>Contact Form Submission</h2>

<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Subject:</strong> {{ $data['subject'] }}</p>
<p><strong>Message:</strong> {{ $data['message'] }}</p>

<hr>

<p>This email was sent from the contact form on your website <a href="{{ request()->host() }}">$data['siteTitle']</a>. Please respond promptly to the sender.</p>

</body>
</html>
