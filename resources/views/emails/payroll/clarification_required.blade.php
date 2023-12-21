<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailData['subject'] }}</title>
</head>
<body>
    <h1>{{ $mailData['subject'] }}</h1>
    <p>Dear Sir/Madam,</p>
    <p>{{ $mailData['body'] }}</p>
    <p>Please review the details and take the necessary actions accordingly.</p>
    <p>Thank you for your attention!</p>
    
    <p>Best regards,</p>
    <p>K G Somani & Co LLP</p>
</body>
</html>
