<?php
require_once("../../sql/db_config.php");
//Function to check if the request is an AJAX request
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
if (is_ajax()) {
  if (isset($_POST) && !empty($_POST)) {
    $lat = $_POST["lat"];
    $lng = $_POST["lng"];
    $data = queryMarkers($lat,$lng);
    //write to json file
    $fp = fopen('../../assets/Markers.json', 'w');
    fwrite($fp, json_encode($data));
    fclose($fp);
    echo json_encode($data);
  }
}
function queryMarkers($lat, $lng){
  $data = array();
  try
  {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Prepare a statement by setting parameters
    $sql = "SELECT address, lat, lng, marker, ( 3959 * acos( cos( radians(:lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(:lng) ) + sin( radians(:lat) ) * sin( radians( lat ) ) ) ) AS distance FROM mm_locations HAVING distance < 25 ORDER BY distance LIMIT 0 , 20";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':lat', $lat);
    $statement->bindValue(':lng', $lng);
    $statement->execute();


    while($result = $statement->fetch()){
      $data[] = $result;
    }
    $pdo = null;
    return $data;
  }

  catch (PDOException $e) {
    die( $e->getMessage() );
  }
}
 ?>
