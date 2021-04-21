<?php

date_default_timezone_set("Asia/Tokyo");
$datetime = date("Y/m/d H:i:s");
$ip = getenv("REMOTE_ADDR");

$dbn = 'mysql:host=localhost; dbname=internet_forum; charset=utf8';
$id = "root";
$password = "";

try{
 $dbh = new PDO($dbn,$id,$password);
 $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 #issetは中身が存在しているか確認する式
 if(isset($_POST["mode"]) && $_POST["mode"] == "contribution"){
  contribute();
 }
 elseif(isset($_POST["mode"]) && $_POST["mode"] == "reply"){
  reply();
 }
 forum();
}catch(PDOException $e){
 echo "エラーが発生しました。.<br>";
 echo "エラー内容".$e->getMessage();
}

function forum(){
 global $dbh;

 $SQL = "SELECT * FROM kakikomi";
 $stmt = $dbh -> prepare($SQL);
 $stmt -> execute();

 $forum_tmpl = page_read("forum");
 $forum_tmpl = str_replace(">>!id!","",$forum_tmpl);
 while($row = $stmt -> fetch()){
  $show_tmpl = page_read("show");
  $show_tmpl = str_replace("!num!",$row["id"],$show_tmpl);
  $show_tmpl = str_replace("!datetime!",$row["date_time"],$show_tmpl);
  $show_tmpl = str_replace("!title!",$row["title"],$show_tmpl);
  $show_tmpl = str_replace("!reply_id!",$row["reply_id"],$show_tmpl);
  $show_tmpl = str_replace("!comment!",$row["comment"],$show_tmpl);
  $forum_tmpl .= $show_tmpl;
 }

 echo $forum_tmpl;
 exit;
}

function contribute(){
 global $datetime,$ip,$dbh;
 $err_notes = "";

 if($_POST["title"] === ""){
  $_POST["title"] === "無題";
 }
 if($_POST["comment"] === ""){
  $err_notes .= "コメントを入力してください。";
  $err_tmpl = page_read("error");
  $err_tmpl = str_replace("!error!",$err_notes,$err_tmpl);
  echo $err_tmpl;
  die();
 }

 $SQL = 'INSERT INTO kakikomi(date_time,title,reply_id,comment,IP) VALUES(:date_time,:title,:reply_id,:comment,:IP)';
 $stmt = $dbh -> prepare($SQL);
 $stmt -> bindParam(":date_time",$datetime);
 $stmt -> bindParam(":title",$title);
 $stmt -> bindParam(":reply_id",$reply_id);
 $stmt -> bindParam(":comment",$comment);
 $stmt -> bindParam(":IP",$ip);

 $title = $_POST["title"];
 $reply_id = $_POST["reply_id"];
 $comment = $_POST["comment"];

 $stmt -> execute();
 forum();
}

function reply(){
 global $dbh;
 $id = $_POST["num"];

 $forum_tmpl = page_read("forum");
 $forum_tmpl = str_replace("!id!",$id,$forum_tmpl);

 echo $forum_tmpl;
 exit;
}

function page_read($page){
 $file = "./tmpl/{$page}.html";
 $filesize = filesize($file);
 $handle = fopen($file,"r");
 $tmpl = fread($handle,$filesize);
 fclose($handle);

 return $tmpl;
}

 ?>
