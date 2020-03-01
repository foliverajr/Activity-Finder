<?php
require("configServ.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

$connection=mysqli_connect('localhost',DB_USERNAME, DB_PASSWORD);
if (!$connection) {
  die('Not connected : ' . mysqli_error());
}

$db_selected = mysqli_select_db($connection, DB_NAME);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error());
}

$query = "SELECT * FROM markers WHERE 1";
$result = mysqli_query($connection, $query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;

while ($row = @mysqli_fetch_assoc($result)){
  echo '<marker ';
  echo 'id="' . $row['id'] . '" ';
  echo 'name="' . parseToXML($row['name']) . '" ';
  echo 'address="' . parseToXML($row['address']) . '" ';
  echo 'description="' . parseToXML($row['description']) . '" ';
  echo 'date="' . $row['date'] . '" ';
  echo 'start_time="' . $row['start_time'] . '" ';
  echo 'end_time="' . $row['end_time'] . '" ';
  echo 'tags="' . parseToXML($row['tags']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}
echo '</markers>';

?>