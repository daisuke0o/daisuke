<html>
<head>
<meta charset="utf-8">
<title>掲示板</title>
</head>
<body>
<form method="POST" action="mission_5-1.php">
<?php
//ここからMySQLログインコード
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
//
$submit=@$_POST["button_submit"];
$submit2=@$_POST["button_submit2"];
$com=@$_POST["comment"];//コメント入力
$nam=@$_POST["name"];//名前入力
$password1=@$_POST["password1"];//パスワード
$password2=@$_POST["password2"];
$password3=@$_POST["password3"];
$delete=@$_POST["delete"];//削除
$tm=date("Y-m-d H:i:s");
$editor=@$_POST["editor"];
$edit=@$_POST["edit"];//編集
if(isset($submit2)){//投稿更新
	$output=1;
	$infor="投稿を更新しました。";
}
else{
if(empty($editor)){
if(empty($edit)){
	if(empty($delete)){//削除番号が入力されているか確認
	if($submit!=""){//投稿していないときのエラー表示しなくしている
	if(empty($nam)){//コメントが入力されているか確認
	$infor="名前が入力されていません。";
}
	else{
	if(empty($com)){//名前が入力されているか確認
	$infor="コメントが入力されていません。";
}
	else{
	if(empty($password1)){
	$infor="パスワードが入力されていません。";
}
	else{
//mysql
$sql=$pdo->prepare("INSERT INTO tbmission5 (name,comment,time,pass) VALUE (:name,:comment,:time,:pass)");
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':time',$time,PDO::PARAM_STR);
$sql->bindParam(':pass',$pass,PDO::PARAM_STR);
$name=$nam;
$comment=$com;
$time=$tm;
$pass=$password1;
$sql->execute();
//php
	$infor="コメントを受け付けました。";
	$output=1;
}
}
}
}
}
else{//投稿削除
	if(empty($password2)){
	$infor="パスワードが入力されていません。";
}
$sql='SELECT * FROM tbmission5';//投稿内容読み取り
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
	if($delete==$row['id']){
	if($password2==$row['pass']){
	$id=$delete;
	$sql='delete from tbmission5  where id=:id';
	$stmt=$pdo->prepare($sql);
	$stmt->bindParam(':id',$id, PDO::PARAM_STR);
	$stmt->execute();
	$infor="投稿番号".$delete."が削除されました。";
	$output=1;
	}
	else{
	$infor="パスワードが違います。";
	}
	}
	else{
	if(empty($infor)){
	$infor="この投稿は削除されています。";
	}
	}
}
}
}//if(empty($edit)){
else{//ここから編集フォーム
$sql='SELECT * FROM tbmission5';//投稿内容読み取り
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
	if($edit==$row['id']){
	if($password3==$row['pass']){
	$box1=$row['name'];
	$box2=$row['comment'];
	$editbeta=$edit;
	}//if($password3==$row['pass']{
	else{
	$infor="パスワードが違います。";
	}
	}//if($edit==$row['id']){
	else{
	if(empty($infor)){
	$infor="この投稿は削除されています。";
	}
	}
	}//foreach($results as $row){
}//else{//ここから編集フォーム
}//if(empty($editor))
else{//編集モード
$id=$editor;
$name=$nam;
$comment=$com;
$sql='update tbmission5 set name=:name,comment=:comment where id=:id';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':name',$name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
	$infor="投稿番号".$editor."を編集しました。";
	$output=1;
}
}
?>
	<h4>[投稿フォーム]</h4>
	名前:　　　　<input type="text" name="name" value="<?php echo @$box1; ?>"><br>
	コメント:　　<input type="text" name="comment" value="<?php echo @$box2; ?>"><br>
	パスワード:　<input type="text" name="password1"><br>
	<input type="submit" name="button_submit" value="送信"><br><br>

	<h4>[削除フォーム]</h4>
	投稿番号:　　<input type="text" name="delete"><br>
	パスワード:　<input type="text" name="password2"><br>
	<input type="submit" value="送信"><br><br>

	<h4>[編集フォーム]</h4>
	投稿番号:　　<input type="text" name="edit"><br>
	パスワード:　<input type="text" name="password3"><br>
	<input type="submit" value="送信"><br>
	<input type="hidden" name="editor" value="<?php echo @$editbeta; ?>">
<?php
	if(empty($infor)){
}
	else{
	echo "<p>!.................message.................!</p>";
	echo $infor;
	echo "<p>!.................message.................!</p>";
}
?>
<p>[投稿一覧]<input type="submit" name="button_submit2" value="投稿更新"></p>
<?php
//投稿一覧
//新規投稿
	if(!empty($output)){
$sql='SELECT * FROM tbmission5';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
	echo $row['id'].'/'."投稿者".$row['name']."/".$row['time']."<br>";
	echo "コメント:".$row['comment']."<br>";
	}
	}
?>
</form>
</body>
</html>
