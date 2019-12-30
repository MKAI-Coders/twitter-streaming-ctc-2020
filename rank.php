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

<meta http-equiv="refresh" content="30">
</head>

<body>
<center>
<?php
	
    include 'koneksi.php';
	
	$conn = open_db();
   
    $sql = "SELECT name, screen_name, count(id) as jml FROM tweet_capture GROUP BY screen_name ORDER BY jml DESC;";
	
    $retval = $conn->query($sql);
	$totaldata = $retval->num_rows;
	
	if ($totaldata > 0)
	{
		 echo "<p><h2>Rangking Akun Tweet Terbanyak</p></h2>";
		 echo "<p><h3>Keyword : #awalidengankebersihan, #cleanthecity, #cleanthecity2019 </p></h3>";
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
?>  
</center>
</body>
</html>