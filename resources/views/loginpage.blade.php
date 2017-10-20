<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Arsenal" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Abel|Arsenal" rel="stylesheet">
  <!-- Sweetalert2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.js"></script>

  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>

  <!-- Styles -->
  <style>
  html, body {
    background: #4CB8C4;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #3CD3AD, #4CB8C4);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #3CD3AD, #4CB8C4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    font-family: 'Abel', sans-serif;
    color: #636b6f;
    font-family: 'Raleway', sans-serif;
    font-weight: 100;
    height: 100vh;
    margin: 0;
  }

  .full-height {
    height: 100vh;
  }

  .position-ref {
    position: relative;
  }


  .m-b-md {
    margin-bottom: 30px;
  }

  .shadow-box {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
  }

  .swal2-modal {
    font-family: 'Abel', sans-serif;
  }
  </style>
</head>


@if (Session::has('status'))
<body onload="hasmsg()" style="overflow-y: hidden;">
  @else
  <body style="overflow-y: hidden;">
    @endif

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

    <div class="row full-height" style="align-items: center;display: flex;">
      <div class="col s8 m8 l4 offset-s2 offset-m2 offset-l4 shadow-box" style="background-color:white;opacity: 0.8">
        <form action="{{url("userlogin")}}" id="userloginform" method="post" enctype="multipart/form-data" style="padding:50px">
          <div class="row" align="center">
            <img src="img/logo1.png" height="120px"/>
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="row">
            <div class="col s12 m8 l8 offset-m2 offset-l2">
              <div class="input-field">
                <i class="material-icons prefix">perm_identity</i>
                <input id="icon_prefix" type="text" name="userlogin_username" autofocus>
                <label for="icon_prefix" align="left">Username</label>
              </div>
              <div class="input-field">
                <i class="material-icons prefix">vpn_key</i>
                <input id="icon_prefix" type="password" name="userlogin_password">
                <label for="icon_prefix" align="left">Password</label>
              </div>
              <div class="input-field">
                <button class="btn-large waves-effect waves-light" type="button" name="action" onclick="loginSubmit()" style="position: relative;width: 100%;">Login
                  <i class="material-icons right">send</i>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
    <script type="text/javascript">
    @if (Session::has('status'))

    @if (Session::get('status') == "change password")

    function hasmsg(){
      swal({
        title: 'Change your password',
        html:
        '<form action="{{url("changepassword")}}" id="changepassform" class="col s12" method="post" enctype="multipart/form-data">'+
        '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
        '<input type="hidden" name="username" value="{{ Session::get("username") }}">'+
        '<input type="hidden" name="password" value="{{ Session::get("password") }}">'+
        '<br><div class="row">'+
        '<div class="col s10 m10 l10 offset-s1 offset-m1 offset-l1">'+
        '<div class="input-field input-field2">'+
        '<i class="material-icons prefix">vpn_key</i>'+
        '<input id="icon_prefix" type="password" class="validate" name="current_password" required>'+
        '<label for="icon_prefix" align="left">Current password</label>'+
        '</div>'+
        '<div class="input-field input-field2">'+
        '<i class="material-icons prefix">fiber_new</i>'+
        '<input id="icon_prefix" type="password" class="validate" name="new_password" required>'+
        '<label for="icon_prefix" align="left">New password</label>'+
        '</div>'+
        '<div class="input-field input-field2">'+
        '<i class="material-icons prefix">check</i>'+
        '<input id="icon_prefix" type="password" class="validate" name="confirm_new_password" required>'+
        '<label for="icon_prefix" align="left">Confirm new password</label>'+
        '</div>'+
        '</div>'+
        '</div>'+
        '</form>',
        confirmButtonColor: '#26a69a',
        confirmButtonText: 'Change Password',
        showCancelButton: true,
      }).then(function () {

        var curr_pass = $('#changepassform').find('input[name="current_password"]').val();
        var new_pass = $('#changepassform').find('input[name="new_password"]').val();
        var confirm_pass = $('#changepassform').find('input[name="confirm_new_password"]').val();

        if(/^([a-zA-Z0-9]{8,})$/.test(curr_pass) && /^([a-zA-Z0-9]{8,})$/.test(new_pass) && /^([a-zA-Z0-9]{8,})$/.test(confirm_pass)){
          if(new_pass == confirm_pass){
            //new password and confirm new password match!
            $("#changepassform").submit();
            swal({
              imageUrl: 'img/load.gif',
              imageWidth: 120,
              showCancelButton: false,
              showConfirmButton: false,
              animation: false,
              allowOutsideClick: false,
              confirmButtonColor: '#26a69a',
            });
          }else{
            swal({
              title: "Invalid Input!",
              text: "New password and Confirm password do not match!",
              type: "warning",
              confirmButtonColor: '#26a69a',
            }).then(function (){
              hasmsg();
            });
          }
        }else{
          swal({
            title: "Invalid Input!",
            text: "All input fields must be at least 8 characters, with no special characters!",
            type: "warning",
            confirmButtonColor: '#26a69a',
          }).then(function (){
            hasmsg();
          });
        }
      });
    }

    @else
    function hasmsg(){
      swal({
        title: "{!! Session::get('title') !!}",
        text: "{!! Session::get('text') !!}",
        type: "{!! Session::get('icon') !!}",
        confirmButtonColor: '#26a69a',
      });
    }
    @endif
    // swal("{!! Session::get('title') !!}","{!! Session::get('text') !!}", "{!! Session::get('icon') !!}");
    @endif



    function loginSubmit(){
      $("#userloginform").submit();
      swal({
        imageUrl: 'img/load.gif',
        imageWidth: 120,
        showCancelButton: false,
        showConfirmButton: false,
        animation: false,
        allowOutsideClick: false,
        confirmButtonColor: '#26a69a',
      });
    }
    </script>
  </body>
  </html>
