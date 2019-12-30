<html>
<head>
<style>

* {
 font-family: Arial;
}

tr:hover {background-color: #f5f5f5;}
td {
    border-bottom: 1px solid #ddd;
}
th {
    border-bottom: 1px solid #000000;
	background-color: #0080ff;
    color: white;
}
</style>

<!--<meta http-equiv="refresh" content="10">-->
</head>

<body>
<center>
<?php

    //exec("ps aux | grep python", $output, $status);
   
	//$strcollect = "";
	//foreach ($output as $item) {
	//	$strcollect = $strcollect." ".$item;
	//}
	
	include 'koneksi.php';
	
	$conn = open_db();


    $sql = "SELECT * FROM tweet_capture ORDER BY id DESC";
	//$sql = 'SELECT * FROM new_user ORDER BY tanggal DESC LIMIT 3';

    $retvaljml = $conn->query($sql);
	$totaldata = $retvaljml->num_rows;
	
	$sql2 = "SELECT * FROM tweet_capture ORDER BY id DESC LIMIT 10";
	$retval =  $conn->query($sql2);
	
	if ($totaldata > 0)
	{
		 echo "<img src='img/AjakanCTC.png' alt='Clean The City 2019' width='400' height='100'>";
		 
		 //echo "<p><h1>Real Time Monitoring Kegiatan Clean The City 2019</p></h1>";
		 echo "<p><h1>Real-Time Tweet Streaming</p></h1>";
		
		 echo "<p>Keyword : #awalidengankebersihan, #cleanthecity, #cleanthecity2019 </p>";
		 echo "<b> 10 tweet terupdate </b></br>";
		 echo ("Jumlah tweet sampai saat ini (sejak 23/12/2018) : ".$totaldata."</br>");

		 //echo "</br></br><table><tr><th>No</th><th>Created<th>ID name</th><th>Status count</th><th>Following</th><th>Follower</th><th>Text</th><th>Location</th></tr>";
		 echo "</br></br><table><tr><th>No</th><th>Posted<th>ID name</th><th>Text</th><th>Location</th></tr>";
		 
		 $i = 1;
		 while($row = $retval->fetch_array(MYSQLI_ASSOC)) 
		 {
			 echo "<tr><td>" .$i. "</td>";
			 echo "<td>" .$row['created_at']. "</td>";
			 $scr_nm = $row['screen_name'];
			 $twt_link = $row['tweet_id'];
			 
			 $link_id = "<a href='https://twitter.com/$scr_nm' target='_blank'>@$scr_nm</a>";
			 $link_tw = "<a href='https://twitter.com/$scr_nm/status/$twt_link' target='_blank'>LINK</a>";
			 
			 echo "<td>" .$row['name']." ( ".$link_id." )". "</td>";
			 
			 //echo "<td>" .$row['statuses_count']. "</td>";
			 //echo "<td>" .$row['following']. "</td>";
			 //echo "<td>" .$row['followers_count']. "</td>";
			 //echo "<td>" .$row['nama']. "</td>";
			 //echo "<td>" .$row['mac']. "</td>";
			 //echo "<td>" .$row['nomorhp']. "</td>";
			 //echo "<td>" .$row['pincode']. "</td>";
			 echo "<td>" .$row['text']." ( ".$link_tw." )". "</td>";
			 echo "<td>" .$row['location']. "</td></tr>";
			 $i++;
		 
		 }
		 echo "</table>";
	}
	echo "<p>Ingin melihat semua tweets? Silahkan klik link ini <a href=http://cyber.khuddam.id/cleanthecity2019/all-tweets.php>semua tweet</a></p>";
	echo "<br>";
	echo "<br>";
	
	$sql = "SELECT name, screen_name, count(*) as jml FROM tweet_capture GROUP BY screen_name ORDER BY jml DESC limit 10;";
	
	//$sql = 'SELECT * FROM new_user ORDER BY tanggal DESC LIMIT 3';

    $retval = $conn->query($sql);
	$totaldata = $retval->num_rows;
	
	if ($totaldata > 0)
	{
		 echo "<p><h2>10 Akun dengan Tweet Terbanyak</p></h2>";
		 //echo "Jumlah tweet : ".$totaldata;

		 echo "<table><tr><th>No</th><th>ID Name<th>Jumlah Tweet</th></tr>";
		 $i = 1;
		 while($row = $retval->fetch_array(MYSQLI_ASSOC)) 
		 {
			 echo "<tr><td>" .$i. "</td>";
			 $scr_nm = $row['screen_name'];
			 
			 $link_id = "<a href='https://twitter.com/$scr_nm' target='_blank'>@$scr_nm</a>";
			 echo "<td>" .$row['name']." ( ".$link_id." )". "</td>";
			 echo "<td>" .$row['jml']. "</td></tr>";
			 $i++;
		 
		 }
		 echo "</table>";
	} 
	echo "<p>Ingin melihat semua akun? Silahkan klik link ini <a href=http://cyber.khuddam.id/cleanthecity2019/rank.php>semua akun</a></p>";
	echo "</br>";
	echo "</br><hr>";
	echo "<img src='img/LOGO-MKAI.png' alt='MKAI' width='200' height='50'>";
	//echo "<p><h2>Dipersembahkan Oleh Majelis Khuddamul Ahmadiyah Indonesia</p></h2>";
	//echo "<br>";
	echo "<br>";
	
	close_db($conn);
	
?>  
</center>
</body>
</html>