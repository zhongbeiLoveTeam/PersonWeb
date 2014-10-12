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
    	/*
    	 * 个人信息提取
    	 */
    	$this->assign('myfrofile',M('Profile')->select());
    	//友情链接
    	$this->assign('link',M('Link')->where('status=1')->order('sort DESC')->select());
    	
		$this->display();
    }
    public function map(){
    	//加载map页面
    	$this->display();
    }
}