<?php
class Helper
{
	//格式化数组，拼接sql语句
	public static function format_data($data)
	{
		$arr = '';
		foreach($data as $key => $val){
			$arr .= $key . '=' . "'". $val ."'". ', ';
		}
		$pos = strrpos($arr, ',');
		$arr = substr($arr, 0, $pos);
		return $arr;
	}
}