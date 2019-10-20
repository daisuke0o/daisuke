<?php
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
$sql="CREATE TABLE IF NOT EXISTS tbmission5"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."time DATETIME,"
."pass char(32)"
.");";
$stm=$pdo->query($sql);
$sql='SHOW TABLES';
	$result=$pdo->query($sql);
	foreach($result as $row){
		echo $row[0];
		echo '<br>';
	}
	echo "<hr>";
$sql='SHOW CREATE TABLE tbmission5';
$result=$pdo->query($sql);
foreach($result as $row){
	echo $row[1];
}
echo"<hr>";
$sql='SELECT * FROM tbmission5';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['time'].',';
	echo $row['pass'].'<br>';
echo"<hr>";
}
?>
