<?php
$dbn = "mysql:host=localhost; dbname=reservation; charset=utf8";
$id = "root";
$password = "";

try{
 $dbh = new PDO($dbn,$id,$password);
 $dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 if($dbh == null){
  #DB接続に失敗したときここは実行されず、catchないが実行される
 }else{
   $SQL = "INSERT INTO yoyakujoukyo VALUES(1,'テスト　太郎','男','1994/05/22','123-4567','東京都　テスト区　テスト１－２－３','123-4567-8901','taroh.tst@docomo.co.jp','2020-01-26','16:00','1泊','朝・夕付き','2019-09-05 10:30',1)";
   $dbh -> query($SQL);

   $SQL2 = "INSERT INTO yoyakujoukyo VALUES(2,'テスト　花子','女','1998/11/16','173-0086','東京都　テスト市　テスト４－５－６','123-6543-9876','hanako.tst@yahoo.co.jp','2020-02-14','15:00','1泊','朝・夕付き','2019-09-05 10:30',1)";
   $dbh -> query($SQL2);

   $SQL3 = "INSERT INTO yoyakujoukyo VALUES(3,'テスト　一郎','男','1985/03/18','456-7890','神奈川県　宿泊市　テスト７－８－９','090-1122-3344','ichiroh.tst@gmail.com','2020-03-18','17:00','1泊','夕のみ','2019-09-05 10:30',1)";
   $dbh -> query($SQL3);
   echo "ユーザーの登録が完了しました。";
  }
}catch(PDOException $e){
  echo "ユーザーの登録が失敗しました。.<br>";
  echo "エラー内容:".$e->getMessage();
 }

?>
