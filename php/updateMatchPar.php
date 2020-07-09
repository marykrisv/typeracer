<?php

session_start();

require("db_connect.php");

$sql = "update matches set mmParId = {$_SESSION['par_id']} where mId = {$_SESSION['match_id']}";

$result = $conn->query($sql);
foreach ($result as $res) {
	if ($res["playUserId"] == $_SESSION['user_id']) {
		echo 'win';
	} else {
		echo 'loss';
	}
}

?>
