<?php
/*
 * 注册模块
 */
class RegisterAction extends CommonAction{
	public function index(){
		$model=M('Webinfo');
		$reg=$model->field('reg_agreement')->limit(1)->select();
		$this->assign('reg',$reg);
		$this->display();
	}
	public function ifRegEmail(){
		$where['email']=$_POST['email'];
		$re=M('member')->where($where)->select();
		if($re){
			$exit=1;
		}else{
			$exit=0;
		}
		echo json_encode($exit);
	}
	public function ifexit_Mobile(){
		$where['Mobile']=$_POST['Mobile'];
		$re=M('Member')->where($where)->field('Mobile')->select();
		if($re){
			$exit=1;
		}else{
			$exit=0;
		}
		echo json_encode($exit);
	}
	public  function dealReg(){
		/* dump($_POST);
		exit(); */
		$model = D("Register");
		$vo = $model->create();
		if(false === $vo){
			$this->error($model->getError());
		}
			$member_id = $model->add(); //add方法会返回新添加的记录的主键值
			if($member_id) {
				//生成认证条件
        		$map            =   array($vo);
				import ( 'ORG.Util.RBAC' );
				$_SESSION['USER_AUTH_KEY']=$member_id;
				$_SESSION['email']	=$_POST['email'];
				$_SESSION['loginUserName']=$_POST['username'];
				$_SESSION['OnlineTF']="1";//用户在线状态
				$_SESSION['vipType']="普通用户";//用户在线状态
				//保存会员详细信息
				$member_detail	=	M('member_detail');
				if ($_POST['nationName']!=="汉族") {
					$data['if_shaoNation']="2";
				}
				$data['member_id']	=	$member_id;
				$member_detail->add($data);
				if ($member_detail) {
					$this->redirect('Register/HeadPhoto');
					//$this->success('注册成功,不要着急啊，还有最后一步了啊！','Home');
				}
				//$this->success('注册成功','Home/PersonSpace/ListHeadPhoto');
				//$this->display('PersonSpace/ListHeadPhoto');
			}else {
				//$this->error($model->getError());
		}
	}
	public function HeadPhoto(){
		if (!IS_POST) {
			$this->display();
		}else{
			$_SESSION['USER_AUTH_KEY']="29";
			$m=M('Member');
			$where['member_id']=$_SESSION['USER_AUTH_KEY'];
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','bmp','tiff','svg');// 设置附件上传类型
			$upload->savePath =  './Public/Upload/HeadPhoto/';// 设置附件上传目录
			$upload->thumbRemoveOrigin = true;               //是否移除原图
			$upload->uploadReplace = true;//存在同名文件是否是覆盖
			$upload->thumb = true;
			$upload->thumbPrefix = '';
			$upload->thumbMaxWidth = '126';
			$upload->thumbMaxHeight = '140';
			$upload->thumbPath = './Public/Upload/HeadPhoto/thumb/';
			if (!$upload->upload()) {
				//捕获上传异常
				$this->error($upload->getErrorMsg());
			} else {
				//取得成功上传的文件信息
				$u= $upload->getUploadFileInfo();
				$data['headphoto']=$u[0]['savename'];//附件名称
				//$data['headphoto']=$data['thumbnails']=$u[0]['savename'];//附件名称
				//$data['thumbnails']='thumb_'.$u[0]['savename'];
				$result=$m->where($where)->save($data);
				if($result){
					$this->redirect('PersonSpace/index');
				}else{
					$this->error('上传失败');
				}
			}
	}
	}
	//删除图片
	public function _before_foreverdelete() {
		if($_GET['id']){
			$id = $_GET['id'];
			$src = './Public/Upload/photo/'.D('Photo')->where('id='.$id)->getField('img');
			if(is_file($src)) unlink($src);
			$src = './Public/Upload/photo/thumb_'.D('Photo')->where('id='.$id)->getField('img');
			if(is_file($src)) unlink($src);
		}
	}
}