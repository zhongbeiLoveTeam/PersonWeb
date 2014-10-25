<?php
//根据ID获得分类名
function getCategoryName($id){
	if (empty ( $id )) {
		return '顶级分类';
	}
	$Category = D ( "Category" );
	$list = $Category->getField ( 'id,title' );
	$name = $list [$id];
	return $name;
}
//根据ID获得模型名
function getModuleById($id){
	$Category = D ( "Category" );
	$list = $Category->getField ( 'id,module' );
	$module = $list [$id];
	return $module;
}
//根据ID获得用户名
function getUserName($id){
	if (empty ( $id )) {
		return '游客';
	}
	$User = D ( "User" );
	$list = $User->getField ( 'id,nickname' );
	$name = $list [$id];
	return $name;
}
//根据ID获得文章标题
function getArticleById($id){
	$list = D('Article')->getField('id,title');
	$module = $list[$id];
	return $module;
}