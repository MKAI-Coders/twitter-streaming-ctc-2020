<?php 

function open_db()
{
	//include 'config.php';
	
	$dbhost = "localhost";	//$DB_HOST;
	$dbuser = "root";		//$DB_USER;   //khud24_tarbiyat  //khud24_laporan
	$dbpass = "";			//$DB_PASS;   //"huf7Zzi6gr"  //khu@@4ml4p@R4n
	$db = "twitter_streaming"; //$DB_NAME;  khu@@4ml4p@R4n //khud24_khuddamlaporan//khud24_tarbiyat
	
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);

	return $conn;
}
 
function close_db($conn)
{
	$conn -> close();
}

?>