<?php

$testuser = "root";
$testpass = "";
$host = "localhost";
$datebase = "plansearch";
$PLANPAGE = '../index.html';
$tmpl_dir = '../html/tmpl';

try{
 $db = new PDO("mysql:host=$host; dbname=$datebase; charset=utf8",$testuser,$testpass);
 $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 if(isset($_POST["mode"]) && $_POST["mode"] === "search"){
    search_plan();
 }
  elseif(isset($_POST["mode"]) && $_POST["mode"] === "reservation" && isset($_POST["submit"]) && $_POST["submit"] === "おすすめ順"){
   popular_order();
 }
  elseif(isset($_POST["mode"]) && $_POST["mode"] === "reservation" && isset($_POST["submit"]) && $_POST["submit"] === "料金が安い順"){
    ascending_order();
  }
  elseif(isset($_POST["mode"]) && $_POST["mode"] === "reservation" && isset($_POST["submit"]) && $_POST["submit"] === "料金が高い順"){
    descending_order();
  }
}catch(PDOException $e){
	die("PDO Error:".$e->getMessage());
}

function search_plan(){
  global $db,$PLANPAGE,$tmpl_dir;
  $search_num = array();

  if(!empty($_POST["date"])){
    array_push($search_num,'date = :date');
  }

  if($_POST["num_person"] === '指定なし'){
    $_POST["num_person"] == '';
  }
  else{
    array_push($search_num,'num_person = :num_person');
  }

  if($_POST["num_stay"] === '指定なし'){
    $_POST["num_stay"] == '';
  }
  else{
    array_push($search_num,'num_stay = :num_stay');
  }

  if($_POST["lower_limit"] === '指定なし'){
    $_POST["lower_limit"] == '';
  }
  else{
    array_push($search_num,'charge >= :lower_limit');
  }

  if($_POST["upper_limit"] === '指定なし'){
    $_POST["upper_limit"] == '';
  }
  else{
    array_push($search_num,'charge <= :upper_limit');
  }

  if($_POST["meal"] === '指定なし'){
    $_POST["meal"] == '';
  }
  else{
    array_push($search_num,'meal = :meal');
  }

  if(!empty($_POST["date"])){
    $query = "SELECT * FROM stayplan";
  }
  else{
    $query = "SELECT * FROM stayplan2";
  }


  if(count($search_num) === 1){
    $search = implode(" ",$search_num);
    $query .= " WHERE ".$search;
  }
  elseif(count($search_num) > 1){
    $search = implode(" AND ",$search_num);
    $query .= " WHERE ".$search;
  }

  $stmt = $db -> prepare($query);

  if(!empty($_POST["date"])){
    $stmt -> bindParam(':date',$date);
    $date = $_POST["date"];
  }
  else{
    $date = "----";
  }

  if($_POST["num_person"] !== '指定なし'){
    $stmt -> bindParam(':num_person',$num_person);
    $num_person = $_POST["num_person"];
  }
  else{
    $num_person = "----";
  }

  if($_POST["num_stay"] !== '指定なし'){
    $stmt -> bindParam(':num_stay',$num_stay);
    $num_stay = $_POST["num_stay"];
  }
  else{
    $num_stay = "----";
  }

  if($_POST["lower_limit"] !== '指定なし'){
    $stmt -> bindParam(':lower_limit',$lower_limit);
    $lower_limit = intval($_POST["lower_limit"]);
  }
  else{
    $lower_limit = "----";
  }

  if($_POST["upper_limit"] !== '指定なし'){
    $stmt -> bindParam(':upper_limit',$upper_limit);
    $upper_limit = intval($_POST["upper_limit"]);
  }
  else{
    $upper_limit = "----";
  }

  if($_POST["meal"] !== '指定なし'){
    $stmt -> bindParam(':meal',$meal);
    $meal = $_POST["meal"];
  }
  else{
    $meal = "----";
  }

  $stmt -> execute();
  $Count = $stmt -> rowCount();

  $result_plan = "";
  while($row = $stmt -> fetch()){
    if(!empty($_POST["date"])){
      $plan = page_read("plan");
    }
    else{
      $plan = page_read("plan2");
    }
    $plan = str_replace("!plan_name!",$row["plan_name"],$plan);
    $plan = str_replace("!checkin!",$row["checkin"],$plan);
    $plan = str_replace("!checkout!",$row["checkout"],$plan);
    $plan = str_replace("!meal!",$row["meal"],$plan);
    $plan = str_replace("!plan!",$row["plan"],$plan);
    $plan = str_replace("!charge!",$row["charge"],$plan);
    $plan = str_replace("!image!",$row["image"],$plan);
    $result_plan .= $plan;
  }

  $result = page_read("result");
  $result = str_replace("!Count!",$Count,$result);
  $result = str_replace("!result!",$result_plan,$result);
  $result = str_replace("!PLANPAGE!",$PLANPAGE,$result);
  $result = str_replace("!date!",$date,$result);
  $result = str_replace("!num_person!",$num_person,$result);
  $result = str_replace("!num_stay!",$num_stay,$result);
  $result = str_replace("!lower_limit!",$lower_limit,$result);
  $result = str_replace("!upper_limit!",$upper_limit,$result);
  $result = str_replace("!meal!",$meal,$result);

  echo $result;
  exit;
}

function popular_order(){
  global $db,$PLANPAGE;
  $search_num = array();

  if($_POST["date"] === '----'){
    $_POST["date"] == '';
  }
  else{
    array_push($search_num,'date = :date');
  }

  if($_POST["num_person"] === '----'){
    $_POST["num_person"] == '';
  }
  else{
    array_push($search_num,'num_person = :num_person');
  }

  if($_POST["num_stay"] === '----'){
    $_POST["num_stay"] == '';
  }
  else{
    array_push($search_num,'num_stay = :num_stay');
  }

  if($_POST["lower_limit"] === '----'){
    $_POST["lower_limit"] == '';
  }
  else{
    array_push($search_num,'charge >= :lower_limit');
  }

  if($_POST["upper_limit"] === '----'){
    $_POST["upper_limit"] == '';
  }
  else{
    array_push($search_num,'charge <= :upper_limit');
  }

  if($_POST["meal"] === '----'){
    $_POST["meal"] == '';
  }
  else{
    array_push($search_num,'meal = :meal');
  }

  if($_POST["date"] !== "----"){
    $query = "SELECT * FROM stayplan ORDER BY populality";
  }
  else{
    $query = "SELECT * FROM stayplan2 ORDER BY populality";
  }

  if(count($search_num) === 1){
    $search = implode(" ",$search_num);
    if($_POST["date"] !== "----"){
      $query = "SELECT * FROM stayplan WHERE ".$search." ORDER BY populality";
    }
    else{
      $query = "SELECT * FROM stayplan2 WHERE ".$search." ORDER BY populality";
    }
  }
  elseif(count($search_num) > 1){
    $search = implode(" AND ",$search_num);
    if($_POST["date"] !== "----"){
      $query = "SELECT * FROM stayplan WHERE ".$search." ORDER BY populality";
    }
    else{
      $query = "SELECT * FROM stayplan2 WHERE ".$search." ORDER BY populality";
    }
  }

  $stmt = $db -> prepare($query);

  if($_POST["date"] !== "----"){
    $stmt -> bindParam(':date',$date);
    $date = $_POST["date"];
  }
  else{
    $date = "----";
  }

  if($_POST["num_person"] !== "----"){
    $stmt -> bindParam(':num_person',$num_person);
    $num_person = $_POST["num_person"];
  }
  else{
    $num_person = "----";
  }

  if($_POST["num_stay"] !== "----"){
    $stmt -> bindParam(':num_stay',$num_stay);
    $num_stay = $_POST["num_stay"];
  }
  else{
    $num_stay = "----";
  }

  if($_POST["lower_limit"] !== "----"){
    $stmt -> bindParam(':lower_limit',$lower_limit);
    $lower_limit = intval($_POST["lower_limit"]);
  }
  else{
    $lower_limit = "----";
  }

  if($_POST["upper_limit"] !== "----"){
    $stmt -> bindParam(':upper_limit',$upper_limit);
    $upper_limit = intval($_POST["upper_limit"]);
  }
  else{
    $upper_limit = "----";
  }

  if($_POST["meal"] !== "----"){
    $stmt -> bindParam(':meal',$meal);
    $meal = $_POST["meal"];
  }
  else{
    $meal = "----";
  }

  $stmt -> execute();
  $Count = $stmt -> rowCount();

  $result_plan = "";
  while($row = $stmt -> fetch()){
    if($_POST["date"] !== "----"){
      $plan = page_read("plan");
    }
    else{
      $plan = page_read("plan2");
    }
    $plan = str_replace("!plan_name!",$row["plan_name"],$plan);
    $plan = str_replace("!checkin!",$row["checkin"],$plan);
    $plan = str_replace("!checkout!",$row["checkout"],$plan);
    $plan = str_replace("!meal!",$row["meal"],$plan);
    $plan = str_replace("!plan!",$row["plan"],$plan);
    $plan = str_replace("!charge!",$row["charge"],$plan);
    $plan = str_replace("!image!",$row["image"],$plan);
    $result_plan .= $plan;
  }

  $result = page_read("result");
  $result = str_replace("!Count!",$Count,$result);
  $result = str_replace("!result!",$result_plan,$result);
  $result = str_replace("!PLANPAGE!",$PLANPAGE,$result);
  $result = str_replace("!date!",$date,$result);
  $result = str_replace("!num_person!",$num_person,$result);
  $result = str_replace("!num_stay!",$num_stay,$result);
  $result = str_replace("!lower_limit!",$lower_limit,$result);
  $result = str_replace("!upper_limit!",$upper_limit,$result);
  $result = str_replace("!meal!",$meal,$result);

  echo $result;
  exit;
}

function ascending_order(){
  global $db,$PLANPAGE;
  $search_num = array();

  if($_POST["date"] === '----'){
    $_POST["date"] == '';
  }
  else{
    array_push($search_num,'date = :date');
  }

  if($_POST["num_person"] === '----'){
    $_POST["num_person"] == '';
  }
  else{
    array_push($search_num,'num_person = :num_person');
  }

  if($_POST["num_stay"] === '----'){
    $_POST["num_stay"] == '';
  }
  else{
    array_push($search_num,'num_stay = :num_stay');
  }

  if($_POST["lower_limit"] === '----'){
    $_POST["lower_limit"] == '';
  }
  else{
    array_push($search_num,'charge >= :lower_limit');
  }

  if($_POST["upper_limit"] === '----'){
    $_POST["upper_limit"] == '';
  }
  else{
    array_push($search_num,'charge <= :upper_limit');
  }

  if($_POST["meal"] === '----'){
    $_POST["meal"] == '';
  }
  else{
    array_push($search_num,'meal = :meal');
  }

  if($_POST["date"] !== "----"){
    $query = "SELECT * FROM stayplan ORDER BY charge";
  }
  else{
    $query = "SELECT * FROM stayplan2 ORDER BY charge";
  }

  if(count($search_num) === 1){
    $search = implode(" ",$search_num);
    if($_POST["date"] !== "----"){
      $query = "SELECT * FROM stayplan WHERE ".$search." ORDER BY charge";
    }
    else{
      $query = "SELECT * FROM stayplan2 WHERE ".$search." ORDER BY charge";
    }
  }
  elseif(count($search_num) > 1){
    $search = implode(" AND ",$search_num);
    if($_POST["date"] !== "----"){
      $query = "SELECT * FROM stayplan WHERE ".$search." ORDER BY charge";
    }
    else{
      $query = "SELECT * FROM stayplan2 WHERE ".$search." ORDER BY charge";
    }
  }

  $stmt = $db -> prepare($query);

  if($_POST["date"] !== "----"){
    $stmt -> bindParam(':date',$date);
    $date = $_POST["date"];
  }
  else{
    $date = "----";
  }

  if($_POST["num_person"] !== "----"){
    $stmt -> bindParam(':num_person',$num_person);
    $num_person = $_POST["num_person"];
  }
  else{
    $num_person = "----";
  }

  if($_POST["num_stay"] !== "----"){
    $stmt -> bindParam(':num_stay',$num_stay);
    $num_stay = $_POST["num_stay"];
  }
  else{
    $num_stay = "----";
  }

  if($_POST["lower_limit"] !== "----"){
    $stmt -> bindParam(':lower_limit',$lower_limit);
    $lower_limit = intval($_POST["lower_limit"]);
  }
  else{
    $lower_limit = "----";
  }

  if($_POST["upper_limit"] !== "----"){
    $stmt -> bindParam(':upper_limit',$upper_limit);
    $upper_limit = intval($_POST["upper_limit"]);
  }
  else{
    $upper_limit = "----";
  }

  if($_POST["meal"] !== "----"){
    $stmt -> bindParam(':meal',$meal);
    $meal = $_POST["meal"];
  }
  else{
    $meal = "----";
  }

  $stmt -> execute();
  $Count = $stmt -> rowCount();

  $result_plan = "";
  while($row = $stmt -> fetch()){
    if($_POST["date"] !== "----"){
      $plan = page_read("plan");
    }
    else{
      $plan = page_read("plan2");
    }
    $plan = str_replace("!plan_name!",$row["plan_name"],$plan);
    $plan = str_replace("!checkin!",$row["checkin"],$plan);
    $plan = str_replace("!checkout!",$row["checkout"],$plan);
    $plan = str_replace("!meal!",$row["meal"],$plan);
    $plan = str_replace("!plan!",$row["plan"],$plan);
    $plan = str_replace("!charge!",$row["charge"],$plan);
    $plan = str_replace("!image!",$row["image"],$plan);
    $result_plan .= $plan;
  }

  $result = page_read("result");
  $result = str_replace("!Count!",$Count,$result);
  $result = str_replace("!result!",$result_plan,$result);
  $result = str_replace("!PLANPAGE!",$PLANPAGE,$result);
  $result = str_replace("!date!",$date,$result);
  $result = str_replace("!num_person!",$num_person,$result);
  $result = str_replace("!num_stay!",$num_stay,$result);
  $result = str_replace("!lower_limit!",$lower_limit,$result);
  $result = str_replace("!upper_limit!",$upper_limit,$result);
  $result = str_replace("!meal!",$meal,$result);

  echo $result;
  exit;
}

function descending_order(){
  global $db,$PLANPAGE;
  $search_num = array();

  if($_POST["date"] === '----'){
    $_POST["date"] == '';
  }
  else{
    array_push($search_num,'date = :date');
  }

  if($_POST["num_person"] === '----'){
    $_POST["num_person"] == '';
  }
  else{
    array_push($search_num,'num_person = :num_person');
  }

  if($_POST["num_stay"] === '----'){
    $_POST["num_stay"] == '';
  }
  else{
    array_push($search_num,'num_stay = :num_stay');
  }

  if($_POST["lower_limit"] === '----'){
    $_POST["lower_limit"] == '';
  }
  else{
    array_push($search_num,'charge >= :lower_limit');
  }

  if($_POST["upper_limit"] === '----'){
    $_POST["upper_limit"] == '';
  }
  else{
    array_push($search_num,'charge <= :upper_limit');
  }

  if($_POST["meal"] === '----'){
    $_POST["meal"] == '';
  }
  else{
    array_push($search_num,'meal = :meal');
  }

  if($_POST["date"] !== "----"){
    $query = "SELECT * FROM stayplan ORDER BY charge DESC";
  }
  else{
    $query = "SELECT * FROM stayplan2 ORDER BY charge DESC";
  }

  if(count($search_num) === 1){
    $search = implode(" ",$search_num);
    if($_POST["date"] !== "----"){
      $query = "SELECT * FROM stayplan WHERE ".$search." ORDER BY charge DESC";
    }
    else{
      $query = "SELECT * FROM stayplan2 WHERE ".$search." ORDER BY charge DESC";
    }
  }
  elseif(count($search_num) > 1){
    $search = implode(" AND ",$search_num);
    if($_POST["date"] !== "----"){
      $query = "SELECT * FROM stayplan WHERE ".$search." ORDER BY charge DESC";
    }
    else{
      $query = "SELECT * FROM stayplan2 WHERE ".$search." ORDER BY charge DESC";
    }
  }

  $stmt = $db -> prepare($query);

  if($_POST["date"] !== "----"){
    $stmt -> bindParam(':date',$date);
    $date = $_POST["date"];
  }
  else{
    $date = "----";
  }

  if($_POST["num_person"] !== "----"){
    $stmt -> bindParam(':num_person',$num_person);
    $num_person = $_POST["num_person"];
  }
  else{
    $num_person = "----";
  }

  if($_POST["num_stay"] !== "----"){
    $stmt -> bindParam(':num_stay',$num_stay);
    $num_stay = $_POST["num_stay"];
  }
  else{
    $num_stay = "----";
  }

  if($_POST["lower_limit"] !== "----"){
    $stmt -> bindParam(':lower_limit',$lower_limit);
    $lower_limit = intval($_POST["lower_limit"]);
  }
  else{
    $lower_limit = "----";
  }

  if($_POST["upper_limit"] !== "----"){
    $stmt -> bindParam(':upper_limit',$upper_limit);
    $upper_limit = intval($_POST["upper_limit"]);
  }
  else{
    $upper_limit = "----";
  }

  if($_POST["meal"] !== "----"){
    $stmt -> bindParam(':meal',$meal);
    $meal = $_POST["meal"];
  }
  else{
    $meal = "----";
  }

  $stmt -> execute();
  $Count = $stmt -> rowCount();

  $result_plan = "";
  while($row = $stmt -> fetch()){
    if($_POST["date"] !== "----"){
      $plan = page_read("plan");
    }
    else{
      $plan = page_read("plan2");
    }
    $plan = str_replace("!plan_name!",$row["plan_name"],$plan);
    $plan = str_replace("!checkin!",$row["checkin"],$plan);
    $plan = str_replace("!checkout!",$row["checkout"],$plan);
    $plan = str_replace("!meal!",$row["meal"],$plan);
    $plan = str_replace("!plan!",$row["plan"],$plan);
    $plan = str_replace("!charge!",$row["charge"],$plan);
    $plan = str_replace("!image!",$row["image"],$plan);
    $result_plan .= $plan;
  }

  $result = page_read("result");
  $result = str_replace("!Count!",$Count,$result);
  $result = str_replace("!result!",$result_plan,$result);
  $result = str_replace("!PLANPAGE!",$PLANPAGE,$result);
  $result = str_replace("!date!",$date,$result);
  $result = str_replace("!num_person!",$num_person,$result);
  $result = str_replace("!num_stay!",$num_stay,$result);
  $result = str_replace("!lower_limit!",$lower_limit,$result);
  $result = str_replace("!upper_limit!",$upper_limit,$result);
  $result = str_replace("!meal!",$meal,$result);

  echo $result;
  exit;
}

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
