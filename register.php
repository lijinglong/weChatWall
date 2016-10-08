<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/15
 * Time: 15:54
 */
session_start();
//防止恶意调用
define('IN_TG',true);
//第一一个常量，指定本页内容
define('SCRIPT','register');
//引用公共文件
require 'common.inc.php';
//登录状态的判断
if(_login_state()) {
    _alert_back('登录状态无法进行本操作');
}
//判断是否提交了
if(@$_GET['action']=='register'){
    //为了防止恶意注册，跨站攻击
    _check_code($_POST['code'],$_SESSION['code']);
   //引入验证文件
    include ROOT_PATH.'/includes/register.func.php';
   //创建一个空数组，存放提交过来的合法数据
    $_clean = array();
    //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击
    //存入数据库的唯一标识符还有第二个用处，就是登录cookie验证
    $_clean['uniqid'] = _check_uniqid($_SESSION['uniqid'],$_POST['uniqid']);
    //active也是一个唯一标识符，用来激活处理
    $_clean['active'] = _sha1_uniqid();
    $_clean['username'] = _check_username($_POST['username'],2,20);
    $_clean['password'] = _check_password($_POST['password'],$_POST['notpassword'],6);
    $_clean['question'] = _check_question($_POST['question'],2,20);
    $_clean['answer'] = _check_answer($_POST['question'],$_POST['answer'],2,20) ;
    $_clean['sex'] = $_POST['sex'];
    $_clean['face'] = $_POST['face'];
    $_clean['email'] = _check_email($_POST['email'],6,40);
    $_clean['qq'] = _check_qq($_POST['qq']);
    //在新增之前判断用户名是否重复
    _is_repeat(
                $_connect,
                "SELECT tg_username from tg_user where tg_username='{$_clean['username']}' LIMIT 1",
                '对不起，此用户已被注册!'
    );
    //新增用户,在双引号中直接放变量可以，如果放数组必须使用{}包括起来
    _query($_connect, "INSERT INTO tg_user(
                                                tg_uniqid,
                                                tg_active,
                                                tg_username,
                                                tg_password,
                                                tg_question,
                                                tg_answer,
                                                tg_sex,
                                                tg_face,
                                                tg_email,
                                                tg_qq,
                                                tg_reg_time,
                                                tg_last_time,
                                                tg_last_ip,
                                                tg_flag
                                                )
                                         VALUES(
                                                '{$_clean['uniqid']}',
                                                '{$_clean['active']}',
                                                '{$_clean['username']}',
                                                '{$_clean['password']}',
                                                '{$_clean['question']}',
                                                '{$_clean['answer']}',
                                                '{$_clean['sex']}',
                                                '{$_clean['face']}',
                                                '{$_clean['email']}',
                                                '{$_clean['qq']}',
                                                NOW(),
                                                NOW(),
                                                '{$_SERVER["REMOTE_ADDR"]}',
                                                '0'
                                         )"
    );
    //关闭数据库
    if(_affected_rows($_connect) == 1){
        _close($_connect);
        _session_destroy();
        $tomail = $_clean['email'];
        $activeUrl = 'https://159.226.3.80/download/self/active.php?action=ok&&active='.$_clean['active'];
        $message = "<html><head></head><body>你已经注册成功，点击下方链接进行账户激活<p style='font-weight: bold'><a href='{$activeUrl}'>$activeUrl</a></p></body></html>";
        $headers = "MTME-Version:1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1"."\r\n";
        if(mail($tomail,'微信墙平台邮件',$message,$headers)){
            _alert_back('恭喜你注册成功，邮件已经发送您的注册邮箱，请前往查收');
        }else{
            throw new Exception('Could not send email');
        }
        //跳转
       // _location('恭喜你，注册成功！','active.php?active='.$_clean['active']);
    }else {
        _close($_connect);
        _session_destroy();
        //跳转
        _location('很遗憾，注册失败!','register.php');
    }

}else{
    $_uniqid = '';
    $_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>多用户留言系统注册</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <?php
        require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/register.js"></script>
</head>
  <body>
  <?php
  require ROOT_PATH.'/includes/header.inc.php';
  ?>
  <div id="register">
      <h2>会员注册</h2>
      <form method="post" name="register" action="register.php?action=register">
          <input type="hidden" name="uniqid" value="<?php echo @$_uniqid ?>" />
          <dl>
              <dt>请认真填写以下内容</dt>
              <dd>用 户 名：<input type="text" name="username" class="text" /></dd>
              <dd>密 &nbsp;  码：<input type="password" name="password" class="text" /></dd>
              <dd>确认密码：<input type="password" name="notpassword" class="text" /></dd>
              <dd>密码提示：<input type="text" name="question" class="text" /></dd>
              <dd>密码回答：<input type="text" name="answer" class="text" /></dd>
              <dd>性  &nbsp;  别：<input type="radio" name="sex" value="男" checked="checked" />男<input type="radio" name="sex" value="女" />女</dd>
              <dd class="face"><input type="hidden" name="face" value="face/m01.gif" /><img src="face/m01.gif" alt="头像选择" id="faceimg"/></dd>
              <dd>电子邮件：<input type="text" name="email" class="text" /></dd>
              <dd> QQ&nbsp;号码：<input type="text" name="qq" class="text" /></dd>
              <dd>验 证 码：<input type="text" name="code" class="text yzm" /><img src="code.php" id="code" /> </dd>
              <dd><input type="submit" class="submit" value="注册" /></dd>
          </dl>
      </form>
  </div>

  <?php
     require ROOT_PATH.'/includes/footer.inc.php';
  ?>
  </body>
</html>