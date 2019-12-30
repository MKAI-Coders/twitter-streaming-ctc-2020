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

<meta http-equiv="refresh" content="10">
</head>

<body>
<center>
<?php

    exec("ps aux | grep python", $output, $status);
   
	$strcollect = "";
	foreach ($output as $item) {
		$strcollect = $strcollect." ".$item;
	}

	include 'koneksi.php';
	
	$conn = open_db();
   
    $sql = "SELECT * FROM tweet_capture ORDER BY id DESC";

    $retvaljml = $conn->query($sql);
	$totaldata = $retvaljml->num_rows;
	
	$sql2 = "SELECT * FROM tweet_capture ORDER BY id DESC";
	$retval = $conn->query($sql2);
	
	if ($retval->num_rows > 0)
	{
		 echo "<p><h2>Pemantauan Twitter Kegiatan Clean The City 2020</p></h2>";
		
		 echo "<p><h3>Keyword : #awalidengankebersihan, #cleanthecity, #cleanthecity2020 </p></h3>";
		 echo "<b> All tweets</b></br>";
		 echo ("Jumlah tweet sampai saat ini (sejak 30/12/2019) : ".$totaldata."</br>");

		 echo "</br></br><table><tr><th>No</th><th>Created<th>ID name</th><th>Status count</th><th>Following</th><th>Follower</th><th>Text</th><th>Location</th></tr>";
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
			 
			 echo "<td>" .$row['statuses_count']. "</td>";
			 echo "<td>" .$row['following']. "</td>";
			 echo "<td>" .$row['followers_count']. "</td>";
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
?>  
</center>
</body>
</html>