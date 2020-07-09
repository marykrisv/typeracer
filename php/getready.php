<?php
session_start();
require("db_connect.php");

$sql = "select * from matches where mStatus = 'waiting' LIMIT 1";
$result = $conn->query($sql);
//found

// foreach ($result as $res) {
// 	$sql = "insert into players values (null, {$res->mId}, 2, {$_SESSION['user_id']}, 'calibrating', 0)";
// 	$result = $conn->query($sql);
// }
$mId = 0;
$parId = 0;

if ($result->num_rows == 0){
	$sql = "SELECT * FROM paragraph ORDER BY RAND() LIMIT 1";
	$result = $conn->query($sql);
	foreach ($result as $res) {
		$parId = $res['id'];
	}

	$sql = "insert into matches values (null, null, ".$parId.", 'waiting')";
	$result = $conn->query($sql);

	$mId = $conn->insert_id;

	$sql = "insert into players values (null, {$mId}, 1, {$_SESSION['user_id']}, 'calibrating', 0)";
	$result = $conn->query($sql);

	$_SESSION['player'] = 1;
	echo 1;

}else{

	foreach($result as $res){
		$mId = $res['mId'];
	}
	print_r($mId);
	$sql = "insert into players values (null, {$mId}, 2, {$_SESSION['user_id']}, 'calibrating', 0)";
	$result = $conn->query($sql);
	print_r($result);

	$sql = "UPDATE matches SET mStatus = 'playing' WHERE mId = {$mId}";
	$conn->query($sql);

	$_SESSION['player'] = 2;

	echo 2;

}

$_SESSION['match_id'] = $mId;


// $sql = "update user set status = 'ready' where id = {$_SESSION['user_id']}";
// $result = $conn->query($sql);
// if ($result) {
// 	echo 1;
// } else {
// 	echo 0;
// }

?>
