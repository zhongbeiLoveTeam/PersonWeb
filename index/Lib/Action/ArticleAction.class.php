<?php
//前台文章管理
class ArticleAction extends CommonAction{
	//列表
	public function index(){
		$id = $this->router();
		$type = D('Category')->where('status=1')->find($id);
		$map = D('Common')->getCategoryMap($id);
		$map['status'] = array('eq',1);			
		//分页取数据
		import("ORG.Util.Page");
		$Article = D("Article");			
		$count = $Article->where($map)->count(); 
		$Page = new Page($count,8);
		$show = $Page->show(); 
		$list = $Article->where($map)->order('sort DESC,add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($list as $key=>$val){
			$list[$key]=$this->changurl($val);
		}
		//赋值给模板
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->seo($type['title'], $type['keywords'], $type['description'], D('Common')->getPosition($id));
		$this->choosetpl($type);
	}
	//查看文章详细信息
	public function view(){		
		$id = $this->router();
		D('Article')->setInc('apv',"id=$id",1);
		$info = D('Article')->where("id=$id AND status=1")->find();
		$this->assign('info',$info);
		$this->seo($info['title'], $info['keywords'], $info['description'], D('Common')->getPosition($info['tid']));
		
		$art_pre = D('Article')->where("id<$id AND status=1")->order('id DESC')->field('id,title,apv')->find();
		$art_pre = $this->changurl($art_pre);
		$this->assign('art_pre',$art_pre);//上一篇
		
		$art_next = D('Article')->where("id>$id AND status=1")->order('id')->field('id,title,apv')->find();
		$art_next = $this->changurl($art_next);
		$this->assign('art_next',$art_next);//下一篇
		
		$art_rand = D('Article')->where("status=1")->order('rand()')->limit(8)->select();
		foreach ($art_rand as $key => $val){
			$art_rand[$key] = $this->changurl($val);
		}
		$this->assign('art_rand',$art_rand);//随机8篇
		
		$message = D('Message')->where("aid=$id AND status=1 AND pid=0")->select();
		if(is_array($message)){
			foreach ($message as $key=>$val){
				$message[$key] = $this->msgmodify($val);
				$message[$key]['reply'] = D('Message')->where('status=1 AND pid='.$val['id'])->select();
				foreach ($message[$key]['reply'] as $key2 => $val2){
					$message[$key]['reply'][$key2] = $this->msgmodify($val2);
				}				
			}
		}
		$this->assign('msg_list',$message);//评论
		$this->choosetpl($info);
		
	}
}