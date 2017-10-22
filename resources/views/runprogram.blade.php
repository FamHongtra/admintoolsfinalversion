
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>

  <!-- <a href="webrun:d:\downloads\putty.exe">Notepad</a> -->




  result: <br><textarea name="result" rows="8" cols="80">{{ session()->get('result') }}</textarea><br>

  <form class="" id="execform" action="{{url('executecommand')}}" method="get">
    <input type="text" name="commandline" id="command" value="">
    <button type="button" onclick="sendCmd()" name="button">execute command</button>
  </form>


  <script type="text/javascript">
  function sendCmd(){
    var command = document.getElementById('command').value ;
    document.getElementById("execform").submit();

  }
  </script>
</body>
</html>
