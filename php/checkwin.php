<?php

session_start();

require("db_connect.php");

$sql = "select * from players where playMatchId = {$_SESSION['match_id']} and playResult='win'";

$result = $conn->query($sql);
foreach ($result as $res) {
	if ($res["playUserId"] == $_SESSION['user_id']) {
		echo 'win';
	} else {
		echo 'loss';
	}
}

?>
