<?php
$pdo_setting = array(
	'dns' => 'mysql:dbname=kenshu;host=localhost',
	'username' => 'root',
	'password' => 'root'
);

function user_signup($username,$password,$address,$phone){
	$params=array($username,$password,$address,$phone);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}
	if (strlen($username)<2) {
		$result['message']='username短い';
		return $result;
	}
	if (strlen($password)<2) {
		$result['message']='password短い';
		return $result;
	}
	
	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');

	$stmt = $dbh -> prepare("SELECT * FROM users WHERE username=:username");
	$stmt -> execute(array(':username' => $username));
	if($row = $stmt -> fetch()){
		$result['error']=true;
		$result['message']=$row['username'].'という人はすでにいます';
		return $result;
	}

	$stmt2 = $dbh -> prepare("INSERT INTO users (username, password,address,phone) VALUES (:username, :password,:address,:phone)");
	$stmt2 -> execute(array(':username' => $username, ':password' => $password, ':address' => $address, ':phone' => $phone));

	$stmt3 = $dbh -> prepare("SELECT * FROM users WHERE username=:username");
	$stmt3 -> execute(array(':username' => $username));
	if($row = $stmt3 -> fetch()){
		$result['error']=false;
		$result['id']=$row['id'];
		$result['username']=$row['username'];
		$result['password']=$row['password'];
		$result['message']='Success!';
	}else{
		$result['error']=true;
	}

	$dbh = null;
	return $result;
}

function user_signin_admin($username,$password){
	$params=array($username,$password);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');
	$stmt = $dbh -> prepare("SELECT * FROM users WHERE username=:username and password=:password and role=:role");
	$stmt -> execute(array(':username' => $username, ':password' => $password, ':role' => 'admin'));
	if($row = $stmt -> fetch()){
		$result['error']=false;
		$result['id']=$row['id'];
		$result['username']=$row['username'];
		$result['password']=$row['password'];
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='失敗しました。';
	}
	$dbh = null;
	return $result;
}
function user_signin($username,$password){
	$params=array($username,$password);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');
	$stmt = $dbh -> prepare("SELECT * FROM users WHERE username=:username and password=:password");
	$stmt -> execute(array(':username' => $username, ':password' => $password));
	if($row = $stmt -> fetch()){
		$result['error']=false;
		$result['id']=$row['id'];
		$result['username']=$row['username'];
		$result['password']=$row['password'];
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='失敗しました。';
	}
	$dbh = null;
	return $result;
}
function user_index(){
	$result = array();

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');
	$sth = $dbh->prepare("SELECT * FROM users");
	if($sth->execute()){
		$data = $sth->fetchAll(PDO::FETCH_ASSOC);
		$result['data']=$data;
		$result['error']=false;
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='失敗しました。';
	}
	$dbh = null;
	return $result;
}
function user_edit($id,$username,$password){
	$params=array($id,$username,$password);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');

	$stmt2 = $dbh -> prepare('UPDATE users set username=:username , password=:password where id = :id');
	if($stmt2->execute(array(':id' => $id,':username' => $username, ':password' => $password))){
		$result['error']=false;
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='失敗しました。';
	}

	$dbh = null;

	return $result;
}
function user_delete($username,$password){
	$params=array($username,$password);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');

	$stmt = $dbh -> prepare("DELETE FROM users WHERE username=:username and password = :password");
	if($stmt -> execute(array(':username' => $username, ':password' => $password))){
		$result['error']=false;
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='失敗しました。';
	}
	$dbh = null;

	return $result;
}

function post_index(){
	$result = array();

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');
	$sth = $dbh->prepare("SELECT * FROM posts");

	if ($sth->execute()) {
		$data = $sth->fetchAll(PDO::FETCH_ASSOC);
		$result['data']=$data;
		$result['error']=false;
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='SELECT * FROM posts　に失敗しました';
	}
	$dbh = null;
	return $result;
}
function post_getById($id){
	$params=array($id);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');
	$sth = $dbh->prepare("SELECT * FROM posts where id = :id");
	$sth->execute(array(':id' => $id));
	if($row = $sth -> fetch()){
		$result['error']=false;
		$result['title']=$row['title'];
		$result['body']=$row['body'];
		$result['id']=$row['id'];
		$result['user_id']=$row['user_id'];
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='失敗しました。';
	}
	$dbh = null;
	return $result;
}
function post_edit($id,$title,$body){
	$params=array($id,$title,$body);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');

	$stmt2 = $dbh -> prepare('UPDATE posts set title=:title , body=:body where id = :id');
	// php適当であまり厳密にupdateできない
	if($stmt2->execute(array(':id' => $id,':title' => $title, ':body' => $body))){
	    $result['error']=false;
	    $result['message']='Success!';
	}else{
		$result['error']=true;
	    $result['message']='失敗しました。';
	}
	$dbh = null;
	return $result;
}
function post_delete($id,$user_id){
	$params=array($id,$user_id);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}

	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');

	$stmt = $dbh -> prepare('DELETE FROM posts where id = :id and user_id = :user_id');
	if($stmt->execute(array(':id' => $id,':user_id' => $user_id))){
		$result['error']=false;
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='失敗しました。';
	}
	$dbh = null;
	return $result;
}
function post_add($title=null,$body=null,$user_id=0){
	$params=array($title,$body,$user_id);
	$result=sqlParamsNullCheck($params);
	if ($result['error']) {
		return $result;
	}
	
	global $pdo_setting;
	$dbh = new PDO($pdo_setting['dns'], $pdo_setting['username'],$pdo_setting['password']);
	$dbh->query('SET NAMES utf8');

	$stmt2 = $dbh -> prepare("INSERT INTO posts (title, body,user_id) VALUES (:title, :body, :user_id)");
	if($stmt2->execute(array(':user_id' => $user_id,':title' => $title, ':body' => $body))){
		$result['error']=false;
		$result['message']='Success!';
	}else{
		$result['error']=true;
		$result['message']='失敗しました。';
	}
	$dbh = null;
	return $result;
}

function sqlParamsNullCheck($params){
	foreach ($params as $key) {
	    $result = nullCheck($key);
	    if ($result['error']) {
	    	return $result;
	    }
	}
	return array('error'  => false);
}
function nullCheck($param){
	if(empty($param)){
		return array('error' => true,'message' => '必要な引数が空になっています');
	}else{
		return array('error' => false);
	}
}






