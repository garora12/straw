<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <!-- <link type="image/x-icon" href="/assets/img/favicon.ico" rel="shortcut icon">
  <link href="/assets/img/favicon.ico" rel="apple-touch-icon"> -->
  <link type="image/x-icon" href="/assets/img/fav1.png" rel="shortcut icon">
  <link href="/assets/img/fav1.png" rel="apple-touch-icon">
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <!-- <link rel="pingback" href="http://www.jobsarina.com/xmlrpc.php" /> -->
  <!-- <link rel="canonical" href="http://www.jobsarina.com/" /> -->
  <link rel="canonical" href="{{ $poll['slug'] }}" />

  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />

  <meta property="og:title" content="{{ $poll['question'] }}" />
  <meta property="og:description" content="{{ $poll['question'] }}" />

  <meta property="og:url" content="{{ $poll['slug'] }}" />
  <meta property="og:site_name" content="{{ $poll['baseUrl'] }}" />
  <meta property="og:image" content="{{ $poll['pollImageDetails'] }}"/>
  <meta name="twitter:card" content="summary" />

  <meta name="twitter:title" content="{{ $poll['question'] }}" />
  <meta name="twitter:description" content="{{ $poll['question'] }}" />

  <meta name="twitter:site" content="http://twitter.com"/>
  <meta name="twitter:image" content="{{ $poll['pollImageDetails'] }}"/>

  <meta name="keywords" content="{{ $poll['baseUrl'] }} {{ $poll['tagsStr'] }}">
  <!-- <meta name="author" content="Kamal Kishore"> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="{{ $poll['question'] }}">
  <title>{{ $poll['question'] }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
</head>
<body>
    
    <div class="col-md-6 offset-md-3">
        <!-- <img src="{{ $poll['pollImageDetails'] }}" /> -->
    </div>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        location.href = 'https://www.google.com/';
    </script>
</body>
</html>