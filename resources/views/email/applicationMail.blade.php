<!DOCTYPE html>
<html>
<head>
    <title>Application</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>
        Dear Applicant,<br><br>
        Greetings!
        {{ $mailData['body'] }}<br><br>
        <b>Application No:</b>{{ $mailData['app_no'] }}<br>
        <b>Status:</b>Draft
    </p>
  
    <p>*** This is a system generated message. <b>DO NOT REPLY TO THIS EMAIL. ***</p>
     
    <p>
        Thank you<br>
        UPPFI
    </p>
</body>
</html>