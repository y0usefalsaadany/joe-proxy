<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>check your website</title>
</head>
<body>
  <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h4 class="card-title">Too Many Requests</h4>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <p class="card-text">Many requests on your site by this ip : {{ $data['ip'] }} <br>
         from this city : {{ $data['city'] }} <br>
         on this page <a href="{{ $data['page'] }}">Click here</a> , please take the appropriate action to protect your site</p>
        <a href="{{ env('APP_URL') }}" class="card-link">Visit website</a>
      </div>
  </div>
</body>
</html>
