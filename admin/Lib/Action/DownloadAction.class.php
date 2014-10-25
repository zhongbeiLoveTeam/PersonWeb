<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------
class DownloadAction extends BaseAction{
	public function index(){
        $download_mod = D('material');
		import("ORG.Util.Page");
		$count = $download_mod->count();
		$p = new Page($count,20);
		$download_list = $download_mod->limit($p->firstRow.','.$p->listRows)->select();
		$page = $p->show();
		$this->assign('page',$page);
		$this->assign('download_list',$download_list);
		$this->display();
		
	}
		
	function edit(){
		if (isset($_POST['dosubmit'])) {
			$mod = D('material');		
			$download_data = $mod->create();			
			
			$result_info=$mod->where("id=". $download_data['id'])->save($download_data);
			if(false !== $result_info){
				$this->success(L('operation_success'), '', '', 'edit');
			}else{				
				$this->success(L('operation_failure'));
			}
		} else {
			$mod = D('material');		
			if (isset($_GET['id'])) {
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('请选择要编辑的链接');
			}
			$download = $mod->where('id='. $id)->find();		
			$this->assign('info', $download);
			$this->assign('show_header', false);
			$this->display();
		}
	}
	
	function add()
	{
		if(isset($_POST['dosubmit'])){
			$user_mod = D('material');
		/* 	if($_POST['material_name']==''){
				$this->error(L('input').L('user_account'));
			}
			if(false === $data = $user_mod->create()){
				$this->error($user_mod->error());
			}
			if ($_FILES['img']['name']!='') {
				$upload_list = $this->_upload();
				$data['img'] = $upload_list['0']['savename'];
			} */
			$data['material_name']=$_POST['material_name'];
		
			$data['material_type']=$_POST['material_type'];
			
			$data['material_site']=$_POST['material_site'];
			
			$data['uploadedby']=$_POST['uploadedby'];
			
			$data['uploadname']=$_POST['uploadname'];
			
			if($_POST['uploadtime']==''){
				$data['uploadtime']=date('Y-m-d H:i:s',time());
			}else{
			    $data['uploadtime']=$_POST['uploadtime'];
			}
			
			$result = $user_mod->add($data);
			if($result){
				$cate = M('user_cate')->field('id,pid')->where("id=".$data['cate_id'])->find();
				if( $cate['pid']!=0 ){
					M('user_cate')->where("id=".$cate['pid'])->setInc('user_nums');
					M('user_cate')->where("id=".$data['cate_id'])->setInc('user_nums');
				}else{
					M('user_cate')->where("id=".$data['cate_id'])->setInc('user_nums');
				}
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$user_cate_mod = D('user_cate');
			$result = $user_cate_mod->order('sort_order ASC')->select();
			$cate_list = array();
			foreach ($result as $val) {
				if ($val['pid']==0) {
					$cate_list['parent'][$val['id']] = $val;
				} else {
					$cate_list['sub'][$val['pid']][] = $val;
				}
			}
			$this->assign('cate_list',$cate_list);
			$this->display();
		}
	}
	//暂时注释掉
//	public function setscore(){
//		$setting_mod = M('setting');
//		if (isset($_POST['dosubmit'])) {
//			$setscore['user_register_score'] = isset($_POST['user_register_score']) && trim($_POST['user_register_score']) ? trim($_POST['user_register_score']) : $this->error('注册积分填写错误');
//			$setscore['user_login_score'] = isset($_POST['user_login_score']) && trim($_POST['user_login_score']) ? trim($_POST['user_login_score']) : $this->error('登陆积分填写错误');
//			$setscore['share_goods_score'] = isset($_POST['share_goods_score']) && trim($_POST['share_goods_score']) ? trim($_POST['share_goods_score']) : $this->error('分享商品积分填写错误');					
//			foreach( $setscore as $key=>$val ){				
//				$setting_mod->where("name='$key'")->save(array('data'=>$val));				
//			}			
//			$this->success('修改成功', U('user/setscore'));
//		}
//		$res = $setting_mod->where("name='user_register_score' OR name='user_login_score' OR name='share_goods_score' OR name='delete_share_goods_score'")->select();
//		foreach( $res as $val )
//		{
//			$setscore[$val['name']] = $val['data'];
//		}
//		$this->assign('setscore',$setscore);
//		$this->display();
//	}
	public function delete()
    {
		$user_mod = D('material');
		$user_platform=D('user_platform');
		
		if(!isset($_POST['id']) || empty($_POST['id'])) {
            $this->error('请选择要删除的数据！');
		}	
		if( isset($_POST['id'])&&is_array($_POST['id']) ){			
			foreach( $_POST['id'] as $val ){
				$user_mod->delete($val);
				$user_platform->where("user_id='{$val}'")->delete();					
			}			
		}else{
			$id = intval($_POST['id']);			
		    $user_mod->where('id='.$id)->delete();	
		    $user_platform->where("user_id='{$id}'")->delete();	
		}
		$this->success(L('operation_success'));
    }
}