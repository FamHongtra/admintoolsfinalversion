<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="js/jquery.autocomplete.js"></script>


  <!-- Styles -->
  <style>
  html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Raleway', sans-serif;
    font-weight: 100;
    height: 100vh;
    margin: 0;
  }

  .full-height {
    height: 100vh;
  }

  .flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
  }

  .position-ref {
    position: relative;
  }

  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }

  .content {
    text-align: center;
  }

  .title {
    font-size: 84px;
  }

  .links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }

  .m-b-md {
    margin-bottom: 30px;
  }
  </style>
</head>
<body>
  <div class="flex-center position-ref full-height">
    @if (Route::has('login'))
    <div class="top-right links">
      @if (Auth::check())
      <a href="{{ url('/home') }}">Home</a>
      @else
      <a href="{{ url('/login') }}">Login</a>
      <a href="{{ url('/register') }}">Register</a>
      @endif
    </div>
    @endif

    <div class="content">
      <div class="title m-b-md">
        WELCOME ADMIN
      </div>

      <?php
          $user_id = 1 ;
       ?>

      <div class="links">
        <a href="https://laravel.com/docs">Documentation</a>
        <a href="https://laracasts.com">Laracasts</a>
        <a href="https://laravel-news.com">News</a>
        <a href="https://forge.laravel.com">Forge</a>
        <a href="https://github.com/laravel/laravel">GitHub</a>
      </div>
      <form action="{{url('searchhost')}}" id="searchform" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <input type="text" name="searchkey" id="autocomplete"/>
      </form>

      <!--
      {{ Form::open(['action' => ['SearchController@autocomplete'], 'method' => 'GET']) }}
      {{ Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Enter name'])}}
      {{ Form::submit('Search', array('class' => 'button expand')) }}
      {{ Form::close() }} -->
    </div>
  </div>
  <script type="text/javascript">
  // $(function()
  // {
  //   $( "#q" ).autocomplete({
  //     source: "search/autocomplete",
  //     minLength: 3,
  //     select: function(event, ui) {
  //       $('#q').val(ui.item.value);
  //     }
  //   });
  // });

  // $('#autocomplete').autocomplete({
  //   serviceUrl: 'search/autocomplete',
  //   onSelect: function (suggestion) {
  //     alert('You selected: ' + suggestion.value);
  //   }
  // });
  //
  xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET", "search/autocomplete", false);
  xmlhttp.send();
  var hosts = JSON.parse(xmlhttp.responseText);
  // { value: 'Andorra', data: 'AD' },
  // // ...
  // { value: 'Zimbabwe', data: 'ZZ' }

  $('#autocomplete').autocomplete({
    lookup: hosts,
    onSelect: function (item) {
      //
      // $("#searchform").submit();
      // alert('You selected: ' + item.value);
    }
  });


  </script>
</body>
</html>
