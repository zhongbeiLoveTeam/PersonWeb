<?php
/*
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------
*/
if (!defined('THINK_PATH'))	exit();

$config = require("config.inc.php");
$array = array( 	    
	'URL_MODEL' => 1,		
    //缓存配置
 //   'DATA_CACHE_TYPE' => 'file', // 数据缓存方式 文件
//    'DATA_CACHE_TIME' => 0, // 数据缓存时间
 //   'DATA_CACHE_SUBDIR' => true,
 //   'DATA_PATH_LEVEL' => 2,
//	'URL_PATHINFO_DEPR' =>'-',  //参数之间的分割符号    	
    'DEFAULT_LANG' => 'zh-cn', // 默认语言	
	'SHOW_PAGE_TRACE'=>true,
		'DEFAULT_THEME' => 'default',
		'TMPL_PARSE_STRING' => array (
				'__CSS__' => '/PersonWeb/index/Tpl/default/Public/Css',
				'__JS__' => '/PersonWeb/index/Tpl/default/Public/Js',
				'__UPLOAD__' => '/PersonWeb/index/Tpl/default/Public/Upload',
				'__IMG__' => '/PersonWeb/index/Tpl/default/Public/Images',
		
		),
);
return array_merge($config,$array);
?>