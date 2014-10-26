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
// 本类由系统自动生成，仅供测试用途
class IndexAction extends BaseAction {
    public function index(){
    	/*  个人信息提取      */
    	$this->assign('myfrofile',M('Person')->select());
    	//友情链接
    	$this->assign('link',M('Link')->where('status=1')->order('sort DESC')->select());
		$this->display();
		/*   简历信息提取        */
		$this->assign('myexperience',M('Resume')->select());
		/*   下载内容提取       */
		$this->assign('myinformation',M('Material')->select());
		/*   相册模块数据提取        */
		$this->assign('myexperience',M('Resume')->select());
    }
    public function map(){
    	//加载map页面
    	$this->display();
    }
}