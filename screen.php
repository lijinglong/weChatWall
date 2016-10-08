<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/28
 * Time: 17:01
 */
//防止恶意调用
define('IN_TG',true);
//定义一个常量指定本页内容
define('SCRIPT','screen');
//引用公共文件
require 'common.inc.php';
//include('emoji.php');
include('qqface.php');
$_uniqid = $_GET['uniqid'];
$_result = _query($_connect,"SELECT tg_title from tg_activity WHERE tg_uniqid='$_uniqid' LIMIT 1");
$results = mysqli_fetch_assoc($_result);
$screentitle = $results['tg_title'];
//function userTextDecode($str){
//    $text = json_encode($str); //暴露出unicode
//    $text = preg_replace_callback('/\\\\\\\\/i',function($str){
//        return '\\';
//    },$text); //将两条斜杠变成一条，其他不动
//    return json_decode($text);
//}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<!--    <meta http-equiv="refresh" content="15">-->
    <link rel="stylesheet" type="text/css" href="styles/1/emoji.css"/>
<script type="text/javascript" src="js/screen.js"></script>
<title></title>
    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
</head>
<body onload="scrollWindow()">

    <div id="header">
        <img src="images/selflogo.png" name="qrcode" id="qrcode" />
        <h2><?php echo $screentitle;?></h2>
        <img src="images/qrcode.jpg" name="self"  id="self" />
    </div>
    <iframe src="screenData.php?uniqid=<?php echo $_uniqid;?>" width="100%" height="600px" scrolling="no" frameborder="0"></iframe>
<!--    <div id="content">-->
<!--        <table>-->
<!--            <tr>-->
<!--            --><?php
//            $_result = _query($_connect,"SELECT * from weichat WHERE tg_uniqid='$_uniqid' ORDER by tg_createtime DESC LIMIT 20");
//            $num_rows = mysqli_num_rows($_result);
////            $num_rows>1?15:$num_rows;
//            for($i=0;$i<$num_rows;$i++) {
//                $row = mysqli_fetch_assoc($_result);
//
//                $times = timestampToTime($row["tg_createtime"],'Y-m-d H:i:s');
//                ?><!--`-->
<!--                <div id="content1">-->
<!--                    <img src="--><?php //echo $row["tg_headimgurl"];?><!--" id="headimage" />-->
<!--                    <p id="nickname">--><?php //echo $row['tg_fromusername'].'<br />'; ?><!--</p>-->
<!--                    <br /><br />-->
<!--                    --><?php
//                        if($row['tg_msgtype']=='image'){
//                    ?>
<!--                            <img src="--><?php //echo $row['tg_picurl'];?><!--" id="pic" />-->
<!--                    --><?php
//                        }else{
//                    ?>
<!--                            <p id="contents">--><?php //echo qqface_convert_html($row['tg_content']); ?><!--</p>-->
<!--                    --><?php
//                        }
//                    ?>
<!--                </div>-->
<!--            --><?php //} ?>
<!--            </tr>-->
<!--        </table>-->
<!--    </div>-->

</body>
</html>