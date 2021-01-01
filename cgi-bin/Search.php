<?php
header('Content-Type: text/html; charset=utf-8');
$host='localhost';
$user='cse20140400';
$pass='cse20140400';
$db='db_cse20140400';

$conn = new mysqli($host,$user,$pass,$db);

$today=date('Y-m-d',strtotime('+17 hours'));
//if(isset($_GET['q'])){
	$q=$_GET['q'];
	if($q==''){}
	else{
		$sql="SELECT * FROM news WHERE title LIKE '%".$q."%' LIMIT 50";
		
		$select1=$conn->query($sql);
		if($select1->num_rows>0){
			
			while($row=$select1->fetch_assoc()){
				$url=$row['url'];
				$title=$row['title'];
				echo "<a href='".$url."'>".$title."</a><br>";
			}
		}
	}
//}

//if(isset($_GET['d'])){
	$d=$_GET['d'];
	if($d==''){}
	else{
		$sql="SELECT * FROM keyword WHERE day='$d' LIMIT 10";
	//	echo $sql;	
		$select2=$conn->query($sql);
		if($select2->num_rows>0){
			while($row=$select2->fetch_assoc()){
				$rank=$row['rank'];
				$word=$row['word'];
				echo "<a href='http://cspro.sogang.ac.kr/~cse20140400/ShowResult.html?q=".$word."'>".$rank." ".$word."</a><br>";
			}
		}

	}
//}


$conn->close();

?>
