<?php 

class R {
	
	/**
	 *  获取数字类型的参数，
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function numeric($key,$default=0)
	{
		$result = isset($_REQUEST[$key]) ? trim($_REQUEST[$key]) : $default;
		if (is_numeric($result))
		{
			return $result;
		}else {
			return 0;
		}
	}
	
	/**
	 *  获取数组类型的参数，
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function arr($key,$default=0)
	{
		$result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
		if (is_array($result))
		{
		   return self::array_remove_empty($result);
		}else {
			return array();
		}
	}
	
	/**
	 * 递归安全过滤数组的值
	 * 2013.2.28
	 */
	function array_remove_empty(& $arr,$trim = true){
	    foreach ($arr as $key => $value) {
	        if (is_array($value)) {
	            self::array_remove_empty($arr[$key]);
	        } else {
	        	$value = trim($value);
	            $value = urldecode($value);
				$value = str_replace('+', '＋', $value); // 把半角的加号替换成全角的加号
				$value = strip_tags($value);
				$value = htmlspecialchars($value,ENT_QUOTES);
				$value = nl2br($value);
				$arr[$key] = $value;
	        }
	    }
	    return $arr;
	}
	
	/**
	 *  获取简单字符串类型的参数，
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function string($key,$default='')
	{
		$result = isset($_REQUEST[$key]) ?trim($_REQUEST[$key]): $default;
		
		$result = urldecode($result);
		$result = str_replace('+', '＋', $result); // 把半角的加号替换成全角的加号
		$result = strip_tags($result);
		$result = htmlspecialchars($result,ENT_QUOTES);
		$result = nl2br($result);
		
		return $result;
	}
	
	/**
	 *  获取json类型的参数，
	 *  
	 * @param 参数key $key
	 * @param 默认值 $default
	 */
	public static function json($key,$default='{}')
	{
		$result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
		
		$result = urldecode($result);
		$result = str_replace('+', '＋', $result); // 把半角的加号替换成全角的加号
		$result = strip_tags($result);
//		$result = htmlspecialchars($result,ENT_QUOTES);
		$result = nl2br($result);
		
		return $result;
	}
}