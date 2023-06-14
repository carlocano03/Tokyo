<!DOCTYPE html>
<html>
<head>
    <title>Processing of Application</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>
        Dear FM,<br><br>
        Greetings!
        {{ $mailData['body'] }}<br><br>
        <b>Status:</b>Forwarded
    </p>
  
    <p>*** This is a system generated message. <b>DO NOT REPLY TO THIS EMAIL. ***</p>
     
    <p>
        Thank you<br>
        UPPFI
    </p>
</body>
</html>