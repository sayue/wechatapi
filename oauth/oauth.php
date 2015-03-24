<?php

class Oauth
{
    public function index() {
        if (isset($_GET['code'])) {
            $result = $this->GetOpenid($_GET['code']);
            $state  = $_GET['state'];
            
            //获取到用户数据
            if ($result) {
                header("content-Type: text/html; charset=utf-8");
                var_dump($result);
                exit;
            } 
            else {
                exit;
            }
        } 
        else {
            exit;
        }
    }
    
    //将获取到的信息存至SESSION
    public function save_session($arr) {
        foreach ($arr as $key        => $val) {
            session($key, $val);
        }
    }
    
    //获取微信的openid
    public function GetOpenid($c_code) {
        $config     = include dirname(dirname(__FILE__)) . '/classes/config.php';
        
        //微信公众号测试
        $appid      = $config['wechat']['appid'];
        $secret     = $config['wechat']['secret'];
        
        $url        = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" . $secret . "&code=" . $c_code . "&grant_type=authorization_code";
        
        $result     = $this->getData($url);
        $jsondecode = json_decode($result);
        
        if ($jsondecode != null) {
            if (property_exists($jsondecode, "openid")) {
                $arr        = array(
                    'openid'            => $jsondecode->{"openid"},
                    'nickname'            => $jsondecode->{"nickname"},
                    'access_token'            => $jsondecode->{"access_token"}
                );
                $url1       = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $arr['access_token'] . "&openid=" . $arr['openid'] . "&lang=zh_CN";
                $userinfo   = $this->getData($url1);
                $jsonuser   = json_decode($userinfo);
                
                $user       = get_object_vars($jsonuser);
                
                return $user;
            } 
            else {
                return "code is invalid.";
            }
        }
        return null;
    }
    
    //获取https的get请求结果
    public function getData($c_url) {
        $curl = curl_init();
         // 启动一个CURL会话
        // curl_setopt($curl, CURLOPT_HTTPHEADER, array('charset=utf-8'));
        curl_setopt($curl, CURLOPT_URL, $c_url);
         // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
         // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
         // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
         // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
         // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
         // 自动设置Referer
        //    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        //    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
         // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0);
         // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl);
         // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);
             //捕抓异常
            
        }
        curl_close($curl);
         // 关闭CURL会话
        return $tmpInfo;
         // 返回数据
        
    }
}
