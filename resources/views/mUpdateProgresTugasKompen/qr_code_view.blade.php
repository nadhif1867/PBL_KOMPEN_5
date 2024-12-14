<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
</head>
<body>
    <h1>QR Code untuk File</h1>
    <p>URL: <a href="{{ $fileUrl }}">{{ $fileUrl }}</a></p>
    <div>
        {!! $qrCode !!}
    </div>
</body>
</html>
