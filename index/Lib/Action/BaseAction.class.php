<?php
/*
// |sean的首页面
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------
*/
class BaseAction extends Action {
	public function _initialize() {
		/* 导航菜单 */
		$menuModel=M('Menu');
		$menuwhere['type']="1";
		$menuresult=$menuModel->where($menuwhere)->order('sort')->limit(6)->select();
		$this->assign('menu',$menuresult);
		//seo
		$systemConfig = include WEB_ROOT . 'Common/systemConfig.php';
		F("systemConfig", $systemConfig, WEB_ROOT . "Common/");
		$this->assign("site", $systemConfig);
	}
	//SEO赋值
	public function seo($title,$keywords,$description,$positioin){
		$this->assign('title',$title);
		$this->assign('keywords',$keywords);
		$this->assign('description',$description);
		$this->assign('position',$positioin);
	}
	//文件下载
	public function download(){
		$filename = $_SERVER[DOCUMENT_ROOT].__ROOT__.'/Public/Upload/download/'.$_GET['filename'];
		header("Content-type: application/octet-stream");
		header("Content-Length: ".filesize($filename));
		header("Content-Disposition: attachment; filename={$_GET['filename']}");
		$fp = fopen($filename, 'rb');
		fpassthru($fp);
		fclose($fp);
	}
}

?>