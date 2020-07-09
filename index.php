<?php
  session_start();
  if(isset($_SESSION['username'])){
    header("Location:view/dashboard.php");
  }
  require("php/db_connect.php");

  if(isset($_POST['username']) && !empty($_POST['username']) && !empty($_POST['password'])){

    $sql = "SELECT * FROM user WHERE username='{$_POST["username"]}' && password='{$_POST["password"]}'";
    $result = $conn->query($sql);
    if($result->num_rows == 1){
      $row = mysqli_fetch_assoc($result);

      $_SESSION['username'] = $row['username'];;
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['role'] = $row['role'];
      if($row['role'] == 'admin'){
        header("Location:view/adminPage.php");
      }else{
        header("Location:view/dashboard.php");
      }

    }else{
      $fieldError = "You have entered an invalid username or password";
    }
  }

?>
<html>
  <head>
    <meta charset="utf-8">
    <title>TYPERACER</title>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="title">
          <span>TYPERACER</span>
        </div>
      </div>
      <div class="col-md-3 col-md-offset-3 login-panel">
        <div class="well">
          <!-- login form -->
          <form id="login_form" class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
            ?>" method="post">
            <fieldset>
              <div class="form-group">
                <label class="control-label" for="username">Username</label>
                <input class="form-control" id="username" type="text" name="username" value="">
              </div>
              <div class="form-group">
                <label class="control-label" for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" value="">
              </div>
              <div class="form-group">
                <button class="btn btn-primary" type="submit" name="login" id="login">LOGIN</button>
                <a id="signupbtn-modal">Sign-up</a>
                <?php if(isset($fieldError)){ ?>
                <div class="alert alert-dismissible alert-danger">
                  <strong>Invalid username/password!</strong>
                </div>
              <?php }?>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
    </div>

  </div>

  <div class="modal fade" id="signup-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <form class="" action="index.html" method="post">
          <fieldset>
            <div class="row form-group username">
              <label class="control-label" for="username">Create Username</label>
              <input class="form-control" id="sUname" type="text" name="username" value="">
            </div>
            <div class="row form-group password">
              <label class="control-label" for="password">Create Password</label>
              <input class="form-control" id="sPassword" type="password" name="password" value="">
            </div>

          </fieldset>

      </div>
      <div class="modal-footer">
        <div class="form-group signup">
          <button class="btn btn-success" type="submit" name="register" id="signup">SIGN UP</button>
          <button class="btn btn-default" type="button" name="button" data-dismiss="modal">CLOSE</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
  </body>
</html>
<script>
$(document).ready(function(){
  var request;

  $("#signupbtn-modal").click(function(){
    $("#signup-modal").modal("toggle");
  });

  $("#signup").click(function(e){
    e.preventDefault();
    var username = $("#sUname").val();
    var password = $("#sPassword").val();
    $.ajax({
      url:"php/signup.php",
      type: "POST",
      data: {username:username, password:password},
      success: function(res){
        if(res == "SUCCESS"){
          alert("You are now registered");
          $(".modal#signup-modal").modal("toggle");
        }else{
          alert("Failed to signup");
        }
      }
    })

  })
});
</script>
