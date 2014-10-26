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
		/* //seo
		$systemConfig = include WEB_ROOT . 'Common/systemConfig.php';
		F("systemConfig", $systemConfig, WEB_ROOT . "Common/");
		$this->assign("site", $systemConfig); */
		//网站配置
		$this->assign('webset',M('Setting')->select());
		
		Load('extend');
		//导航数据组装
		$nav_list = D('Category')->where('pid=0 AND status=1')->order('sort DESC')->select();
		if(is_array($nav_list)){
			foreach ($nav_list as $key=>$val){
				$nav_list[$key] = $this->changurl($val);
				$nav_list[$key]['sub_nav'] = D('Category')->where('pid='.$val['id'].' AND status=1')->select();
				foreach ($nav_list[$key]['sub_nav'] as $key2=>$val2){
					$nav_list[$key]['sub_nav'][$key2] = $this->changurl($val2);
				}
					
			}
		}
		//最热文章数据组装
		$hot_art = D('Article')->where('status=1')->order('apv DESC')->limit(8)->select();
		if(is_array($hot_art)){
			foreach ($hot_art as $key=>$val){
				$hot_art[$key] = $this->changurl($val);
			}
		}
		$this->assign('hot_art',$hot_art);
		//最热文章数据组装
		$new_art = D('Article')->where('status=1')->order('add_time DESC')->limit(8)->select();
		if(is_array($new_art)){
			foreach ($new_art as $key=>$val){
				$new_art[$key] = $this->changurl($val);
			}
		}
		$this->assign('new_art',$new_art);
		//最新留言
		$new_leave = D('Message')->where('status=1 AND pid=0 AND aid=0')->order('add_time DESC')->limit(5)->select();
		foreach ($new_leave as $key => $val){
			$new_leave[$key] = $this->msgmodify($val);
		}
		$this->assign('new_leave',$new_leave);
		//最新评论
		$new_comment = D('Message')->where('status=1 AND pid=0 AND aid!=0')->order('add_time DESC')->limit(5)->select();
		foreach ($new_comment as $key => $val){
			$new_comment[$key] = $this->msgmodify($val);
		}
		$this->assign('new_comment',$new_comment);
		$this->assign('link',D('Link')->where('status=1')->order('sort DESC')->limit(8)->select());
		$this->assign('nav_list',$nav_list);
	}
	//URL转换
	public function changurl($ary){
		if(is_array($ary)){
			if(key_exists('apv', $ary)){
				$ary['rewrite']?$ary['url']='__APP__/'.$ary['rewrite']:$ary['url']='__APP__/article/view/id/'.$ary['id'];
			}elseif(key_exists('module', $ary)){
				$ary['rewrite']?$ary['url']='__APP__/'.$ary['rewrite']:$ary['url']='__APP__/'.strtolower($ary['module']).'/index/id/'.$ary['id'];
			}else{
				$ary['rewrite']?$ary['url']='__APP__/'.$ary['rewrite']:$ary['url']='__APP__/video/view/id/'.$ary['id'];
			}
			return $ary;
		}
	}
	//模板选择
	public function choosetpl($ary){
		if(is_array($ary)){
			if(strpos($ary['template'], ':')){
				$exp = explode(':', $ary['template']);
				$file = $_SERVER['DOCUMENT_ROOT'].APP_TMPL_PATH.$exp[0].'/'.$exp[1].'.html';
			}
			if(strpos($ary['template'], ':') && is_file($file)){
				$this->display($ary['template']);
			}else{
				if(key_exists('apv', $ary)){
					$this->display('article:view');
				}elseif (key_exists('module', $ary)){
					$this->display(strtolower($ary['module']).':index');
				}else{
					$this->display('video:view');
				}
			}
		}
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
	//路由解析
	public function router(){
		//路由判断,路径参数还原
		$url = $_SERVER['PATH_INFO'];
		$ary = explode('/', $url);
		$rewrite = urldecode($ary[1]);
		$r = D("Router")->where("rewrite='".$rewrite."'")->getField('url');
		if($r){
			$exp = explode('/', $r);
			$id = $exp[3];
		}elseif ($_GET['id']){
			$id = $_GET['id'];
		}
		return $id;
	}
	//留言评论信息处理
	public function msgmodify($ary){
		if(is_array($ary)){
			if($ary['adder_id']) $ary['adder_name']=getUserName($ary['adder_id']);
			$ary['adder_email'] = md5($ary['adder_email']);
		}
		return $ary;
	}

	//空操作
	public function _empty(){
		$this->redirect("/");
	}
}

?>