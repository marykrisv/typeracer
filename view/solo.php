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
<head>
  <meta charset="utf-8">
  <title>TYPERACER</title>
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<style>
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
    height:40px;
  }

  .car {
    width:80px;
    height:50px;
    padding:10px;
  }

</style>

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
<body class="solo">
  <audio src="game.mp3" autoplay loop>
<p>If you are reading this, it is because your browser does not support the audio element.     </p>
<embed src="game.mp3" width="180" height="90" hidden="true" />
</audio>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="row">
          <div class="col-md-12">
            <div class="play-area">
              <div class="wpm-area">

              </div>
              <div class="text-area">
                <div id="div01">
                  <!-- <span class="done"></span>
                  <span class="correctWord"></span>
                  <span class="currentWord"></span>
                  <span class="notdone1"></span> -->
                </div>
              </div>
              <div class="progress-area">
                <div>
                  <p id="p02" style="margin-left: 2px;" pos="2">
                    <img class = "car" src="../car.png">
                  </p>
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
</body>

<div class="modal fade gameStartTimer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <span>Game Starts in</span>
        <span class="cntdown">2</span>
      </div>
    </div>
  </div>
</div>

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
		//get random paragraph
		// $.ajax({
		// 	url : "../php/getparagraph.php",
		// 	success : function (retval) {
		// 		$(".notdone1").text(retval+" ");
		// 	}
		// });
    var notDoneWords = [],
        winStatus = 0,
        WPMtimer = null,
        time = 1,
        currentIdx = 0,
        characterCount = 0,
        charIdx = 0;

    $.ajax({
      url:"../php/getparagraph1.php",
      dataType: "json",
      success: function(res){
        charCount = res.paragraph.length;
        par_id = res.id;
        notDoneWords = res.paragraph.split(" ");
        currentIdx = 0;
        var characters = res.paragraph.split("");

        $("#div01").attr("parId",res.id);

        $("#div01").append('<span class="character current">'+characters[0]+'</span>');
        for(x=1;x<characters.length-1;x++){
          $(".text-area").find("#div01").append('<span class="character">'+characters[x]+'</span>')
        }
        $("#div01").append('<span class="character last">'+characters[characters.length-1]+'</span>');
      }
    })
    gameStartTimer();
    function gameStartTimer(){
        $(".gameStartTimer.modal").modal({
          backdrop: 'static',
          keyboard: false,
        });
        $(".type-area input").prop("disabled",true).focus();
        var countdown = setInterval(function(){
          var sec = parseInt($(".gameStartTimer").find(".cntdown").text());
          sec--;
          $(".gameStartTimer").find(".cntdown").text(sec);
          // console.log($(".gameStartTimer").find(".cntdown").text());
          if(sec == 0){
            $(".modal.gameStartTimer").modal("hide");
            $(".type-area input").prop("disabled",false).focus();
            clearInterval(countdown);
          }
        },1000);
        // $(".gameStartTimer").find(".cntdown").text(x);
    }

    function getWPM(){
      clearInterval(WPMtimer);
      var wpm = Math.ceil((notDoneWords.length/time)*60);
      var par = $("#div01").attr("parId");
      alert("YOUR WPM IS: "+wpm);
      // $.ajax({
      //   url:"../php/saveScore.php",
      //   data: {score: wpm, par: par },
      //   type: "post",
      //   success: function(res){
      //     if(res == "SUCCESS"){
      //       alert("SAVED");
      //     }else{
      //       alert("NOT SAVED");
      //     }
      //   }
      // });
    };

    var inter = 0;

    $("#i01").on('input',function(e){
      var typed = $(".type-area input").val();
      var typedLetter = typed.substring(typed.length-1);
      currentWord = notDoneWords[currentIdx];
      cLength = currentWord.length;
      if(WPMtimer == null){
        WPMtimer = setInterval(function(){
           time++;
        },1000);
      }
      if(charIdx % 5 == 0 && charCount != 0 && charIdx < charCount){
        charIdx++;
        var wpm = (charIdx / time)*60;
        console.log("WPM: "+wpm+" CHARIDX:"+charIdx+"CHARCOUNT:"+charCount);
      }

      // console.log(typedLetter);
      // console.log(notDoneWords.length);
      if(currentIdx < notDoneWords.length){
        if((typedLetter == $(".current").text()) && (typed.length <= cLength) && (typed.substring(0,typed.length) == currentWord.substring(0,typed.length))){
          var nextChar = $(".current").next();

          $(".current").addClass("correct").removeClass("typo");

          if($(".current").hasClass("last") == true){
            alert("WON");
            $(".type-area input").prop("disabled",true);
            getWPM();
          }else{
            $(".current").removeClass("current");
            nextChar.addClass("current");
          }

        }else if((typedLetter == $(".current").text()) && $(".current").text() == " "){
          var nextChar = $(".current").next();
          $(".type-area input").val("");
          currentIdx++;
          $(".current").addClass("done");
          $(".current").removeClass("current");
          nextChar.addClass("current");

          

          updateMargin();

        }else{
          $(".current").addClass("typo");
        }
      }
    });

    function updateMargin () {
      var margin = $("#div01").css("width");

      var sentence = $("#div01").text();
      var words = sentence.split(" ");
      var count = words.length;

      inter = parseInt(margin)/parseInt(count-33);

      var marg = $("#p02").attr("pos");
      var margInt = parseInt(marg)+inter;

      $("#p02").attr("pos", margInt);
      $("#p02").attr("style", "margin-left: "+margInt+"px");

    }
		// $("#i01").keyup(function () {
    //
		// 	notdone = $(".notdone1").text();
		// 	complete = $("#div01").text();
    //
    //   notDoneWords = notdone.split(" ");
    //   curNotDoneWord = notDoneWords[0];
    //
		// 	typed = $("#i01").val();
		// 	i = typed.length;
		// 	c = $(".notdone1").text().substring(0,i);
    //   console.log(typed+" "+c);
    //   console.log("curLetter: "+typed.substring(i,1));
    //   // if(typed.substring(i,1) == )
		// 	if (c == typed) {
		// 		$("#i01").attr("style", "color:black");
		// 		if (c.indexOf(' ') != -1 && typed.indexOf(' ') != -1) {
		// 			$("#i01").val("");
		// 			var ind = typed.indexOf(' ');
    //
		// 			done += c.substring(0, ind+1);
		// 			$("#i01").val(c.substring(ind+1, c.length));
		// 			notdone = complete.replace(done, "");
		// 			var newp = "<span class='done'>"+done+"</span><span class='notdone1'>"+notdone+"</span>";
    //
		// 			var marg = $("#p02").attr("pos");
		// 			var margInt = parseInt(marg)+50;
    //
    //
		// 			$("#p02").attr("pos", margInt);
		// 			$("#p02").attr("style", "margin-left: "+margInt+"px");
		// 		}
		// 	} else {
		// 		$("#i01").attr("style", "color:red");
		// 	}
    //
		// 	$("#div01").html(newp);
		// 	if (notdone == "") {
		// 		alert("all done");
		// 		//$("#i01").addAttr("disabled", "true");
		// 	}
    //
		// });


	});
</script>
