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

$sql = "INSERT INTO weixin_table (Mac_ID, created_at)
VALUES ('John', date('Y-m-d'))";

if ($conn->query($sql) === TRUE) {
   // echo "新记录插入成功";
} else {
  //  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 