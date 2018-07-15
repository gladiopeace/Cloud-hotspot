<?php

$servername = "192.168.0.134";
$username = "root";
$password = "123";
$dbname = "unifi";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$macid = $_SESSION['macid'];

if (0) {
	
	$sql = "INSERT INTO weixin_table (Mac_ID, created_at,fromUserName)VALUES ('".$_SESSION['macid']."',now(),'".$_SESSION['ap'] ."')";

	if ($conn->query($sql) === TRUE) {
	   // echo "新记录插入成功";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
}else{
	
	$sql = "SELECT * FROM weixin_table where Mac_ID='". $macid ."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// 输出每行数据
		while($row = $result->fetch_assoc()) {
			echo "<br> Host: ". $row["id"];
			echo "<br>".$sql;
		}
	} else {
		echo "false";
	}	
	
}


$conn->close();
?>