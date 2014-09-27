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
	
	}
	
}

?>