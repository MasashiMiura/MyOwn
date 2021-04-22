<?php
$dbn = "mysql:host=localhost; dbname=shiryouseikyu; charset=utf8";
$id = "root";
$password = "";

try{
 $dbh = new PDO($dbn,$id,$password);
 $dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 if($dbh == null){
  #DB接続に失敗したときここは実行されず、catch内が実行される
 }else{
   $SQL = <<<_FROM_
   CREATE TABLE seikyujoukyo(
   id int PRIMARY KEY AUTO_INCREMENT,
   name varchar(20),
   kana varchar(20),
   gender char(1),
   birth char(10),
   postal_code char(8),
   address varchar(30),
   tel varchar(14),
   email varchar(100),
   shiryou varchar(37),
   time datetime
  )
_FROM_;
  $dbh -> query($SQL);
  echo "テーブルの作成が完了しました。";
 }
}catch(PDOException $e){
  echo "テーブルの作成が失敗しました。.<br>";
  echo "エラー内容:".$e->getMessage();
  die();
 }
$dbh = null;
?>
