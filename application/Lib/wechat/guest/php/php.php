<?php
$servername = "192.168.0.134";
$username = "abc";
$password = "123";
$dbname = "mysql";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出每行数据
    while($row = $result->fetch_assoc()) {
        echo "<br> Host: ". $row["Host"]. " - Name: ". $row["User"]. "- Password: " . $row["Password"];
    }
} else {
    echo "0 个结果";
}
$conn->close();
?>