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
        <li class="current"><em>1</em>检测环境</li>
        <li><em>2</em>创建数据</li>
        <li><em>3</em>完成安装</li>
      </ul>
    </div>
    <div class="server">
      <table width="100%">
        <tr>
          <td class="td1">环境检测</td>
          <td class="td1" width="25%">推荐配置</td>
          <td class="td1" width="25%">当前状态</td>
          <td class="td1" width="25%">最低要求</td>
        </tr>
        <tr>
          <td>操作系统</td>
          <td>类UNIX</td>
          <td><span class="correct_span">&radic;</span> <?php echo $os; ?></td>
          <td>不限制</td>
        </tr>
        <tr>
          <td>PHP版本</td>
          <td>>5.6.x</td>
          <td><span class="correct_span">&radic;</span> <?php echo $phpv; ?></td>
          <td>5.3.0</td>
        </tr>
        <tr>
          <td>Mysql版本（client）</td>
          <td>>5.x.x</td>
          <td><?php echo $mysql; ?></td>
          <td>4.2</td>
        </tr>
        <tr>
          <td>附件上传</td>
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
          <td class="td1">目录、文件权限检查</td>
          <td class="td1" width="25%">写入</td>
          <td class="td1" width="25%">读取</td>
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
    <div class="bottom tac"> <a href="./index.php?step=2" class="btn">重新检测</a><a href="javascript:void(0);" onclick="verifyConfig();" class="btn">下一步</a> </div>
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