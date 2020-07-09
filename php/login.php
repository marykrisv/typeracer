<?php

// require("db_connect.php");
//
// if(isset($_POST['username']) && !empty($_POST['username']) && !empty($_POST['password'])){
//
//   $sql = "SELECT * FROM user WHERE username='{$_POST["username"]}' && password='{$_POST["password"]}'";
//   $result = $conn->query($sql);
//   if($result->num_rows == 1){
//     session_start();
//     print_r($result);
//     $row = mysqli_fetch_assoc($result);
//     print_r($row);
//     print_r($row['username']);
//     $_SESSION['username'] = $row['username']->username;
//     $_SESSION['user_id'] = $row['id']->user_id;
//
//     echo $_SESSION['username'];
//     // header("Location:view/dashboard.php");
//   }else{
//     $fieldError = "You have entered an invalid username or password";
//   }
// }

?>
