<?php

#-----------------------------------------------------------
#基本設定
#-----------------------------------------------------------

#データベース情報
$testuser = "root";
$testpass = "";
$host = "localhost";
$datebase = "reservation";

#時間の同期元を東京の時刻に設定
date_default_timezone_set("Asia/Tokyo");

#テンプレートディレクトリ
$tmpl_dir = "./tmpl";

#検索ページ
$toppage = "search.html";

#-----------------------------------------------------------
#ページの表示
#-----------------------------------------------------------
try{
 $db = new PDO("mysql:host=$host; dbname=$datebase; charset=utf8",$testuser,$testpass);
 $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 if(isset($_POST["mode"]) && $_POST["mode"] === "search"){
  search_data();
 }
 elseif(isset($_POST["mode"]) && $_POST["mode"] === "pre_edition" && isset($_POST["status"]) && $_POST["status"] === "編集"){
  pre_edit_data();
 }
 elseif(isset($_POST["mode"]) && $_POST["mode"] === "edition"){
  edit_data();
 }
 elseif(isset($_POST["mode"]) && $_POST["mode"] === "pre_edition" && isset($_POST["status"]) && $_POST["status"] === "削除"){
  pre_delete_data();
 }
 elseif(isset($_POST["mode"]) && $_POST["mode"] === "delete"){
  delete_data();
 }
}catch(PDOException $e){
	die("PDO Error:".$e->getMessage());
}

#-----------------------------------------------------------
#検索
#-----------------------------------------------------------
function search_data(){
 global $db,$tmpl_dir,$toppage;

 #$_POSTが空白でない場合、下記をそれぞれ配列に格納
 $search_num = array();
 if(!empty($_POST["rsv_id"])){
  array_push($search_num,"rsv_id = :rsv_id");
 }
 if(!empty($_POST["name"])){
  $name = $_POST["name"];
  array_push($search_num,"name LIKE '%$name%'");
 }
 if(!empty($_POST["gender"])){
  array_push($search_num,"gender = :gender");
 }
 if(!empty($_POST["birth"])){
  $birth = $_POST["birth"];
  array_push($search_num,"birth LIKE '%$birth%'");
 }
 if(!empty($_POST["postal_code"])){
  $postal_code = $_POST["postal_code"];
  array_push($search_num,"postal_code LIKE '%$postal_code%'");
 }
 if(!empty($_POST["address"])){
  $address = $_POST["address"];
  array_push($search_num,"address LIKE '%$address%'");
 }
 if(!empty($_POST["tel"])){
  $tel = $_POST["tel"];
  array_push($search_num,"tel LIKE '%$tel%'");
 }
 if(!empty($_POST["email"])){
  $email = $_POST["email"];
  array_push($search_num,"email LIKE '%$email%'");
 }
 if(!empty($_POST["date"])){
  array_push($search_num,"date = :date");
 }
 if(!empty($_POST["checkin"])){
  array_push($search_num,"checkin = :checkin");
 }
 if(!empty($_POST["stay"])){
  array_push($search_num,"stay = :stay");
 }
 if(!empty($_POST["plan"])){
  array_push($search_num,"plan = :plan");
 }
 if(!empty($_POST["rsv_time"])){
  $rsv_time = $_POST["rsv_time"];
  array_push($search_num,"rsv_time LIKE '%$rsv_time%'");
 }

 #SELECT文の用意及び上記の配列の値と連結
 $query = "SELECT * FROM yoyakujoukyo WHERE rsv_flag = 1";
 if(count($search_num) === 1){
  $search = implode(" ",$search_num);
  $query .= " AND ".$search;
 }elseif(count($search_num) > 1){
  $search = implode(" AND ",$search_num);
  $query .= " AND ".$search;
 }

 #プリペアードステートメントの準備
 $stmt = $db -> prepare($query);
 if(!empty($_POST["rsv_id"])){
  $stmt -> bindParam(':rsv_id',$rsv_id);
  $rsv_id = $_POST["rsv_id"];
 }
 if(!empty($_POST["gender"])){
  $stmt -> bindParam(':gender',$gender);
  $gender = $_POST["gender"];
 }
 if(!empty($_POST["date"])){
  $stmt -> bindParam(':date',$date);
  $date = $_POST["date"];
 }
 if(!empty($_POST["checkin"])){
  $stmt -> bindParam(':checkin',$checkin);
  $checkin = $_POST["checkin"];
 }
 if(!empty($_POST["stay"])){
  $stmt -> bindParam(':stay',$stay);
  $stay = $_POST["stay"];
 }
 if(!empty($_POST["plan"])){
  $stmt -> bindParam(':plan',$plan);
  $plan = $_POST["plan"];
 }

 #コマンド実行
 $stmt -> execute();
 $Count = $stmt -> rowCount();

 if($Count === 0){
   $zero_tmpl = page_read("zero_result");
   echo $zero_tmpl;
   die;
 }

 #検索結果の取り出し
 $search_data = "";
 while($row = $stmt -> fetch()){
  $pre_result_tmpl = page_read("pre_result");
  $pre_result_tmpl = str_replace("!rsv_id!",$row["rsv_id"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!name!",$row["name"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!gender!",$row["gender"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!birth!",$row["birth"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!postal_code!",$row["postal_code"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!address!",$row["address"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!tel!",$row["tel"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!email!",$row["email"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!date!",$row["date"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!checkin!",$row["checkin"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!stay!",$row["stay"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!plan!",$row["plan"],$pre_result_tmpl);
  $pre_result_tmpl = str_replace("!rsv_time!",$row["rsv_time"],$pre_result_tmpl);
  $search_data .= $pre_result_tmpl;
 }

 #検索結果の表示
 $result_tmpl = page_read("result");
 $result_tmpl = str_replace("!Count!",$Count,$result_tmpl);
 $result_tmpl = str_replace("!search_result!",$search_data,$result_tmpl);
 $result_tmpl = str_replace("!toppage!",$toppage,$result_tmpl);

 echo $result_tmpl;

 exit;
}

#-----------------------------------------------------------
#更新前に対称のrsv_idの情報を表示
#-----------------------------------------------------------
function pre_edit_data(){
  global $db,$tmpl_dir,$toppage;

  #対称のrsv_idにおけるレコードを検索
  $query = "SELECT * FROM yoyakujoukyo WHERE rsv_id = :rsv_id";
  $stmt = $db -> prepare($query);
  $stmt -> bindParam(':rsv_id',$rsv_id);
  $rsv_id = $_POST["rsv_id"];
  $stmt -> execute();

  #検索結果をフェッチ
  $row = $stmt -> fetch();
  $name = explode("　",$row["name"]);
  $familyname = $name[0];
  $firstname = $name[1];
  $birth = explode("/",$row["birth"]);
  $birth_year = $birth[0];
  $birth_month = $birth[1];
  $birth_day = $birth[2];
  $postal_code = explode("-",$row["postal_code"]);
  $postal_code1 = $postal_code[0];
  $postal_code2 = $postal_code[1];
  $address = explode("　",$row["address"]);
  $prefecture = $address[0];
  $city = $address[1];
  $area = $address[2];
  $tel = explode("-",$row["tel"]);
  $tel1 = $tel[0];
  $tel2 = $tel[1];
  $tel3 = $tel[2];

  #フェッチした情報をhtmlファイル内の特定の文字列と変換して表示
  $edit_tmpl = page_read("edit");
  $edit_tmpl = str_replace("!rsv_id!",$rsv_id,$edit_tmpl);
  $edit_tmpl = str_replace("!familyname!",$familyname,$edit_tmpl);
  $edit_tmpl = str_replace("!firstname!",$firstname,$edit_tmpl);
  $edit_tmpl = str_replace("!gender!",$row["gender"],$edit_tmpl);
  $edit_tmpl = str_replace("!birth_year!",$birth_year,$edit_tmpl);
  $edit_tmpl = str_replace("!birth_month!",$birth_month,$edit_tmpl);
  $edit_tmpl = str_replace("!birth_day!",$birth_day,$edit_tmpl);
  $edit_tmpl = str_replace("!postal_code1!",$postal_code1,$edit_tmpl);
  $edit_tmpl = str_replace("!postal_code2!",$postal_code2,$edit_tmpl);
  $edit_tmpl = str_replace("!prefecture!",$prefecture,$edit_tmpl);
  $edit_tmpl = str_replace("!city!",$city,$edit_tmpl);
  $edit_tmpl = str_replace("!area!",$area,$edit_tmpl);
  $edit_tmpl = str_replace("!tel1!",$tel1,$edit_tmpl);
  $edit_tmpl = str_replace("!tel2!",$tel2,$edit_tmpl);
  $edit_tmpl = str_replace("!tel3!",$tel3,$edit_tmpl);
  $edit_tmpl = str_replace("!email!",$row["email"],$edit_tmpl);
  $edit_tmpl = str_replace("!date!",$row["date"],$edit_tmpl);
  $edit_tmpl = str_replace("!checkin!",$row["checkin"],$edit_tmpl);
  $edit_tmpl = str_replace("!stay!",$row["stay"],$edit_tmpl);
  $edit_tmpl = str_replace("!plan!",$row["plan"],$edit_tmpl);

  echo $edit_tmpl;
}

#-----------------------------------------------------------
#更新
#-----------------------------------------------------------
function edit_data(){
 global $db,$tmpl_dir,$toppage;

 #入力データが存在しない、または入力データが不正の場合はエラー用の配列にエラーマーク(e)を格納
 $error = page_read("err_edit");
 $error_arr = array();

 $error = str_replace("!rsv_id!",$_POST["rsv_id"],$error);

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

 $query = 'UPDATE yoyakujoukyo SET name = :name, gender = :gender, birth = :birth, postal_code = :postal_code, address = :address, tel = :tel, email = :email, date = :date, checkin = :checkin, stay = :stay, plan = :plan, rsv_time = :rsv_time where rsv_id = :rsv_id';
 $stmt = $db -> prepare($query);

 $stmt -> bindParam(':rsv_id',$rsv_id);
 $stmt -> bindParam(':name',$name);
 $stmt -> bindParam(':gender',$gender);
 $stmt -> bindParam(':birth',$birth);
 $stmt -> bindParam(':postal_code',$postal_code);
 $stmt -> bindParam(':address',$address);
 $stmt -> bindParam(':tel',$tel);
 $stmt -> bindParam(':email',$email);
 $stmt -> bindParam(':date',$date);
 $stmt -> bindParam(':checkin',$checkin);
 $stmt -> bindParam(':stay',$stay);
 $stmt -> bindParam(':plan',$plan);
 $stmt -> bindParam(':rsv_time',$now_time);

 $rsv_id = $_POST["rsv_id"];
 $name = $_POST["familyname"]."　".$_POST["firstname"];
 $gender = $_POST["gender"];
 $birth = $_POST["birth_year"]."/".$_POST["birth_month"]."/".$_POST["birth_day"];
 $postal_code = $_POST["postal_code1"]."-".$_POST["postal_code2"];
 $address = $_POST["prefecture"]."　".$_POST["city"]."　".$_POST["area"];
 $tel = $_POST["tel1"]."-".$_POST["tel2"]."-".$_POST["tel3"];
 $email = $_POST["email"];
 $date = $_POST["date"];
 $checkin = $_POST["checkin"];
 $stay = $_POST["stay"];
 $plan = $_POST["plan"];
 $now_time = date("Y-m-d H:i:s");

 $stmt -> execute();

 $edcom_tmpl = page_read("edit_complete");
 $edcom_tmpl = str_replace("!toppage!",$toppage,$edcom_tmpl);
 echo $edcom_tmpl;
 exit;
}

#-----------------------------------------------------------
#削除前に対称のrsv_idの情報を確認
#-----------------------------------------------------------
function pre_delete_data(){
  global $db,$tmpl_dir,$toppage;

  #対称のrsv_idにおけるレコードを検索
  $query = "SELECT * FROM yoyakujoukyo WHERE rsv_id = :rsv_id";
  $stmt = $db -> prepare($query);
  $stmt -> bindParam(':rsv_id',$rsv_id);
  $rsv_id = $_POST["rsv_id"];
  $stmt -> execute();

  #検索結果をフェッチ
  $row = $stmt -> fetch();

  #フェッチした情報をhtmlファイル内の特定の文字列と変換して表示
  $delete_tmpl = page_read("delete");
  $delete_tmpl = str_replace("!rsv_id!",$rsv_id,$delete_tmpl);
  $delete_tmpl = str_replace("!name!",$row["name"],$delete_tmpl);
  $delete_tmpl = str_replace("!gender!",$row["gender"],$delete_tmpl);
  $delete_tmpl = str_replace("!birth!",$row["birth"],$delete_tmpl);
  $delete_tmpl = str_replace("!postal_code!",$row["postal_code"],$delete_tmpl);
  $delete_tmpl = str_replace("!address!",$row["address"],$delete_tmpl);
  $delete_tmpl = str_replace("!tel!",$row["tel"],$delete_tmpl);
  $delete_tmpl = str_replace("!email!",$row["email"],$delete_tmpl);
  $delete_tmpl = str_replace("!date!",$row["date"],$delete_tmpl);
  $delete_tmpl = str_replace("!checkin!",$row["checkin"],$delete_tmpl);
  $delete_tmpl = str_replace("!stay!",$row["stay"],$delete_tmpl);
  $delete_tmpl = str_replace("!plan!",$row["plan"],$delete_tmpl);

  echo $delete_tmpl;
}

function delete_data(){
  global $db,$tmpl_dir,$toppage;

  $query = 'UPDATE yoyakujoukyo SET rsv_flag = 0 where rsv_id = :rsv_id';
  $stmt = $db -> prepare($query);
  $stmt -> bindParam(':rsv_id',$rsv_id);
  $rsv_id = $_POST['rsv_id'];
  $stmt -> execute();

  $delcom_tmpl = page_read("delete_complete");
  $delcom_tmpl = str_replace("!toppage!",$toppage,$delcom_tmpl);
  echo $delcom_tmpl;
  exit;
}

#-----------------------------------------------------------
#tmpl内のhtmlファイルの表示を実行する関数
#-----------------------------------------------------------
function page_read($page){
  global $tmpl_dir;

  #テンプレート読み込み
  $file = "$tmpl_dir/{$page}.html";
  $filesize = filesize($file);
  $handle = fopen($file,"r");
  $tmpl = fread($handle,$filesize);
  fclose($handle);

  #対象のhtmlファイルの返答
  return $tmpl;
}

?>
