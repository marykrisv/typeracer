<?php
session_start();
// echo $_SESSION['username'];
if(isset($_SESSION['username'])){

}else{
 header("Location:../index.php");
}
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>TYPERACER</title>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#"><span>typeracer</span></a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="/typeracer/view/dashboard.php">Home</a></li>
        <?php if ($_SESSION['role'] == 'admin') { ?>
          <li><a href="/typeracer/view/adminPage.php">Paragraph</a></li>
          <li><a href="/typeracer/view/adminPage.php">User</a></li>
        <?php }  ?>

        <li><a href="/typeracer/view/gamehistory.php">Game History</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li> <a href="../php/logout.php" class="">LOGOUT</a> </li>
      </ul>
    </div>
  </nav>
  <body>


    <div class="container" id="home">
      <div class="row">
        <div class="col-md-12">
            <h1 class="mode-header">CHOOSE GAME MODE</h1>
            <div class="row">
              <div class="col-md-6">
                <div class="solomode">
                  <div class="gamemode">
                    <img src="../assets/solo.png">
                  </div>
                  <form action = "../view/solo.php">
                    <button type="submit"><h2 id="solo" style="color:black">GO SOLO</h2></button>
                  </form>

                </div>
              </div>
              <div class="col-md-6">
                <div class="pvpmode">
                  <div class="gamemode">
                    <img src="../assets/pvp.png">
                  </div>
                  <form action = "../view/duo.php" id="formduo">
                    <button id="duo" type ="submit"><h2 style="color:black">MATCH</h2></button>
                  </form>

                </div>
            </div>

        </div>

      </div>
    </div>
    <div class="container" id="singleplayer">

    </div>
    <div class="container" id="multiplayer">

    </div>
    <audio src="choose.mp3" autoplay loop>
<p>If you are reading this, it is because your browser does not support the audio element.     </p>
<embed src="choose.mp3" width="180" height="90" hidden="true" />
  </body>
</html>

<script>

  $(document).ready(function () {



    //check if already in match
    var checkwin = setInterval(function () {
      $.ajax({
        url : "../php/findmatch.php",
        success : function (retval) {
          if (retval == "stop") {
            window.location.href = "duo.php";
          }

        }

      });
    }, 100);

    //findmatch();

    $("#duo").on("click", function (e) {
      e.preventDefault();
      $(this).prop("disabled",true);
      ready();
    });

    function ready() {
      $.ajax({
        url : "../php/getready.php",
        success : function (retval) {
          console.log("player "+retval);
        }
      });
    }

    function findmatch () {
      var cnt = 0;
      var x = setInterval(function () {
        $.ajax({
          url : "../php/findmatch.php",
          success : function (retval) {
            if (retval == 'stop') {
              //go to the duo match

            }
          }
        });
      }, 500);
    }

    // function startMatch () {
    //   $.ajax({
    //       url : "../php/creatematch.php",

    //       success : function (retval) {
    //         if (retval != '0') {

    //         }
    //       }
    //     });
    // }
  });


</script>
