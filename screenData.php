<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/9/28
 * Time: 9:36
 */
define('IN_TG',true);
//定义一个常量指定本页内容
define('SCRIPT','screenData');
//引用公共文件
require 'common.inc.php';
include("qqface.php");
$_uniqid = $_GET['uniqid'];
//$_result = _query($_connect,"SELECT * from weichat WHERE tg_uniqid='$_uniqid' ORDER by tg_createtime DESC LIMIT 20");
//$num_rows = mysqli_num_rows($_result);
//echo $num_rows;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title></title>
<!--    <script type="text/javascript" src="js/screenData.js"></script>-->
    <link rel="stylesheet" type="text/css" href="styles/1/screenData.css" />
    <link rel="stylesheet" type="text/css" href="styles/1/emoji.css"/>
</head>
<body>
    <div id="content">
        <table>
        <tr>
            <?php
            $_result = _query($_connect,"SELECT * from weichat WHERE tg_uniqid='$_uniqid' ORDER by tg_createtime DESC LIMIT 20");
            $num_rows = mysqli_num_rows($_result);
            //            $num_rows>1?15:$num_rows;
            for($i=0;$i<$num_rows;$i++) {
                $row = mysqli_fetch_assoc($_result);
                ?>
                <div id="content1">
                    <img src="<?php echo $row["tg_headimgurl"];?>" id="headimage" />
                    <p id="nickname"><?php echo $row['tg_fromusername'].'<br />'; ?></p>
                    <br /><br />
                    <?php
                    if($row['tg_msgtype']=='image'){
                        ?>
                        <img src="<?php echo $row['tg_picurl'];?>" id="pic" />
                    <?php
                    }else{
                        ?>
                        <p id="contents"><?php echo qqface_convert_html($row['tg_content']); ?></p>
                    <?php
                    }
                    ?>
                </div>
            <?php } ?>
        </tr>
        </table>
    </div>
</body>
</html>