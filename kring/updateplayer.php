<?php
session_start();
$connection = mysqli_connect("localhost","root","","typeracer") or die ("ERROR" .mysqli_error($connection));
$margin = $_POST['margin'];

echo "margin".$margin;

$sql = "update players set playMargin = ".$margin." where playUserId = {$_SESSION['user_id']} and playMatchId = {$_SESSION['match_id']}";
echo $sql;

$result = mysqli_query ($connection, $sql) or die ("ERROR" .mysqli_error($connection));

mysqli_close($connection);
?>
