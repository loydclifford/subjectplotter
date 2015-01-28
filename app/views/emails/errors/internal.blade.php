<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <h3>Exception ID</h3>
    {{ $unique_id }}
    <h3>message</h3>
    <p>{{  $exception->getMessage() }}</p>
    <p>Code: {{  $exception->getCode() }}</p>
    <p>File: {{  $exception->getFile() }}</p>
    <p> At Line :  {{  $exception->getLine() }}</p>
    <br />
</div>
</body>
</html>
