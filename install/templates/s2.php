<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title><?php echo $Title; ?> - <?php echo $Powered; ?></title>
<link rel="stylesheet" href="/install/css/install.css?v=9.0" />
</head>
<body>
<div class="wrap">
  <?php require './templates/header.php';?>
  <section class="section">
    <div class="step">
      <ul>
        <li class="current"><em>1</em><?php echo $dictionary['environment'];?></li>
        <li><em>2</em><?php echo $dictionary['server'];?></li>
        <li><em>3</em><?php echo $dictionary['installation'];?></li>
      </ul>
    </div>
    <div class="server">
      <table width="100%">
        <tr>
          <td class="td1"><?php echo $dictionary['check']; ?></td>
          <td class="td1" width="25%"><?php echo $dictionary['recommended']; ?></td>
          <td class="td1" width="25%"><?php echo $dictionary['current']; ?></td>
          <td class="td1" width="25%"><?php echo $dictionary['at_least']; ?></td>
        </tr>
        <tr>
          <td><?php echo $dictionary['os']; ?></td>
          <td>类UNIX</td>
          <td><span class="correct_span">&radic;</span> <?php echo $os; ?></td>
          <td>不限制</td>
        </tr>
        <tr>
          <td><?php echo $dictionary['php']; ?></td>
          <td>>5.6.x</td>
          <td><span class="correct_span">&radic;</span> <?php echo $phpv; ?></td>
          <td>5.3.0</td>
        </tr>
        <tr>
          <td><?php echo $dictionary['mysql']; ?></td>
          <td>>5.x.x</td>
          <td><?php echo $mysql; ?></td>
          <td>4.2</td>
        </tr>
        <tr>
          <td><?php echo $dictionary['upload_file']; ?></td>
          <td>>2M</td>
          <td><?php echo $uploadSize; ?></td>
          <td>不限制</td>
        </tr>
        <tr>
          <td>session</td>
          <td>开启</td>
          <td><?php echo $session; ?></td>
          <td>开启</td>
        </tr>

      </table>
      <table width="100%">
        <tr>
          <td class="td1"><?php echo $dictionary['directory']; ?></td>
          <td class="td1" width="25%"><?php echo $dictionary['read']; ?></td>
          <td class="td1" width="25%"><?php echo $dictionary['write']; ?></td>
        </tr>
<?php
foreach($folder as $dir){
     $Testdir = SITEDIR.$dir;
     dir_create($Testdir);
    $read='';
    $write='';
    $flag = false;
	 if(TestWrite($Testdir)){
	     $w = '<span class="correct_span">&radic;</span>可写 ';
	 }else{
         $write = '写';
	     $w = '<span class="correct_span error_span">&radic;</span>不可写 ';
		 $err++;
         $flag = true;;
	 }
	if(is_readable($Testdir)){
	     $r = '<span class="correct_span">&radic;</span>可读' ;
	 }else{
         $read ='读';
	     $r = '<span class="correct_span error_span">&radic;</span>不可读';
		 $err++;
         $flag = true;;
	 }
     if($flag)
            $Errors[] = '目录'.$Testdir.'没有'.$read.$write.'权限!';;
?>
        <tr>
          <td><?php echo $dir; ?></td>
          <td><?php echo $w; ?></td>
          <td><?php echo $r; ?></td>
        </tr>
<?php
}
?>   
      </table>
    </div>
    <div class="bottom tac"> <a href="./index.php?step=2" class="btn"><?php echo $dictionary['recheck'];?></a><a href="javascript:void(0);" onclick="verifyConfig();" class="btn"><?php echo $dictionary['next'];?></a> </div>
  </section>
</div>
<?php require './templates/footer.php';?>
<!--<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/layer/2.1/layer.js"></script>
-->
<script src="/install/js/jquery.min.js"></script>
<script src="/install/js/layer.js"></script>
<script>

    function verifyConfig(){
        var flag = "<?php echo $err;?>";

        if(flag>0){
            var List = "<center style='margin-top:10px;color:red;'>请解决以下问题:</center><div style='margin:0 auto;margin-left:40px;margin-top:10px;font-size:14px;'><?php
                foreach($Errors as $k=>$v){
                    echo ($k+1).'.'.$v.'<br/>';
                } ?></div>";
            //页面层
            layer.open({
                type: 1,
                skin: 'layui-layer-rim', //加上边框
                area: ['420px', '248px'], //宽高
                content: List,
            });
        }else if(flag==0){
            window.location.href='./index.php?step=3';
        }

    }


</script>
</body>
</html>