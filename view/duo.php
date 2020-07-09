<?php
session_start();
// echo $_SESSION['username'];
if(isset($_SESSION['username'])){

}else{
 header("Location:../index.php");
}

 ?>
<!DOCTYPE html>
<html>
<style>
	.notdone1 {
		color:blue;
	}
	.done {
		color:green;
	}

	#p01 {
		margin-left: 2px;
	}

	#p02 {
		margin-left: 2px;
	}
  .current{
    text-decoration: underline;
  }
  .notdone1 , .done {
    font-size: 20px;
  }
  .correct{
    color:green;
  }
  .typo{
    color: red;
  }
  .done {
    color:green;
  }
  .notdone1{
    color:black;
  }
  .play-area{
    margin-top: 100px;
    padding:30px;
    background-color: #c1c1c1;
    border-radius:3px;
  }
  .play-area .text-area{
    font-size: 20px;
    font-color: black;
  }
  .text-area .currentWord{
    margin-left:-5px;
  }
  .currentWord , .currentLetter{
    text-decoration: underline;
  }
  .play-area .progress-area{
    height:150px;
  }
  .car {
    width:80px;
    height:50px;
    margin:5px;
  }
</style>
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
<embed src="game.mp3" width="180" height="90" hidden="true" />
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="row">
          <div class="col-md-12">
            <div class="play-area">
              <div class="wpm-area">
              </div>
              <div class="text-area">
                <div id="div01"><span class="notdone1"></span></div>
              </div>
              <div class="progress-area">
                <div>
                	<img id = "p01" src="../car.png" class="car">
                </div>
                <div>
                	<img id = "p02" src="../car.png" class="car">
                </div>
              </div>
              <div class="type-area">
                <input class="form-control" type="text" id="i01">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <input type="text" id="player" value="<?php echo $_SESSION['player']?>">
	<!-- <div id="div01"><span class="notdone1">the quick brown fox jumps over the lazy dog </span></div>
	<div><p id="p01">CAR</p></div>
	<div><p id="p02">CAR</p></div>
	<input type="text" id="i01"> -->

	<audio src="game.mp3" autoplay loop>
<p>If you are reading this, it is because your browser does not support the audio element.     </p>
</body>
</html>

<script>
	var s = $("#p01").text();
	var i = 1;
	var c = "";
	var typed = "";
	var done = "";
	var notdone = "";
	var complete = "";

	$(document).ready(function () {
		var x;
		var players = ["p01",  "p02"];
		x = setInterval(function () {
			$.ajax({
				url : "../kring/getplay.php",
				success : function (retval) {
					var arr = JSON.parse(retval);
	                for (var i = 0; i < arr.length; i++) {
	                    p = parseInt(arr[i]['playMargin']);
	                    $("#"+players[i]).css("margin-left", p);
	                }
				}
			});
		}, 100);

		var checkwin = setInterval(function () {
			$.ajax({
				url : "../php/checkwin.php",
				success : function (retval) {
					if (retval == 'win') {
						clearInterval(checkwin);
						clearInterval(x);
						alert("congrats you won!");

						window.location.href = "gamehistory.php";
					} else if (retval == 'loss') {
						clearInterval(checkwin);
						clearInterval(x);
						alert("sorry you loss!");

						window.location.href = "gamehistory.php";
					}
				}

			});
		}, 100);

		//get random paragraph
		$.ajax({
			url : "../php/getparagraph.php",
      dataType: "json",
			success : function (retval) {

  				var s = retval.paragraph;
  				$(".notdone1").text(s+" ");
				}
		});



		$("#i01").keyup(function () {

			notdone = $(".notdone1").text();
			complete = $("#div01").text();

			typed = $("#i01").val();
			i = typed.length;
			c = $(".notdone1").text().substring(0,i);

			if (c == typed) {
				$("#i01").attr("style", "color:black");
				if (c.indexOf(' ') != -1 && typed.indexOf(' ') != -1) {
					$("#i01").val("");
					var ind = typed.indexOf(' ');

					done += c.substring(0, ind+1);

					$("#i01").val(c.substring(ind+1, c.length));
					notdone = complete.replace(done, "");
					var newp = "<span class='done'>"+done+"</span><span class='notdone1'>"+notdone+"</span>";



					updateMatch($("#player").val());
				}
			} else {
				$("#i01").attr("style", "color:red");
			}

			$("#div01").html(newp);
			if (notdone == "") {
				//update to win and the other one lose

				win();
				//$("#i01").addAttr("disabled", "true");
			}

		});

		function win () {
			$.ajax({
				url : "../php/win.php",
				success : function (retval) {
				}
			});
		}

		var inter = 0;

		function updateMatch (player) {
			var url = "../kring/updateplayer.php";
			var margin = 0;

			var margin = $("#div01").css("width");

	      var sentence = $("#div01").text();
	      var words = sentence.split(" ");
	      var count = words.length;

	      inter = parseInt(margin)/parseInt(count);


			if (player == '1') { //player 1
				margin = parseInt($("#p01").css("margin-left"));
			} else if (player == '2') { //player 2
				margin = parseInt($("#p02").css("margin-left"));
			}

			margin += inter;
			margin = Math.abs(margin);

			$.ajax({
				url : url,
				data : {margin:margin},
				method : "POST",
				success : function (retval) {
				}
			});
		}
	});
</script>
