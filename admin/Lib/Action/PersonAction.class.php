<?php
// +----------------------------------------------------------------------
// | MobileCms 移动应用软件后台管理系统
// +----------------------------------------------------------------------
// | provide by ：phonegap100.com
// 
// +----------------------------------------------------------------------
// | Author: htzhanglong@foxmail.com
// +----------------------------------------------------------------------
class PersonAction extends BaseAction{
	public function index(){
        $person_mod = D('person');
		import("ORG.Util.Page");
		$count = $person_mod->count();
		$p = new Page($count,20);
		$person_list = $person_mod->limit($p->firstRow.','.$p->listRows)->select();
		
		$page = $p->show();
		$this->assign('page',$page);
		$this->assign('person_list',$person_list);
		$this->display();
		
	}
		
public function edit() {
	
	if (isset($_POST['dosubmit'])) {
		$mod = D('person');
		$person_data = $mod->create();
	    $result_info=$mod->where("id=". $person['id'])->save($person_data);
		if(false !== $result_info){
			$this->success(L('operation_success'), '', '', 'edit');
		}else{
			$this->success(L('operation_failure'));
		}
	} else {
		$mod = D('person');
		if (isset($_GET['id'])) {
			$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('请选择要编辑的链接');
		}
		$person = $mod->where('id='. $id)->find();
		$this->assign('info', $person);
		$this->assign('show_header', false);
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
	/* public function delete()
    {
		$user_mod = D('person');
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
    }*/
} 