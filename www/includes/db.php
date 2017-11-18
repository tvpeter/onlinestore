<?php
define("DBNAME", "store");
define ("DBUSER", "root");
define("DBPASS", "mysql");
define("DBHOST", "localhost");

try{

$conn = new PDO ("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
}catch(PDOException $err){
echo $err->getMessage();

}
 ?>
