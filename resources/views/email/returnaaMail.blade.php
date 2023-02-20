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
        <b>Status:</b>For Compliance<br>
        <b>List of for completion/compliance:</b><br>
        @foreach ($mailData['for_correction'] as $key => $value)
        @if (!empty($value) && $key !== 'general_remarks')
            <b>{{ $value }}</b><br>
        @endif
        @endforeach
        <b>General Remarks: </b>{{ $mailData['for_correction']->general_remarks }}<br>
        
    </p>
  
    <p>*** This is a system generated message. <b>DO NOT REPLY TO THIS EMAIL. ***</p>
     
    <p>
        Thank you<br>
        UPPFI
    </p>
</body>
</html>