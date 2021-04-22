<?php

#データベース情報
$dbn = 'mysql:host=localhost; dbname=reservation; charset=utf8';
$id = "root";
$password = "";

#時刻を日本時間に設定
date_default_timezone_set("Asia/Tokyo");

#データベースに接続し、modeがreservationの場合は関数data_set()を実行
#modeがconfirmの場合は関数register()を実行
try{
 $dbh = new PDO($dbn,$id,$password);
 $dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 #issetは中身が存在しているか確認する式
 if(isset($_POST["mode"]) && $_POST["mode"] == "reservation"){
  data_set();
 }elseif(isset($_POST["mode"]) && $_POST["mode"] == "confirm"){
   register();
 }
}catch(PDOException $e){
 echo "エラーが発生しました。.<br>";
 echo "エラー内容".$e->getMessage();
}

#フォームに入力、選択されたデータをそれぞれ変数に代入
#入力データが存在しない、または入力データが不正の場合はエラーを表示
function data_set(){

 #入力データが存在しない、または入力データが不正の場合はエラー用の配列にエラーマーク(e)を格納
 $error = page_read("err_insert");
 $error_arr = array();

 if(empty($_POST["familyname"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_familyname!","苗字を入力してください。",$error);
  $error = str_replace("!familyname!","",$error);
 }
 else{
  $error = str_replace("!err_familyname!","",$error);
  $error = str_replace("!familyname!",$_POST["familyname"],$error);
 }

 if(empty($_POST["firstname"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_firstname!","下の名前を入力してください。",$error);
  $error = str_replace("!firstname!","",$error);
 }
 else{
  $error = str_replace("!err_firstname!","",$error);
  $error = str_replace("!firstname!",$_POST["firstname"],$error);
 }

 if(empty($_POST["gender"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_gender!","性別を選択してください。",$error);
 }
 else{
  $error = str_replace("!err_gender!","",$error);
 }

 if(empty($_POST["birth_year"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_birth_year!","生年月日(年)を選択してください。",$error);
  $error = str_replace("!birth_year!","",$error);
 }
 else{
  $error = str_replace("!err_birth_year!","",$error);
  $error = str_replace("!birth_year!",$_POST["birth_year"],$error);
 }

 if(empty($_POST["birth_month"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_birth_month!","生年月日(月)を選択してください。",$error);
  $error = str_replace("!birth_month!","",$error);
 }
 else{
  $error = str_replace("!err_birth_month!","",$error);
  $error = str_replace("!birth_month!",$_POST["birth_month"],$error);
 }

 if(empty($_POST["birth_day"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_birth_day!","生年月日(日)を選択してください。",$error);
  $error = str_replace("!birth_day!","",$error);
 }
 else{
  $error = str_replace("!err_birth_day!","",$error);
  $error = str_replace("!birth_day!",$_POST["birth_day"],$error);
 }

 if(empty($_POST["postal_code1"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_postal_code1!","郵便番号の最初の3桁を入力してください。",$error);
  $error = str_replace("!postal_code1!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$_POST["postal_code1"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_postal_code1!","郵便番号の最初の3桁を半角数字で入力してください。",$error);
  $error = str_replace("!postal_code1!","",$error);
 }
 else{
  $error = str_replace("!err_postal_code1!","",$error);
  $error = str_replace("!postal_code1!",$_POST["postal_code1"],$error);
 }

 if(empty($_POST["postal_code2"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_postal_code2!","郵便番号の後ろの4桁を入力してください。",$error);
  $error = str_replace("!postal_code2!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$_POST["postal_code2"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_postal_code2!","郵便番号の後ろの4桁を半角数字で入力してください。",$error);
  $error = str_replace("!postal_code2!","",$error);
 }
 else{
  $error = str_replace("!err_postal_code2!","",$error);
  $error = str_replace("!postal_code2!",$_POST["postal_code2"],$error);
 }

 if(empty($_POST["prefecture"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_prefecture!","都道府県を選択してください。",$error);
  $error = str_replace("!prefecture!","",$error);
 }
 else{
  $error = str_replace("!err_prefecture!","",$error);
  $error = str_replace("!prefecture!",$_POST["prefecture"],$error);
 }

 if(empty($_POST["city"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_city!","市区町村を入力してください。",$error);
  $error = str_replace("!city!","",$error);
 }elseif(!preg_match("/^[ぁ-んァ-ヶー一-龠０-９]+$/u",$_POST["city"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_city!","市区町村を全角で入力してください。",$error);
  $error = str_replace("!city!","",$error);
 }
 else{
  $error = str_replace("!err_city!","",$error);
  $error = str_replace("!city!",$_POST["city"],$error);
 }

 if(empty($_POST["area"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_area!","番地以降を入力してください。",$error);
  $error = str_replace("!area!","",$error);
 }elseif(!preg_match("/^[ぁ-んァ-ヶー一-龠０-９　－―々ヶ]+$/u",$_POST["area"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_area!","番地以降を全角で入力してください。",$error);
  $error = str_replace("!area!","",$error);
 }
 else{
  $error = str_replace("!err_area!","",$error);
  $error = str_replace("!area!",$_POST["area"],$error);
 }

 if(empty($_POST["tel1"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel1!","電話番号(前部)を入力してください。",$error);
  $error = str_replace("!tel1!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$_POST["tel1"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel1!","電話番号(前部)を半角数字で入力してください。",$error);
  $error = str_replace("!tel1!","",$error);
 }
 else{
  $error = str_replace("!err_tel1!","",$error);
  $error = str_replace("!tel1!",$_POST["tel1"],$error);
 }

 if(empty($_POST["tel2"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel2!","電話番号(中央部)を入力してください。",$error);
  $error = str_replace("!tel2!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$_POST["tel2"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel2!","電話番号(中央部)を半角数字で入力してください。",$error);
  $error = str_replace("!tel2!","",$error);
 }
 else{
  $error = str_replace("!err_tel2!","",$error);
  $error = str_replace("!tel2!",$_POST["tel2"],$error);
 }

 if(empty($_POST["tel3"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel3!","電話番号(後部)を入力してください。",$error);
  $error = str_replace("!tel3!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$_POST["tel3"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel3!","電話番号(後部)を半角数字で入力してください。",$error);
  $error = str_replace("!tel3!","",$error);
 }
 else{
  $error = str_replace("!err_tel3!","",$error);
  $error = str_replace("!tel3!",$_POST["tel3"],$error);
 }

 if(empty($_POST["email"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_email!","メールアドレスを入力してください。",$error);
  $error = str_replace("!email!","",$error);
 }elseif(!preg_match("/(^[a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$_POST["email"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_email!","メールアドレスが不正です。",$error);
  $error = str_replace("!email!","",$error);
 }
 else{
  $error = str_replace("!err_email!","",$error);
  $error = str_replace("!email!",$_POST["email"],$error);
 }

 if(empty($_POST["date"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_date!","宿泊日を選択してください。",$error);
  $error = str_replace("!date!","",$error);
 }
 else{
  $error = str_replace("!err_date!","",$error);
  $error = str_replace("!date!",$_POST["date"],$error);
 }

 if(empty($_POST["checkin"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_checkin!","チェックイン時間を選択してください。",$error);
  $error = str_replace("!checkin!","",$error);
 }
 else{
  $error = str_replace("!err_checkin!","",$error);
  $error = str_replace("!checkin!",$_POST["checkin"],$error);
 }

 if(empty($_POST["stay"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_stay!","宿泊数を選択してください。",$error);
  $error = str_replace("!stay!","",$error);
 }
 else{
  $error = str_replace("!err_stay!","",$error);
  $error = str_replace("!stay!",$_POST["stay"],$error);
 }

 if(empty($_POST["plan"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_plan!","プランを選択してください。",$error);
  $error = str_replace("!plan!","",$error);
 }
 else{
  $error = str_replace("!err_plan!","",$error);
  $error = str_replace("!plan!",$_POST["plan"],$error);
 }

 #エラー用の配列に値が少なくても1つセットされていれば、エラー関数を実行
 if(count($error_arr) > 0){
  echo $error;
  die();
 }

 #エラーがなければ確認用フォームに移動
 $confirm = page_read("confirm");

 $confirm = str_replace("!familyname!",$_POST["familyname"],$confirm);
 $confirm = str_replace("!firstname!",$_POST["firstname"],$confirm);
 $confirm = str_replace("!gender!",$_POST["gender"],$confirm);
 $confirm = str_replace("!birth_year!",$_POST["birth_year"],$confirm);
 $confirm = str_replace("!birth_month!",$_POST["birth_month"],$confirm);
 $confirm = str_replace("!birth_day!",$_POST["birth_day"],$confirm);
 $confirm = str_replace("!postal_code1!",$_POST["postal_code1"],$confirm);
 $confirm = str_replace("!postal_code2!",$_POST["postal_code2"],$confirm);
 $confirm = str_replace("!prefecture!",$_POST["prefecture"],$confirm);
 $confirm = str_replace("!city!",$_POST["city"],$confirm);
 $confirm = str_replace("!area!",$_POST["area"],$confirm);
 $confirm = str_replace("!tel1!",$_POST["tel1"],$confirm);
 $confirm = str_replace("!tel2!",$_POST["tel2"],$confirm);
 $confirm = str_replace("!tel3!",$_POST["tel3"],$confirm);
 $confirm = str_replace("!email!",$_POST["email"],$confirm);
 $confirm = str_replace("!date!",$_POST["date"],$confirm);
 $confirm = str_replace("!checkin!",$_POST["checkin"],$confirm);
 $confirm = str_replace("!stay!",$_POST["stay"],$confirm);
 $confirm = str_replace("!plan!",$_POST["plan"],$confirm);

 echo $confirm;
}

#確認用フォームに記載の「完了」ボタンを押すと、DBに入力および選択された内容を登録
#登録後、完了ページに移動
function register(){
 global $dbh;

 $familyname = $_POST["familyname"];
 $firstname = $_POST["firstname"];
 $gender = $_POST["gender"];
 $birth_year = $_POST["birth_year"];
 $birth_month = $_POST["birth_month"];
 $birth_day = $_POST["birth_day"];
 $postal_code1 = $_POST["postal_code1"];
 $postal_code2 = $_POST["postal_code2"];
 $prefecture = $_POST["prefecture"];
 $city = $_POST["city"];
 $area = $_POST["area"];
 $tel1 = $_POST["tel1"];
 $tel2 = $_POST["tel2"];
 $tel3 = $_POST["tel3"];
 $email = $_POST["email"];
 $date = $_POST["date"];
 $checkin = $_POST["checkin"];
 $stay = $_POST["stay"];
 $plan = $_POST["plan"];

 $SQL = 'INSERT INTO yoyakujoukyo(rsv_id,name,gender,birth,postal_code,address,tel,email,date,checkin,stay,plan,rsv_time,rsv_flag) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,1)';
 $stmt = $dbh -> prepare($SQL);

 $stmt -> bindParam(1,$rsv_id);
 $stmt -> bindParam(2,$reg_name);
 $stmt -> bindParam(3,$reg_gender);
 $stmt -> bindParam(4,$reg_birth);
 $stmt -> bindParam(5,$reg_postal_code);
 $stmt -> bindParam(6,$reg_address);
 $stmt -> bindParam(7,$reg_tel);
 $stmt -> bindParam(8,$reg_email);
 $stmt -> bindParam(9,$reg_date);
 $stmt -> bindParam(10,$reg_checkin);
 $stmt -> bindParam(11,$reg_stay);
 $stmt -> bindParam(12,$reg_plan);
 $stmt -> bindParam(13,$rsv_time);

 #データベース内のテーブルのカラムuser_idに採番するためのファイルを用意し、+1ずつ更新
 $file = "./data/num.txt";
 $open = fopen($file,"r+");
 flock($open,LOCK_EX);
 $mynum = fgets($open);
 $mynum = intval($mynum);
 $mynum++;
 rewind($open);
 fwrite($open,$mynum);
 flock($open,LOCK_UN);
 fclose($open);

 #現在時刻を取得
 $nowtime = date("Y-m-d H:i:s");

 $rsv_id = $mynum;
 $reg_name = $familyname."　".$firstname;
 $reg_gender = $gender;
 $reg_birth = $birth_year."/".$birth_month."/".$birth_day;
 $reg_postal_code = $postal_code1."-".$postal_code2;
 $reg_address = $prefecture."　".$city."　".$area;
 $reg_tel = $tel1."-".$tel2."-".$tel3;
 $reg_email = $email;
 $reg_date = $date;
 $reg_checkin = $checkin;
 $reg_stay = $stay;
 $reg_plan = $plan;
 $rsv_time = $nowtime;

 $stmt -> execute();

 #完了ページに移動
 $complete = page_read("complete");

 $toppage = "insert.html";
 $complete = str_replace("!toppage!",$toppage,$complete);

 echo $complete;

 exit;
}

#関数page_read()はtmplディレクトリーにあるHTMLファイルの中身を返答する関数
function page_read($page){
  $file = "./tmpl/{$page}.html";
  $handle = fopen($file,"r");
  $content = fread($handle,filesize($file));
  fclose($handle);

  return $content;
}

?>
