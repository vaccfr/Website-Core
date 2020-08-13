<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>VATFrance ATIS</title>
</head>
<body>
  <b>URL:</b> {{config('app.url')}}/api/atis/$atiscode/$deprwy($atisairport)/$arrrwy($atisairport)/<b>APPROACH TYPE</b>/<b>SID</b>/?m=$metar($atisairport)"
  <br><br>
  <b>Arguments possibles:</b>
  <ul>
    <li>
      <b>birds=</b><br>Example: {{config('app.url')}}/api/atis/$atiscode/$deprwy($atisairport)/$arrrwy($atisairport)/<b>APPROACH TYPE</b>/<b>SID</b>/?m=$metar($atisairport)"&birds=1
    </li>
  </ul>
</body>
</html>