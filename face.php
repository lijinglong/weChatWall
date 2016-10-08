<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/15
 * Time: 17:04
 */
//防止恶意调用
define('IN_TG',true);
//第一一个常量，指定本页内容
define('SCRIPT','face');
//引用公共文件
require 'common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>多用户留言系统--头像选择</title>
    <?php
        require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript " src="js/opener.js"></script>
</head>
<body>
<div id="face">
    <h3>选择头像</h3>
    <dl>
        <?php  foreach(range(1,9) as $number) { ?>
        <dd><img src="face/m0<?php echo $number ?>.gif" alt="face/m0<?php echo $number ?>.gif" title="头像<?php echo $number ?>" /></dd>
        <?php }?>

    </dl>
    <dl>
        <?php  foreach(range(10,64) as $number) { ?>
            <dd><img src="face/m<?php echo $number ?>.gif" alt="face/m<?php echo $number ?>.gif" title="头像<?php echo $number ?>" /></dd>
        <?php }?>

    </dl>
</div>
</body>
</html>