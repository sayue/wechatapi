<?php
function autoloader($class) {
    include dirname(__FILE__) . '/classes/' . strtolower($class) . '.php';
    include dirname(__FILE__) . '/oauth/' . strtolower($class) . '.php';
}

//auto load the class file
spl_autoload_register('autoloader');

//获取用户信息 示例链接：https://open.weixin.qq.com/connect/oauth2/authorize?appid=xxxxxxxx&redirect_uri=http://xxx/wechatapi/test.php&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect
$oauth     = new Oauth();
$user      = $oauth->getInfo();

isset($user['unionid']) ? $user['unionid']           = R::string($user['unionid']) : '';
isset($user['privilege']) ? $user['privilege']           = R::json($user['privilege']) : '';

$user['createdtime']           = time();

$querySql  = "select id from user where `openid` = '{$user['openid']}'";
$db        = Database::instance();
$ret       = $db->fetch_row($querySql);
if (!$ret) {
    $insertSql = "insert into user set " . Helper::format_data($user);
    $ret       = $db->exec($insertSql);
    if ($ret) {
        echo json_encode(array(
            'status' => 1,
            'msg' => 'add userInfo successfully!'
        ));
        exit;
    } 
    else {
        echo json_encode(array(
            'status' => 0,
            'msg' => 'add userInfo fail!'
        ));
        exit;
    }
} 
else {
    echo json_encode(array(
        'status' => 0,
        'msg' => 'userInfo already exist!'
    ));
    exit;
}

