<?php
/*
 * 登陆
 */
class LoginAction extends CommonAction{
	public $loginMarked;
	public function login(){
		$this->display();
	}
	public function checkLogin() {
		if (isset($_COOKIE[$this->loginMarked])) {
			$cookie = $_COOKIE[$this->loginMarked];
		} else {
			$this->redirect("Public/index");
		}
		return TRUE;
	}
	public function dealLogin($email,$password){
		//正常操作登陆
		
	}
	public function index(){
			//if(!empty($_COOKIE['email']) || !empty($_COOKIE['password'])){
				//用户选择了记住登录状态
				//$user =$this->getUserInfo($_COOKIE['email'],$_COOKIE['password']); //去取用户的个人资料
			//if(!empty($_COOKIE['email']) || !empty($_COOKIE['password'])){
				//用户选择了记住登录状态
				//$user =$this->getUserInfo($_COOKIE['email'],$_COOKIE['password']); //去取用户的个人资料
		$model = M("member");
		if ($_POST['form_type']=="email") {
			$name=$_POST['email'];
		}else {
			$name=$_POST['mobile'];
		}
		if (empty($name)) {
			$this->error('亲爱的邀99会员，你还没有填写账户呢！');
		}
		$password=$_POST['password'];
		if (empty($password)) {
			$this->error('亲爱的邀99会员，你还没有填写密码呢！');
		}
		$result =$this->getUserInfo($name,$password); //去取用户的个人资料
		if (empty($result)) {
			$this->error('亲爱的邀99会员，登录账户和密码没有符合哎！，如果忘记密码可以点击登录，修改密码');
		}
		if ($result[0]['isLock']=="1") {
			$this->error('亲爱的会员，您的账户没有通过审核，请核对后重新登录或者等待审核！');
		}
		//保存会员登录信息
		$saveResult=$this->saveUserInfo($result[0]['member_id']);
		if ($saveResult){
			if ($_POST['remeber']=="1") {
				//检查用户是否愿意记住密码,保存登录cookies
				$_COOKIE['zhanghu']=$name;
				$_COOKIE['password']=MD5($password);
			}
			$_SESSION['zhanghu']	=$name;
			$_SESSION['loginUserName']=$result[0]['username'];
			$_SESSION[C('USER_AUTH_KEY')]=$result[0]['member_id'];
			$_SESSION['memberType']=$result[0]['role_id'];
			$_SESSION['OnlineTF']="1";//用户在线状态
			$_SESSION['vipType']=$result[0]['vip_type_id'];//用户会员类型
			$this->redirect('PersonSpace/index');
			//$this->success('邀99大学生恋爱网欢迎".$_SESSION['loginUserName']".登录成功！');
		}else{
			$this->error('保存会员信息错误！');
		}
	}
	public function loginOut() {
		if (isset($_SESSION[C('USER_AUTH_KEY')])) {
		//setcookie("$this->loginMarked", NULL, -3600, "/");
		//unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
		if (isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
		}
		} 
		$this->redirect("Index/index");
	}
	public function getUserInfo($email,$password){
		//得到用户信息（验证）
		$member=M('Member');
		$where['email']=$email;
		$where['password']=md5($password);
		$result=$member->where($where)->select();
		return $result;
	}
	public function saveUserInfo($id){
		//保存登录信息
		$member=M('Member');
		$where['member_id']=$id;
		$data['last_login_time']=time();
		$data['OnlineTF']="1";
		$data['getIp']=get_client_ip();
		$result=$member->where($where)->save($data);
		return $result;
	}
	/* public function loginOut() {
		setcookie("$this->loginMarked", NULL, -3600, "/");
		unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
		if (isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
		}
		$this->redirect("Index/index");
	} */
	public function emailCheck(){
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$code = trim($_POST['code']);
	
		if ($_SESSION['verify']!==md5($code)) {
			echo json_encode(1);
			return;
		}
		$where['email']=$email;
		$where['password']=md5($password);
		$m=M('member');
		$find =$m->where($where)->select();
		if($find){
			$re=2;
		}else{
			$re=3;
		}
		echo json_encode($re);
	}
}