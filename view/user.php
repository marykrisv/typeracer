<?php
  session_start();
  include("../php/db_connect.php");
  if(!isset($_SESSION['username'])){
    header("Location:dashboard.php");
  }

  $sql = "SELECT * FROM user";

  $pResult = $conn->query($sql);



?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>admin dashboard</title>
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
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>PARAGRAPHS</h2>
        
        <table class="table table-striped table-hover par-table">
          <thead>
            <tr>
              <th>Role</th>
              <th>Username</th>
            </tr>
          </thead>
          <tbody>
            <?php if($pResult->num_rows > 0){
                    while($row = mysqli_fetch_assoc($pResult)){
            ?>
            <tr>
              <td><?php echo $row['role'] ?></td>
              <td><?php echo $row['username'] ?></td>
              <td><button class="btn btn-danger delete" type="btn btn-danger delete">DELETE</button></td>
            </tr>
            <?php
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </body>

  <div class="modal fade addParagraphModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Add Paragraph</h4>
          </div>
          <div class="modal-body">
            <label for="paragraph-text">Enter paragraph text:</label>
            <textarea class="form-control paragraph-text" rows="4" cols=""></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary submitParagraph">Add paragraph</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
  </div>
</html>
<script type="text/javascript">
$(document).ready(function(){
  $(".addParagraph").click(function(){
    $(".addParagraphModal").modal("toggle");
  })
  $(".submitParagraph").click(function(){
    var paragraph = $(".paragraph-text").val();
    console.log(paragraph);
    $.ajax({
      url: "../php/addParagraph.php",
      type: "POST",
      data: {paragraph: paragraph},
      success: function(res){
        if(res != "FAILED"){
          console.log(paragraph);
          alert("Paragraph is added");
          $(".addParagraphModal").modal("toggle");
          $(".par-table").find("tbody").append('<tr> <td class="par-id" id="'+res+'">'+res+'</td><td class="par-text">'+paragraph+'</td><td> <button class="btn btn-danger delete" name="button">DELETE</button> </td></tr>')
        }else{
          alert("Failed to add paragraph");
        }
      }
      })
  });
  $(".delete").click(function(){
    var id = $(this).parent().parent().find(".par-id").attr('id');
    console.log(id);
    $.ajax({
      url: "../php/deleteParagraph.php",
      type: "POST",
      data: {id: id},
      success: function(res){
        if(res == "DELETED"){
          alert("Paragraph is deleted");
          $(".par-id#"+id).closest("tr").remove();
        }else{
          alert("Failed to delete");
        }
      }
    });
  })
})
</script>
