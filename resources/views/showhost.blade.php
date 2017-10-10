<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
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
  <script src="js/jquery.autocomplete.js"></script>
  <!-- Compiled and minified JavaScript -->


  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style media="screen">
  html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Abel', sans-serif;
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
  hr.style-four {
    height: 12px;
    border: 0;
    box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);
  }
  .file-path-wrapper input[type=text].valid{
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }

  .autocomplete-suggestions {
    background-color: #e0f2f1;
  }

  .autocomplete-selected {
    background: #4db6ac;
  }

  .autocomplete-suggestions strong {
    font-weight: bold; color: #004d40;
  }

  .swal2-modal {
    font-family: 'Abel', sans-serif;
  }

  .scroll {
    height: 350px;
    overflow-y: scroll;
    overflow-x: hidden;
  }

  </style>
</head>

@if (Session::has('status'))
<body onload="hasmsg()">
  @else
  <body>
    @endif
    <div class="navbar-fixed">
      <nav>
        <div class="nav-wrapper teal lighten-1 ">
          <a href="{{url('showhost')}}"  onclick="return loading();" class="brand-logo"><img src="img/logo0.png" height="50px" style="margin: 7px"/></a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="sass.html">Sass</a></li>
            <li><a href="badges.html">Components</a></li>
            <li><a href="collapsible.html">JavaScript</a></li>
          </ul>
        </div>
      </nav>
    </div>
    <br><br>


    <div class="row">

      <div class="input-field col s4 m4 l1 offset-l5">
        <select id="searchby" onchange="searchBy()">
          <option value="autocomplete" selected>Hostname or IP</option>
          <option value="autocompleteGroup">Groupname</option>
        </select>
        <label>Search By</label>
      </div>

      <div class="col s8 m8 l2">

        <form action="{{url('searchhost')}}"  onsubmit="return loading();" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="user_id" value="{{ $user_id }}">
          <input type="hidden" name="search_by" id="checksearch" value="{{ $user_id }}">

          <div class="input-field">
            <!-- <input type="text" name="searchkey" id="autocomplete"/> -->
            <input class="searchbar" id="autocomplete" type="search" name="searchkey" placeholder="Search here"/>
            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
            <i class="material-icons" onclick="blankSearch()">close</i>
          </div>
        </form>
      </div>
      @if(count($objs)!=0)
      <div class="col s12 m12 l4" align="center"><a class="modal-trigger waves-effect waves-light btn-large z-depth-5 cyan darken-3" style="font-size:17px" href="#modal1"><i class="material-icons left">add_box</i>Add Host</a>&nbsp&nbsp&nbsp&nbsp&nbsp<a class="modal-trigger waves-effect waves-light btn-large z-depth-5  blue-grey darken-1" style="font-size:17px" href="#modal2"><i class="material-icons left">library_add</i>Create Group</a></div>
      @else
      <div class="col s12 m12 l4" align="center"><a class="modal-trigger waves-effect waves-light btn-large z-depth-5 cyan darken-3" style="font-size:17px" href="#modal1"><i class="material-icons left">add_box</i>Add Host</a>&nbsp&nbsp&nbsp&nbsp&nbsp<a class="modal-trigger waves-effect waves-light btn-large z-depth-5  blue-grey darken-1 disabled" style="font-size:17px" href="#modal1"><i class="material-icons left">library_add</i>Create Group</a></div>
      @endif
    </div>

    <div class="row">

      @foreach($objs as $indexKey=>$obj)
      <div class="col s12 m6 l3" align="center">
        <div class="card cyan darken-3" style="width:250px">
          <h5 style="padding:10px;color:white">{{$obj->servername}}<a href="#!" onclick="delhost({{$obj->id}})"><i class="material-icons right" style="color:white">delete</i></a></h5>
        </div>
        <div class="card" style="width:250px;">
          <div class="card-image" style="padding:20px">
            <img src="img/server.png">
            <span class="card-title" style="color:#263238"><b>{{$obj->host}}</b></span>
          </div>
          <div class="card-action white">
            <a class="modal-trigger waves-effect waves-light btn-large cyan darken-3" onclick="sshLogin({{$obj->id}})"><i class="material-icons left">input</i>Connect</a>
          </div>
        </div>
      </div>
      @endforeach

      <div class="container" align="left">
        <!-- Page Content goes here -->
        <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer">
          <div class="modal-content">
            <br>
            <!-- <h5>Add Host</h5> -->
            <!-- <p>You should add host by using rsa key for secure</p> -->
            <!-- <hr class="style-four"><br> -->
            <div class="row">
              <div class="col s12 m12 l10 offset-l1">
                <div class="" align="center">
                  <a id="password" class="waves-effect waves-light btn teal accent-4" href="#modal1" onclick="byPassword()" ><i class="material-icons right">vpn_key</i>Using Password</a>
                  <a id="rsakey" class="waves-effect waves-light btn cyan darken-1" href="#modal1" onclick="byRSAKey()"><i class="material-icons right">vpn_key</i>Using RSA Key</a><br><br>
                </div>
                <div id="bypassword" class="row" style="display:block;">
                  <form action="{{url('loading')}}" id="hostform2" class="col s12" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="bywhat" value="password">
                    <div class="row">
                      <!-- <div class="input-field col s2"></div> -->
                      <div class="input-field input-field2 col s10 m8 l8 offset-s1 offset-m2 offset-l2">
                        <i class="material-icons prefix">perm_contact_calendar</i>
                        <input id="icon_prefix" type="text" class="validate" name="servername" pattern="^[a-zA-Z0-9-@]{1,32}$" title="Servername should be 1 to 32 characters.">
                        <label for="icon_prefix">Server Name</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field input-field2 col s5 m4 l5 offset-s1 offset-m2 offset-l2">
                        <i class="material-icons prefix">dns</i>
                        <input id="icon_prefix" type="text" class="validate" name="host"  pattern="^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$" title="Please enter valid ip address.">
                        <label for="icon_prefix">Hosts</label>
                      </div>
                      <div class="input-field input-field2 col s5 m4 l3">
                        <i class="material-icons prefix">phone</i>
                        <input id="icon_telephone" type="text" class="validate" name="port" pattern="^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$" title="Length should be between 0-65535.">
                        <label for="icon_telephone">Port</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field input-field2 col s10 m8 l8 offset-s1 offset-m2 offset-l2">
                        <i class="material-icons prefix">perm_identity</i>
                        <input id="icon_prefix" type="text" class="validate" name="usrname"  pattern="^[a-zA-Z0-9-@]{1,32}$" title="Username should be 1 to 32 characters.">
                        <label for="icon_prefix">Username</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field input-field2 col s10 m8 l8 offset-s1 offset-m2 offset-l2">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="icon_telephone" type="password" class="validate" name="password" pattern="^[a-z0-9]{6,}$" title="Password should consist of at least 6 characters and lower case.">
                        <label for="icon_telephone">Password</label>
                      </div>
                    </div>

                    <div id="errormsg" class="row" align="center" style="display:none">
                      <i class="material-icons prefix" style="color:#b71c1c">info_outline</i><span style="color:#b71c1c"> Invalid input, please check your informations.</span>
                    </div>

                  </form>
                </div>

                <div id="byrsakey" class="row" style="display:none;">
                  <form action="{{url('loading')}}" id="hostform" class="col s12" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="bywhat" value="rsakey">
                    <div class="row">
                      <div class="input-field input-field1 col s10 m8 l8 offset-s1 offset-m2 offset-l2">
                        <i class="material-icons prefix">perm_contact_calendar</i>
                        <input id="icon_prefix" type="text" class="validate" name="servername" pattern="^[a-zA-Z0-9-@]{1,32}$" title="Servername should be 1 to 32 characters, required.">
                        <label for="icon_prefix">Server Name</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field input-field1 col s5 m4 l5 offset-s1 offset-m2 offset-l2">
                        <i class="material-icons prefix">dns</i>
                        <input id="icon_prefix" type="text" class="validate" name="host" pattern="^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$" title="Please enter valid IP, required.">
                        <label for="icon_prefix">Hosts</label>
                      </div>
                      <div class="input-field input-field1 col s5 m4 l3">
                        <i class="material-icons prefix">phone</i>
                        <input id="icon_telephone" type="text" class="validate" name="port" pattern="^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$" title="Length should be between 0 to 65535, required.">
                        <label for="icon_telephone">Port</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field input-field1 col s10 m8 l8 offset-s1 offset-m2 offset-l2">
                        <i class="material-icons prefix">perm_identity</i>
                        <input id="icon_prefix" type="text" class="validate" name="usrname" pattern="^[a-zA-Z0-9-@]{1,32}$" title="Username should be 1 to 32 characters, required.">
                        <label for="icon_prefix">Username</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="file-field col s10 m8 l8 offset-s1 offset-m2 offset-l2">
                        <div class="btn" style="background-color:#00acc1">
                          <span>RSA Key</span>
                          <input type="file" name="password">
                        </div>
                        <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" name="filepath">
                        </div>
                      </div>
                    </div>
                    <div id="errormsg1" class="row" align="center" style="display:none">
                      <i class="material-icons prefix" style="color:#b71c1c">info_outline</i><span style="color:#b71c1c"> Invalid input, please check your informations.</span>
                    </div>
                  </form>
                </div>

              </div>
              <div class="col s1" ></div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="modal-action waves-effect waves-green btn teal" id="submitbtn">Submit</a>
          </div>
        </div>
      </div>





      <div class="container" align="left">
        <!-- Page Content goes here -->
        <!-- Modal Structure -->
        <div id="modal2" class="modal modal-fixed-footer">
          <div class="modal-content">
            <br>
            <!-- <h5>Add Host</h5> -->
            <!-- <p>You should add host by using rsa key for secure</p> -->
            <!-- <hr class="style-four"><br> -->
            <div class="row">
              <div class="col s1"></div>
              <div class="col s10">
                <div class="row" style="display:block;">
                  <form action="{{url('creategroup')}}" id="groupform" class="col s12" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <div class="row">
                      <div class="input-field input-field2 col s10 m10 l8 offset-s1 offset-m1 offset-l2">
                        <i class="material-icons prefix">view_week</i>
                        <input id="icon_prefix" type="text" class="validate" name="groupname" pattern="^[a-zA-Z0-9-@]{1,32}$" title="Group name should be 1 to 32 characters.">
                        <label for="icon_prefix">Host's Group Name</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col s12 m12 l10 offset-sl">
                        Ungroup Hosts:
                        <ul class="collection scroll">
                          @foreach($objs as $indexKey=>$obj)
                          <li class="collection-item">
                            <div><input type="checkbox" class="filled-in" name="selecthost[]" id="filled-in-box{{$indexKey+1}}" value="{{$obj->id}}"/><label for="filled-in-box{{$indexKey+1}}" style="color:#455a64; font-size:13pt">{{$obj->servername}} - {{$obj->host}}</label></div>
                          </li>
                          @endforeach
                        </ul>
                      </div>
                    </div>

                    <div id="errormsg" class="row" align="center" style="display:none">
                      <i class="material-icons prefix" style="color:#b71c1c">info_outline</i><span style="color:#b71c1c"> Invalid input, please check your informations.</span>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="modal-action waves-effect waves-green btn teal" id="submitgroup" >Create Group</a>
          </div>
        </div>
      </div>


    </div>


    @foreach($all_group as $group)
    <div class="row">

      <div class="col s12">
        <ul class="collection with-header grey lighten-2">
          <li class="collection-header blue-grey darken-1" style="font-size:15pt;color:white"><div> <i class="material-icons" style="margin-right:20px">view_week</i>{{$group->groupname}}<a href="#!" onclick="delgroup({{$group->id}})" class="secondary-content"><i class="material-icons" style="color:white">delete</i></a><a href="#addmore{{$group->id}}" class="secondary-content" style="margin-right:20px"><i class="material-icons" style="color:white">add_circle</i></a></div></li>

          @php
          $objs_group = DB::table('hosts')
          ->join('controls', 'hosts.id', '=', 'controls.host_id')
          ->where('controls.user_id', $user_id)
          ->where('controls.group_id', $group->id)
          ->get();
          @endphp
          <li class="collection-item grey lighten-2">
            @foreach($objs_group as $indexKey=>$obj_group)
            <div class="col s12 m6 l3" align="center">
              <div class="card cyan darken-3" style="width:250px">
                <h5 style="padding:10px;color:white">{{$obj_group->servername}}<a href="#!" onclick="leftgroup({{$obj_group->id}})"><i class="material-icons right" style="color:white">remove_circle</i></a></h5>
              </div>
              <div class="card" style="width:250px;">
                <div class="card-image" style="padding:20px">
                  <img src="img/server.png">
                  <span class="card-title" style="color:#263238"><b>{{$obj_group->host}}</b></span>
                </div>
                <div class="card-action white">
                  <a class="modal-trigger waves-effect waves-light btn-large cyan darken-3" onclick="sshLogin({{$obj->id}})"><i class="material-icons left">input</i>Connect</a>
                </div>
              </div>
            </div>

            <form action="{{url('leftgroup')}}" id="leftgroupform{{$obj_group->id}}" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
              <input type="hidden" name="user_id" value="{{ $user_id }}"/>
              <input type="hidden" name="host_id" value="{{ $obj_group->id }}"/>
            </form>
            @endforeach
          </li>

        </ul>
      </div>
    </div>


    <!-- add more hosts -->



    <div class="container" align="left">
      <!-- Page Content goes here -->
      <!-- Modal Structure -->
      <div id="addmore{{$group->id}}" class="modal modal-fixed-footer">
        <div class="modal-content">
          <br>
          <!-- <h5>Add Host</h5> -->
          <!-- <p>You should add host by using rsa key for secure</p> -->
          <!-- <hr class="style-four"><br> -->
          <div class="row">
            <div class="col s1"></div>
            <div class="col s10">
              <div class="row" style="display:block;">
                <form action="{{url('groupaddmore')}}" id="groupaddmoreform" class="col s12" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="user_id" value="{{ $user_id }}">
                  <input type="hidden" name="group_id" value="{{ $group->id }}">
                  <div class="row">
                    <div class="input-field col s2"></div>
                    <div class="input-field input-field2 col s8">
                      <i class="material-icons prefix" style="color:#00bfa5">view_week</i>
                      <input disabled id="icon_prefix" type="text" name="groupname" value="{{$group->groupname}}" style="color:#455a64">
                      <label for="icon_prefix" style="color:#00bfa5">Host's Group Name</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s10 offset-s1">
                      Ungroup Hosts:
                      <ul class="collection scroll">
                        @foreach($objs as $indexKey=>$obj)
                        <li class="collection-item">
                          <div><input type="checkbox" class="filled-in" name="selecthost[]" id="filled-in-box2{{$indexKey+1}}" value="{{$obj->id}}"/><label for="filled-in-box2{{$indexKey+1}}" style="color:#455a64; font-size:13pt">{{$obj->servername}} - {{$obj->host}}</label></div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>

                  <div id="errormsg" class="row" align="center" style="display:none">
                    <i class="material-icons prefix" style="color:#b71c1c">info_outline</i><span style="color:#b71c1c"> Invalid input, please check your informations.</span>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a class="modal-action waves-effect waves-green btn teal" id="submitgroupaddmore" >Add More</a>
        </div>
      </div>
    </div>

    <form action="{{url('delgroup')}}" id="delgroupform{{$group->id}}" method="post" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
      <input type="hidden" name="user_id" value="{{ $user_id }}"/>
      <input type="hidden" name="group_id" value="{{ $group->id }}"/>
    </form>

    @endforeach
    <!--Import jQuery before materialize.js-->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
    <script type="text/javascript">

    var searchby = document.getElementById("searchby");

    $(document).ready(function() {
      // On refresh check if there are values selected
      if (localStorage.selectVal) {
        // Select the value stored
        $('#searchby').val( localStorage.selectVal );
        $('#checksearch').val( localStorage.selectVal );

      }

    });

    function sshLogin(id){

      swal({
        title: 'Host Authentication',
        html:
        '<form action="{{url("sshlogin")}}" id="sshloginform'+id+'" class="col s12" method="post" enctype="multipart/form-data">'+
        '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
        '<input type="hidden" name="user_id" value="{{ $user_id }}">'+
        '<input type="hidden" name="host_id" value="'+id+'">'+
        '<br><div class="row">'+
        '<div class="col s10 m10 l10 offset-s1 offset-m1 offset-l1">'+
        '<div class="input-field input-field2">'+
        '<i class="material-icons prefix">perm_identity</i>'+
        '<input id="icon_prefix" type="text" class="validate" name="login_username">'+
        '<label for="icon_prefix" align="left">Username</label>'+
        '</div>'+
        '<div class="input-field input-field2">'+
        '<i class="material-icons prefix">vpn_key</i>'+
        '<input id="icon_prefix" type="password" class="validate" name="login_password">'+
        '<label for="icon_prefix" align="left">Password</label>'+
        '</div>'+
        '</div>'+
        '</div>'+
        '</form>',
        confirmButtonColor: '#26a69a',
        confirmButtonText: 'Connect',
        showCancelButton: true,
      }).then(function () {
        $("#sshloginform"+id).submit();
        swal({
          imageUrl: 'img/load.gif',
          imageWidth: 120,
          showCancelButton: false,
          showConfirmButton: false,
          animation: false,
          allowOutsideClick: false,
          confirmButtonColor: '#26a69a',
        });
      });
    }

    // On change store the value
    $('#searchby').on('change', function(){
      var currentVal = $(this).val();
      localStorage.setItem('selectVal', currentVal );
    });

    $(document).ready(function() {
      $('select').material_select();
    });

    @if (Session::has('status'))

    function hasmsg(){
      swal({
        title: "{!! Session::get('title') !!}",
        text: "{!! Session::get('text') !!}",
        type: "{!! Session::get('icon') !!}",
        confirmButtonColor: '#26a69a',
      });

    }

    // swal("{!! Session::get('title') !!}","{!! Session::get('text') !!}", "{!! Session::get('icon') !!}");
    @endif

    function loading(){
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

    function leftgroup(id){
      swal({
        title: 'Are you sure?',
        text: "The host will be moved out from this group!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#26a69a',
        confirmButtonText: 'Yes'
      }).then(function () {
        $("#leftgroupform"+id).submit();
        swal({
          imageUrl: 'img/load.gif',
          imageWidth: 120,
          showCancelButton: false,
          showConfirmButton: false,
          animation: false,
          allowOutsideClick: false,
          confirmButtonColor: '#26a69a',
        });
      });
    }

    function delgroup(id){
      swal({
        title: 'Are you sure?',
        text: "The group will be deleted and all hosts in this group will be moved out!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#26a69a',
        confirmButtonText: 'Yes'
      }).then(function () {
        $("#delgroupform"+id).submit();
        swal({
          imageUrl: 'img/load.gif',
          imageWidth: 120,
          showCancelButton: false,
          showConfirmButton: false,
          animation: false,
          allowOutsideClick: false,
          confirmButtonColor: '#26a69a',
        });
      });
    }

    function delhost(id){
      swal({
        title: 'Are you sure?',
        text: "The host will be deleted from the system!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#26a69a',
        confirmButtonText: 'Yes',
      }).then(function () {
        swal({
          title: 'Delete Confirmation',
          html:
          '<form action="{{url("deletehost")}}" id="delhostform'+id+'" class="col s12" method="post" enctype="multipart/form-data">'+
          '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
          '<input type="hidden" name="user_id" value="{{ $user_id }}">'+
          '<input type="hidden" name="host_id" value="'+id+'">'+
          '<br><div class="row">'+
          '<div class="col l10 offset-l1">'+
          '<div class="input-field input-field2">'+
          '<i class="material-icons prefix">perm_identity</i>'+
          '<input id="icon_prefix" type="text" class="validate" name="login_username">'+
          '<label for="icon_prefix" align="left">Username</label>'+
          '</div>'+
          '<div class="input-field input-field2">'+
          '<i class="material-icons prefix">vpn_key</i>'+
          '<input id="icon_prefix" type="password" class="validate" name="login_password">'+
          '<label for="icon_prefix" align="left">Password</label>'+
          '</div>'+
          '</div>'+
          '</div>'+
          '</form>',
          confirmButtonColor: '#26a69a',
          confirmButtonText: 'OK, delete it!',
          showCancelButton: true,
        }).then(function () {
          $("#delhostform"+id).submit();
          swal({
            imageUrl: 'img/load.gif',
            imageWidth: 120,
            showCancelButton: false,
            showConfirmButton: false,
            animation: false,
            allowOutsideClick: false,
            confirmButtonColor: '#26a69a',
          });
        });
      });
    }

    function searchBy(){
      // $searchby = document.getElementById("searchby");
      // $searchopt = searchby.options[searchby.selectedIndex].value;
      //
      // alert($searchopt);
      location.reload();
    }

    //dialogs
    //modal scripts

    $(document).ready(function(){
      // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
      $('.modal').modal();
    });

    function blankSearch() {
      document.getElementById('autocomplete').value = '';
    }

    function byPassword() {
      document.getElementById('byrsakey').style.display = "none";
      document.getElementById('bypassword').style.display = "block";
      $("#password").removeClass('teal accent-4');
      $("#password").addClass('teal darken-3');
      $("#rsakey").removeClass('cyan darken-3');
      $("#rsakey").addClass('cyan darken-1');
    }
    function byRSAKey() {
      document.getElementById('bypassword').style.display = "none";
      document.getElementById('byrsakey').style.display = "block";
      $("#password").removeClass('teal darken-3');
      $("#password").addClass('teal accent-4');
      $("#rsakey").removeClass('cyan darken-1');
      $("#rsakey").addClass('cyan darken-3');
    }

    $("#submitgroup").on('click', function(){
      $("#groupform").submit();
    });

    $("#submitgroupaddmore").on('click', function(){
      $("#groupaddmoreform").submit();
      $('.modal').modal().hide();
      return loading();
    });

    $('#groupform').on('submit', function (e) {
      $idgroupform=document.getElementById('groupform');
      $formgroupname = $idgroupform.elements.namedItem("groupname").value;

      if($("input[type=checkbox]:checked").length === 0 && $formgroupname == ""){
        e.preventDefault();
        swal({
          title: 'Oops...',
          text: "Invalid input, please check your information again !",
          type: 'warning',
          confirmButtonColor: '#26a69a'
        })
        return false;
      }else if ($("input[type=checkbox]:checked").length === 0 ) {
        e.preventDefault();
        swal({
          title: 'Oops...',
          text: "Please choose at least 1 host for joining the group !",
          type: 'warning',
          confirmButtonColor: '#26a69a'
        })
        return false;
      }else if ($formgroupname == ""){
        e.preventDefault();
        swal({
          title: 'Oops...',
          text: "Please check your group's name !",
          type: 'warning',
          confirmButtonColor: '#26a69a'
        })
        return false;
      }else{
        $('#modal2').modal().hide();
        return loading();
      }
    });

    $("#submitbtn").on('click', function(){
      $form1 = document.getElementById('byrsakey').style.display ;
      $form2 = document.getElementById('bypassword').style.display ;
      if($form1 == "block"){
        // alert('Sent form RSA');
        $idform1=document.getElementById('hostform');
        $form1servername = $idform1.elements.namedItem("servername").value;
        $servernamepatt = new RegExp("^[a-zA-Z0-9-@]{1,32}$");
        $resvalidservername1 = $servernamepatt.test($form1servername); //return true or false

        $form1host = $idform1.elements.namedItem("host").value;
        $hostpatt = new RegExp("^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$");
        $resvalidhost1 = $hostpatt.test($form1host);

        $form1port = $idform1.elements.namedItem("port").value;
        $portpatt = new RegExp("^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$");
        $resvalidport1 = $portpatt.test($form1port);

        $form1usrname = $idform1.elements.namedItem("usrname").value;
        $usrnamepatt = new RegExp("^[a-zA-Z0-9-@]{1,32}$");
        $resvalidusrname1 = $usrnamepatt.test($form1usrname);
        if(($form1servername != "") && ($form1host != "") && ($form1port != "") && ($form1usrname != "")){

          if($resvalidservername1 && $resvalidhost1 && $resvalidport1 && $resvalidusrname1){

            document.getElementById('errormsg1').style.display = "none" ;
            $("#hostform").submit();
          }else{
            document.getElementById('errormsg1').style.display = "block" ;
          }
        }else{
          document.getElementById('errormsg1').style.display = "block" ;
        }



      }else if($form2 == "block"){

        $idform2=document.getElementById('hostform2');
        $form2servername = $idform2.elements.namedItem("servername").value;
        $servernamepatt = new RegExp("^[a-zA-Z0-9-@]{1,32}$");
        $resvalidservername = $servernamepatt.test($form2servername); //return true or false

        $form2host = $idform2.elements.namedItem("host").value;
        $hostpatt = new RegExp("^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$");
        $resvalidhost = $hostpatt.test($form2host);

        $form2port = $idform2.elements.namedItem("port").value;
        $portpatt = new RegExp("^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$");
        $resvalidport = $portpatt.test($form2port);

        $form2usrname = $idform2.elements.namedItem("usrname").value;
        $usrnamepatt = new RegExp("^[a-zA-Z0-9-@]{1,32}$");
        $resvalidusrname = $usrnamepatt.test($form2usrname);

        $form2password = $idform2.elements.namedItem("password").value;
        $passwordpatt = new RegExp("^[a-z0-9]{6,}$");
        $resvalidpassword = $passwordpatt.test($form2password);

        if(($form2servername != "") && ($form2host != "") && ($form2port != "") && ($form2usrname != "") && ($form2password != "")){

          if($resvalidservername && $resvalidhost && $resvalidport && $resvalidusrname && $resvalidpassword){

            document.getElementById('errormsg').style.display = "none" ;
            $("#hostform2").submit();
          }else{
            document.getElementById('errormsg').style.display = "block" ;
          }
        }else{
          document.getElementById('errormsg').style.display = "block" ;
        }
      }
    });


    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET", "search/"+localStorage.getItem("selectVal"), false);
    xmlhttp.send();
    var hosts = JSON.parse(xmlhttp.responseText);
    // { value: 'Andorra', data: 'AD' },
    // // ...
    // { value: 'Zimbabwe', data: 'ZZ' }

    $('#autocomplete').autocomplete({
      lookup: hosts,
      onSelect: function (item) {
        // $("#searchform").submit();
        // alert('You selected: ' + item.value);
      }
    });
    </script>
  </body>
  </html>
  <!-- document.location.href = "testload"; -->
