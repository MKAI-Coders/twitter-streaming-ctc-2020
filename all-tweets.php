<html>
<head>
<style>
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

    $conn = mysql_connect("128.199.163.242","admin_nasir","@kun4$!r");

	if(! $conn ) {
      die('Could not connect: ' . mysql_error());
	}
   
    $sql = "SELECT * FROM ctc_twitter2019 ORDER BY id DESC";
	//$sql = 'SELECT * FROM new_user ORDER BY tanggal DESC LIMIT 3';
    mysql_select_db('admin_default');
   
    $retvaljml = mysql_query( $sql, $conn );
	$totaldata = mysql_num_rows($retvaljml);
	
	$sql2 = "SELECT * FROM ctc_twitter2019 ORDER BY id DESC";
	$retval = mysql_query( $sql2, $conn );
	
	if (mysql_num_rows($retval) > 0)
	{
		 echo "<p><h2>Real-Time Tweet Streaming</p></h2>";
		
		 echo "<p><h3>Keyword : #awalidengankebersihan, #cleanthecity, #cleanthecity2019 </p></h3>";
		 echo "<b> All tweets</b></br>";
		 echo ("Jumlah tweet sampai saat ini (sejak 29/12/2017) : ".$totaldata."</br>");

		 echo "</br></br><table><tr><th>No</th><th>Created<th>ID name</th><th>Status count</th><th>Following</th><th>Follower</th><th>Text</th><th>Location</th></tr>";
		 $i = 1;
		 while($row = mysql_fetch_array($retval)) 
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