<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title><?php echo $Title; ?> - <?php echo $Powered; ?></title>
<link rel="stylesheet" href="./css/install.css?v=9.0" />
<script src="./js/jquery.js?v=9.0"></script> 
</head>
<body>
<div class="wrap">
  <?php require './templates/header.php';?>
  <section class="section">
    <div class="step">
      <ul>
        <li class="on"><em>1</em><?php echo $dictionary['environment'];?></li>
        <li class="on"><em>2</em><?php echo $dictionary['server'];?></li>
        <li class="current"><em>3</em><?php echo $dictionary['installation'];?></li>
      </ul>
    </div>
    <div class="install" id="log">
      <ul id="loginner">
      </ul>
    </div>
    <div class="bottom tac"> <a href="javascript:;" class="btn_old"><img src="./images/install/loading.gif" align="absmiddle" />&nbsp;<?php echo $dictionary['installing']?>...</a> </div>
  </section>
  <script type="text/javascript">
var n=0;
    var data = <?php echo json_encode($_POST);?>;
    $.ajaxSetup ({ cache: false });
    function reloads(n) {
        var url =  "./index.php?step=4&install=1&n="+n;
        $.ajax({
            type: "POST",		
            url: url,
            data: data,
            dataType: 'json',
            beforeSend:function(){
            },
            success: function(msg){
                if(msg.status=='success'){
                    $('#dosubmit').attr("disabled",false);
                    $('#dosubmit').removeAttr("disabled");				
                    $('#dosubmit').removeClass("nonext");
                    setTimeout('gonext()',2000);
                }
                
                if(msg.status=='notice'){
                    $('#loginner').append(msg.msg);	
                    reloads(n+1);	
                }else{
                    //alert('指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！');
                    alert(msg.msg);
                }			 
            }
        });
    }
    function gonext(){
        window.location.href='./index.php?step=5';
    }
    $(document).ready(function(){
        reloads(n);
    })
</script> 
</div>
<?php require './templates/footer.php';?>
</body>
</html>