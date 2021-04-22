<?php
$dbn="mysql:host=localhost; dbname=internet_forum; charset=utf8";
$id="root";
$password="";

try{
$dbh=new PDO($dbn,$id,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 if($dbh==null){
 #DB接続に失敗したときここは実行されず、catch内が実行される
 }else{
  $SQL=<<<_FROM_
  CREATE TABLE kakikomi(
  id int PRIMARY KEY AUTO_INCREMENT,
  date_time datetime,
  title varchar(30),
  reply_id varchar(3),
  comment varchar(500),
  IP varchar(15)
  )
_FROM_;
  $dbh->query($SQL);
  echo "テーブルの作成が完了しました。";
  }
}catch(PDOException $e){
 echo "テーブルの作成が失敗しました。.<br>";
 echo "エラー内容:".$e->getMessage();
 die();
}
$dbh=null;
?>
