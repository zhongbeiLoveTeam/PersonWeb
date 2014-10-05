<?php
/*==================
 *注册验证
* ======================
*/
class RegisterModel extends Model{
	// 设置数据表
	 protected $tableName = 'member';
	 //自动验证
	 protected $_validate=array(
	 		//每个字段的详细验证内容
	 		array("terms","require","没有同意服务条款不能够注册"),
	 		array("username","require","用户名不能为空"),//默认情况下用正则进行验证
	 		//array("username","checkLength","用户名长度不符合要求",0,'callback'),
	 		array('username','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
	 		//array('name','','姓名已存在！',0,'unique',self::MODEL_INSERT),
	 		array("password","require","密码不能为空"),
	 		array("password","checkLength","密码长度的要求是5~15位之间",0,'callback'),
	 		array("password","repass","两次密码输入不一致",0,'confirm'),
	 		array("email","require","电子邮箱必须填写"),
	 		array('email','email','邮箱格式错误！',2),
	 		//array('Mobile','checkMobile','手机格式不对',0,'callback'),
	 		 array('Mobile','number','手机格式不对'),
	 		array("Mobile","require","手机必须填写"),
	 		//array('regx','require','请输入验证码'), 
	 		//array('email','RegMail','邮箱格式不对',0,'callback'),
	 		//验证码
	 );
	 //自动填充
	 protected $_auto=array(
	 		array("password","md5",3,'function'),
	 		array("reg_time",'time',3,'function') ,
	 		array("last_login_time",'time',3,'function') ,
	 		array( 'getIp',"get_client_ip",3,'function') ,
	 		array('OnlineTF','1'),//OnlineTF在线状态
	 		array('loginCount','1'),//登陆次数
	 		/* 	array('ifadmin','0',self::MODEL_INSERT),
	 		 array( 'ip','get_client_ip',3,'function') ,
	 		 array("last_login_time","getTime",3,'callback'),
	 		 	array("getIp","getIp",3,'callback'),
	*/
	 
	 );
	 //自定义验证方法，来验证用户名的长度是否合法
	 //$date形参  可以写成任意如 $AA  $bb
	 function checkLength($data){
	 	//$data里存放的就是要验证的用户输入的字符串
	 	if(strlen($data)<5||strlen($data)>15){
	 		return false;
	 	}else{
	 		return true;
	 	}
	 }
	/*  function getTime(){
	 	return date("Y-m-d H:i:s");
	 }
	  //返回访问者的IP地址
	 function getIp(){
	 	return $_SERVER['REMOTE_ADDR'];
	 }
	 function RegMail($data){
	 	if($data==""){
	 		return true;
	 	}
	 	else{
	 		//$pattern1="/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/";
	 		$pattern="/^[0-9a-zA-Z]+(?:[\_\-][a-z0-9\-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\.[a-zA-Z]+$/i";
	 		if(preg_match($pattern,$data)){
	 			return true;
	 		}else{
	 			return false;
	 		}
	 	}
	 } */
	 function checkMobile($data){
	 	if($data==""){
	 		return true;
	 	}
	 	else{
//	 		$phone="/^[A-Za-z]{1}[0-9A-Za-z_]{2,29}$/";
	 		if(preg_match($phone,$data)){
	 			return true;
	 		}else{
	 			return false;
	 		}
	 	}
	 }
}