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

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url('img/bg.png');
    font-family: 'Abel', sans-serif;
    color: #636b6f;
    font-weight: 100;
    height: 100vh;
    margin: 0;
  }

  .input-field1.input-field input[type=text]:focus + label {
    color: #00acc1;

  }
  .input-field1.input-field input[type=text]:focus {
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }

  .input-field1.input-field input[type=text].valid {
    border-bottom: 1px solid #0097a7;
    box-shadow: 0 1px 0 0 #0097a7;
  }

  .input-field1.input-field .prefix.active {
    color: #00acc1;
  }
  .input-field1.input-field input[type=number]:focus + label {
    color: #00acc1;
  }
  .input-field1.input-field input[type=number]:focus {
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }
  .input-field1.input-field input[type=number].valid {
    border-bottom: 1px solid #0097a7;
    box-shadow: 0 1px 0 0 #0097a7;
  }

  .input-field2.input-field input[type=text]:focus + label {
    color: #00bfa5;
  }
  .input-field2.input-field input[type=text]:focus {
    border-bottom: 1px solid #00bfa5;
    box-shadow: 0 1px 0 0 #00bfa5;
  }

  .input-field2.input-field .prefix.active {
    color: #00bfa5;
  }
  .input-field2.input-field input[type=number]:focus + label {
    color: #00bfa5;
  }


  .input-field2.input-field input[type=number]:focus {
    border-bottom: 1px solid #00bfa5;
    box-shadow: 0 1px 0 0 #00bfa5;
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

    <div class="row full-height" style="align-items: center;display: flex; background-color: rgb(0, 0, 0);background-color: rgba(0, 0, 0, 0.3);">
      <div class="col s8 m8 l4 offset-s2 offset-m2 offset-l4 shadow-box" style="background-color:white;">
        <form action="{{url("userlogin")}}" id="userloginform" method="post" enctype="multipart/form-data" style="padding:50px">
          <div class="row" align="center">
            <img src="img/logoicon.png" height="220px"/>
          </div><br>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="row">
            <div class="col s12 m8 l8 offset-m2 offset-l2">
              <div class="input-field input-field2">
                <i class="material-icons prefix">perm_identity</i>
                <input id="icon_prefix" type="text" name="userlogin_username" autofocus>
                <label for="icon_prefix" align="left">Username</label>
              </div>
              <div class="input-field input-field2">
                <i class="material-icons prefix">vpn_key</i>
                <input id="icon_prefix" type="password" name="userlogin_password">
                <label for="icon_prefix" align="left">Password</label>
              </div><br>
              <div class="input-field">
                <button class="btn-large waves-effect waves-light" type="button" name="action" onclick="loginSubmit()" style="position: relative;width: 100%;">Login
                </button>
              </div>
              @php
                $count_user = DB::table('users')->count();
              @endphp

              @if($count_user==0)
              <div class="input-field" align="right">
                <a href="#!" onclick="createUser()" class="teal-text" style="font-size:14pt">create your account</a>
              </div>
              @endif

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

    function createUser(){

      swal({
        title: 'User Creation',
        html:
        '<form action="{{url("createuser")}}" id="createuserform" class="col s12" method="post" enctype="multipart/form-data">'+
        '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
        '<br><div class="row">'+
        '<div class="col s10 m10 l10 offset-s1 offset-m1 offset-l1">'+
        '<div class="input-field input-field2">'+
        '<i class="material-icons prefix">assignment_ind</i>'+
        '<input id="icon_prefix" type="text" name="newuser_name" required>'+
        '<label for="icon_prefix" align="left">Name</label>'+
        '</div>'+
        '<div class="input-field input-field2">'+
        '<i class="material-icons prefix">perm_identity</i>'+
        '<input id="icon_prefix" type="text" name="newuser_username" required>'+
        '<label for="icon_prefix" align="left">Username</label>'+
        '</div>'+
        '<div class="input-field input-field2">'+
        '<i class="material-icons prefix">email</i>'+
        '<input id="icon_prefix" type="email" name="newuser_email" required>'+
        '<label for="icon_prefix" align="left">Email</label>'+
        '</div>'+
        '</div>'+
        '</div>'+
        '</form>',
        confirmButtonColor: '#26a69a',
        confirmButtonText: 'Create',
        showCancelButton: true,
      }).then(function () {
        var newuser_name = $('#createuserform').find('input[name="newuser_name"]').val();
        var newuser_username = $('#createuserform').find('input[name="newuser_username"]').val();
        var newuser_email = $('#createuserform').find('input[name="newuser_email"]').val();

        var regex_name = /^([a-zA-Z0-9]{1,})$/.test(newuser_name);
        var regex_username = /^([a-zA-Z0-9]{4,12})$/.test(newuser_username);
        var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(newuser_email);

        if(regex_name && regex_username && regex_email){

          $("#createuserform").submit();
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
          var invalid = "Name field must be at least 1 character with no special characters, Username field must be 4 to 12 characters with no special characters, E-mail must be a valid form!" ;

          swal({
            title: "Invalid Input!",
            text: ""+invalid,
            type: "warning",
            confirmButtonColor: '#26a69a',
          }).then(function (){
            createUser();
          });
        }
      });
    }



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
