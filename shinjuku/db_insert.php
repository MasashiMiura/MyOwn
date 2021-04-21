<?php

#データベース情報
$dbn = 'mysql:host=mysql149.phy.lolipop.lan; dbname=LAA1258923-plansearch; charset=utf8';
$id = "LAA1258923";
$password = "root";

#時刻を日本時間に設定
date_default_timezone_set("Asia/Tokyo");

parse_form();

#データベースに接続し、modeがinsertの場合は関数data_set()を実行
#modeがconfirmの場合は関数register()を実行
try{
 $dbh = new PDO($dbn,$id,$password);
 $dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 #issetは中身が存在しているか確認する式
 if(isset($_POST["mode"]) && $_POST["mode"] == "insert"){
  data_set();
 }elseif(isset($_POST["mode"]) && $_POST["mode"] == "confirm"){
   register();
 }
}catch(PDOException $e){
 echo "エラーが発生しました。.<br>";
 echo "エラー内容".$e->getMessage();
}

function parse_form(){
 global $in;

 $param = array();
 if(isset($_GET) && is_array($_GET)){ $param += $_GET;}
 if(isset($_POST) && is_array($_POST)){ $param += $_POST;}

 foreach($param as $key => $val) {
  # 2次元配列から値を取り出す
	if(is_array($val)){
	 $val = array_shift($val);
	}

	# 文字コードの処理
	$enc = mb_detect_encoding($val);
	$val = mb_convert_encoding($val,"UTF-8",$enc);

	# 特殊文字の処理
	$val = htmlentities($val,ENT_QUOTES, "UTF-8");

	$in[$key] = $val;
 }
 return $in;
}

function data_set(){
 global $in;

 #入力データが存在しない、または入力データが不正の場合はエラー用の配列にエラーマーク(e)を格納
 $error = page_read("error");
 $error_arr = array();

 if(empty($in["FamilyName"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_FamilyName!","苗字を入力してください。",$error);
  $error = str_replace("!FamilyName!","",$error);
 }
 elseif(!preg_match("/^[ぁ-んァ-ヶー一-龠０-９]+$/u",$in["FamilyName"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_FamilyName!","苗字を全角で入力してください。",$error);
  $error = str_replace("!FamilyName!","",$error);
 }
 else{
  $error = str_replace("!err_FamilyName!","",$error);
  $error = str_replace("!FamilyName!",$in["FamilyName"],$error);
 }

 if(empty($in["FirstName"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_FirstName!","名前を入力してください。",$error);
  $error = str_replace("!FirstName!","",$error);
 }
 elseif(!preg_match("/^[ぁ-んァ-ヶー一-龠０-９]+$/u",$in["FirstName"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_FirstName!","名前を全角で入力してください。",$error);
  $error = str_replace("!FirstName!","",$error);
 }
 else{
  $error = str_replace("!err_FirstName!","",$error);
  $error = str_replace("!FirstName!",$in["FirstName"],$error);
 }

 if(empty($in["KanaFamilyName"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_KanaFamilyName!","苗字(カナ)を入力してください。",$error);
  $error = str_replace("!KanaFamilyName!","",$error);
 }
 elseif(!preg_match("/^[ァ-ヶ]+$/u",$in["KanaFamilyName"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_KanaFamilyName!","苗字をカタカナで入力してください。",$error);
  $error = str_replace("!KanaFamilyName!","",$error);
 }
 else{
  $error = str_replace("!err_KanaFamilyName!","",$error);
  $error = str_replace("!KanaFamilyName!",$in["KanaFamilyName"],$error);
 }

 if(empty($in["KanaFirstName"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_KanaFirstName!","名前(カナ)を入力してください。",$error);
  $error = str_replace("!KanaFirstName!","",$error);
 }
 elseif(!preg_match("/^[ァ-ヶ]+$/u",$in["KanaFirstName"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_KanaFirstName!","名前をカタカナで入力してください。",$error);
  $error = str_replace("!KanaFirstName!","",$error);
 }
 else{
  $error = str_replace("!err_KanaFirstName!","",$error);
  $error = str_replace("!KanaFirstName!",$in["KanaFirstName"],$error);
 }

 if(empty($in["gender"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_gender!","性別を選択してください。",$error);
 }
 else{
  $error = str_replace("!err_gender!","",$error);
 }

 if(empty($in["year"])){
  $error = str_replace("!year!","",$error);
 }
 else{
  $error = str_replace("!year!",$in["year"],$error);
 }

 if(empty($in["month"])){
  $error = str_replace("!month!","",$error);
 }
 else{
  $error = str_replace("!month!",$in["month"],$error);
 }

 if(empty($in["day"])){
  $error = str_replace("!day!","",$error);
 }
 else{
  $error = str_replace("!day!",$in["day"],$error);
 }

 if(empty($in["PostalCode1"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_PostalCode1!","郵便番号の最初の3桁を入力してください。",$error);
  $error = str_replace("!PostalCode1!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$in["PostalCode1"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_PostalCode1!","郵便番号の最初の3桁を半角数字で入力してください。",$error);
  $error = str_replace("!PostalCode1!","",$error);
 }
 else{
  $error = str_replace("!err_PostalCode1!","",$error);
  $error = str_replace("!PostalCode1!",$in["PostalCode1"],$error);
 }

 if(empty($in["PostalCode2"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_PostalCode2!","郵便番号の後ろの4桁を入力してください。",$error);
  $error = str_replace("!PostalCode2!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$in["PostalCode2"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_PostalCode2!","郵便番号の後ろの4桁を半角数字で入力してください。",$error);
  $error = str_replace("!PostalCode2!","",$error);
 }
 else{
  $error = str_replace("!err_PostalCode2!","",$error);
  $error = str_replace("!PostalCode2!",$in["PostalCode2"],$error);
 }

 if(empty($in["prefecture"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_prefecture!","都道府県を選択してください。",$error);
  $error = str_replace("!prefecture!","",$error);
 }
 else{
  $error = str_replace("!err_prefecture!","",$error);
  $error = str_replace("!prefecture!",$in["prefecture"],$error);
 }

 if(empty($in["city"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_city!","市区町村を入力してください。",$error);
  $error = str_replace("!city!","",$error);
 }elseif(!preg_match("/^[ぁ-んァ-ヶー一-龠０-９]+$/u",$in["city"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_city!","市区町村を全角で入力してください。",$error);
  $error = str_replace("!city!","",$error);
 }
 else{
  $error = str_replace("!err_city!","",$error);
  $error = str_replace("!city!",$in["city"],$error);
 }

 if(empty($in["area"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_area!","番地以降を入力してください。",$error);
  $error = str_replace("!area!","",$error);
 }elseif(!preg_match("/^[ぁ-んァ-ヶー一-龠０-９　－―々ヶ]+$/u",$in["area"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_area!","番地以降を全角で入力してください。",$error);
  $error = str_replace("!area!","",$error);
 }
 else{
  $error = str_replace("!err_area!","",$error);
  $error = str_replace("!area!",$in["area"],$error);
 }

 $error = str_replace("!room!",$in["room"],$error);

 if(empty($in["tel1"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel1!","電話番号(前部)を入力してください。",$error);
  $error = str_replace("!tel1!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$in["tel1"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel1!","電話番号(前部)を半角数字で入力してください。",$error);
  $error = str_replace("!tel1!","",$error);
 }
 else{
  $error = str_replace("!err_tel1!","",$error);
  $error = str_replace("!tel1!",$in["tel1"],$error);
 }

 if(empty($in["tel2"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel2!","電話番号(中央部)を入力してください。",$error);
  $error = str_replace("!tel2!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$in["tel2"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel2!","電話番号(中央部)を半角数字で入力してください。",$error);
  $error = str_replace("!tel2!","",$error);
 }
 else{
  $error = str_replace("!err_tel2!","",$error);
  $error = str_replace("!tel2!",$in["tel2"],$error);
 }

 if(empty($in["tel3"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel3!","電話番号(後部)を入力してください。",$error);
  $error = str_replace("!tel3!","",$error);
 }elseif(!preg_match("/^[0-9]+$/",$in["tel3"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_tel3!","電話番号(後部)を半角数字で入力してください。",$error);
  $error = str_replace("!tel3!","",$error);
 }
 else{
  $error = str_replace("!err_tel3!","",$error);
  $error = str_replace("!tel3!",$in["tel3"],$error);
 }

 if(empty($in["email"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_email!","メールアドレスを入力してください。",$error);
  $error = str_replace("!email!","",$error);
 }elseif(!preg_match("/(^[a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$in["email"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_email!","メールアドレスが不正です。",$error);
  $error = str_replace("!email!","",$error);
 }
 else{
  $error = str_replace("!err_email!","",$error);
  $error = str_replace("!email!",$in["email"],$error);
 }

 if(empty($in["shiryou"])){
  array_push($error_arr,"e");
  $error = str_replace("!err_shiryou!","資料を選択してください。",$error);
 }
 else{
  $error = str_replace("!err_shiryou!","",$error);
 }

 #エラー用の配列に値が少なくても1つセットされていれば、エラー関数を実行
 if(count($error_arr) > 0){
  echo $error;
  die();
 }

 //何故だか$inにすると確認画面に反映されない。
 if(isset($_POST["shiryou"]) && is_array($_POST["shiryou"])){
  $shiryou_youso = implode(",",$_POST["shiryou"]);
 }

 $confirm = page_read("confirm");
 $confirm = str_replace("!FamilyName!",$in["FamilyName"],$confirm);
 $confirm = str_replace("!FirstName!",$in["FirstName"],$confirm);
 $confirm = str_replace("!KanaFamilyName!",$in["KanaFamilyName"],$confirm);
 $confirm = str_replace("!KanaFirstName!",$in["KanaFirstName"],$confirm);
 $confirm = str_replace("!gender!",isset($in["gender"]),$confirm);
 $confirm = str_replace("!year!",$in["year"],$confirm);
 $confirm = str_replace("!month!",$in["month"],$confirm);
 $confirm = str_replace("!day!",$in["day"],$confirm);
 $confirm = str_replace("!PostalCode1!",$in["PostalCode1"],$confirm);
 $confirm = str_replace("!PostalCode2!",$in["PostalCode2"],$confirm);
 $confirm = str_replace("!prefecture!",$in["prefecture"],$confirm);
 $confirm = str_replace("!city!",$in["city"],$confirm);
 $confirm = str_replace("!area!",$in["area"],$confirm);
 $confirm = str_replace("!room!",$in["room"],$confirm);
 $confirm = str_replace("!tel1!",$in["tel1"],$confirm);
 $confirm = str_replace("!tel2!",$in["tel2"],$confirm);
 $confirm = str_replace("!tel3!",$in["tel3"],$confirm);
 $confirm = str_replace("!email!",$in["email"],$confirm);
 $confirm = str_replace("!shiryou!",$shiryou_youso,$confirm);
 echo $confirm;
}

function register(){
 global $in,$dbh;

 $SQL = 'INSERT INTO seikyujoukyo(id,name,kana,gender,birth,postal_code,address,tel,email,shiryou,time) VALUES(?,?,?,?,?,?,?,?,?,?,?)';
 $stmt = $dbh -> prepare($SQL);

 $stmt -> bindParam(1,$id);
 $stmt -> bindParam(2,$name);
 $stmt -> bindParam(3,$kana);
 $stmt -> bindParam(4,$gender);
 $stmt -> bindParam(5,$birth);
 $stmt -> bindParam(6,$postal_code);
 $stmt -> bindParam(7,$address);
 $stmt -> bindParam(8,$tel);
 $stmt -> bindParam(9,$email);
 $stmt -> bindParam(10,$shiryou);
 $stmt -> bindParam(11,$time);

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

 $id = $mynum;
 $name = $in["FamilyName"]."　".$in["FirstName"];
 $kana = $in["KanaFamilyName"]."　".$in["KanaFirstName"];
 $gender = $in["gender"];
 $birth = $in["year"]."/".$in["month"]."/".$in["day"];
 $postal_code = $in["PostalCode1"]."-".$in["PostalCode2"];
 $address = $in["prefecture"]."　".$in["city"]."　".$in["area"]."　".$in["room"];
 $tel = $in["tel1"]."-".$in["tel2"]."-".$in["tel3"];
 $email = $in["email"];
 $shiryou = $in["shiryou"];
 $time = $nowtime;

 $stmt -> execute();

 $complete = page_read("complete");
 $toppage = "../html/require.html";
 $complete = str_replace("!toppage!",$toppage,$complete);

 echo $complete;

 exit;
}

#関数page_read()はtmplディレクトリーにあるHTMLファイルの中身を返答する関数
function page_read($page){
 $file = "../html/tmpl/{$page}.html";
 $handle = fopen($file,"r");
 $content = fread($handle,filesize($file));
 fclose($handle);

 return $content;
}

?>
