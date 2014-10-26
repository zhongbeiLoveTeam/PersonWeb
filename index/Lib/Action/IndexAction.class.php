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
    	$this->assign('myfrofile',M('Profile')->select());//个人信息提取
    	$this->assign('link',M('Link')->where('status=1')->order('sort DESC')->select());//友情链接
		$this->assign('diary',D('Diary')->where('status=1')->order('add_time DESC')->limit(5)->select());//日记 （暂时没有用）
		$Articlelist = D('Article')->where('status=1')->order('ordid DESC')->limit(8)->select();//随笔提取
		foreach ($Articlelist as $key=>$val){
			$top_art[$key] = $this->changurl($val);
		}
		$this->assign('Articlelist',$top_art);
		$this->display();
    }
    public function map(){
    	//加载map页面
    	$this->display();
    }
    //站长日记
    public function diary(){
    	$Diary = D("Diary");
    	import("ORG.Util.Page");
    	$count = $Diary->count();
    	$Page = new Page($count,18);
    	$show = $Page->show();
    	$list = $Diary->order('add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
    	$this->assign('list',$list);
    	$this->assign('page',$show);
    	$this->seo('站长日记', C('SITE_KEYWORDS'), C('SITE_DESCRIPTION'), 0);
    	$this->display();
    }
    //站内搜索
    public function search(){
    	$data = $_POST['words'];
    	$r = D('Article')->where("status=1 AND title LIKE '%$data%' OR content LIKE '%$data%'")->select();
    	foreach($r as $val){
    		$val['title']=str_replace($data,"<font color=red><b>$data</b></font>",$val['title']);
    		$val['content']=str_replace($data,"<font color=red><b>$data</b></font>",$val['content']);
    		$list[]=$this->changurl($val);
    	}
    	$this->assign('list',$list);
    	$this->seo('搜索'.$data.'结果', C('SITE_KEYWORDS'), C('SITE_DESCRIPTION'), 0);
    	$this->display();
    }
}