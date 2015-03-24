<?php
include dirname(__FILE__) . '/oauth/oauth.php';
include dirname(__FILE__) . '/classes/database.php';

//获取用户信息 示例链接：https://open.weixin.qq.com/connect/oauth2/authorize?appid=xxxxxxxx&redirect_uri=http://xxx/wechatapi/test.php&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect
$oauth = new Oauth();
$oauth->index();