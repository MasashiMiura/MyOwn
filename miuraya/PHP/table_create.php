<?php
$dbn = "mysql:host=localhost; dbname=plansearch; charset=utf8";
$id = "root";
$password = "";

try{
 $dbh = new PDO($dbn,$id,$password);
 $dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 if($dbh == null){
  #DB接続に失敗したときここは実行されず、catch内が実行される
 }else{
   $SQL = <<<_FROM_
   CREATE TABLE stayplan(
   plan_id int PRIMARY KEY AUTO_INCREMENT,
   plan_name varchar(35),
   date date,
   num_person char(1),
   num_stay char(1),
   checkin char(13),
   checkout char(8),
   meal varchar(9),
   plan varchar(70),
   charge int,
   image MEDIUMBLOB,
   populality int
  )
_FROM_;
$SQL2 = <<<_FROM_
CREATE TABLE stayplan2(
plan_id int PRIMARY KEY AUTO_INCREMENT,
plan_name varchar(35),
date date,
num_person char(1),
num_stay char(1),
checkin char(13),
checkout char(8),
meal varchar(9),
plan varchar(70),
charge int,
image MEDIUMBLOB,
populality int
)
_FROM_;
  $dbh -> query($SQL);
  $dbh -> query($SQL2);
  echo "テーブルの作成が完了しました。";
 }
}catch(PDOException $e){
  echo "テーブルの作成が失敗しました。.<br>";
  echo "エラー内容:".$e->getMessage();
  die();
 }
$dbh = null;
?>
