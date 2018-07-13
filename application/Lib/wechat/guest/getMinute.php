<?php
// 记录每次的登录日志（还有检查是否有登记记录的作用）

session_start();

require_once("unifi/controller.php");
require_once('config/mysql.php');


if($_SERVER['REQUEST_METHOD'] != 'POST'){
	// die("only allow post method");
}

$macid = $_SESSION['macid'];


//$myfile = fopen("newfile.txt", "a+") or die("Unable to open file!");
//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//fwrite($myfile,  date("Y-m-d h:i:sa"). "\n".$_SESSION['id']. "\n".$_SESSION['ssid']. "\n".$_SESSION['ap']. "\n". $_SESSION['macid']."\n");
//fclose($myfile);




// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

	
	$sql = "SELECT * FROM weixin_table where Mac_ID='". $macid ."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {		
		$n =null;
		while($row = $result->fetch_assoc()) {
			$n=$row["fromUserName"];
		}
	
		//$sql = "INSERT INTO log (Mac_ID, created_at,fromUserName)VALUES ('".$_SESSION['macid']."',now(),'".$n."')";
		$sql = "INSERT INTO log (Mac_ID, created_at,fromUserName,ap)VALUES ('".$_SESSION['macid']."',now(),'".$n."','".$_SESSION['ap']."')";
		if ($conn->query($sql) === TRUE) {
					//echo $sql;
					
			//不能少UniFi Guest Control 登录		
			$controller = new Controller();
			$controller->sendAuthorization($macid, 2);
			
			// 转到微信授权页面
			echo json_encode(array('success' => true));			
		}

	} else {
		//echo "no data";
		//weixin_table 没有记录 转到 登记页面
		echo json_encode(array('success' => false));
	}	
	

$conn->close();


