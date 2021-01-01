
<?php
header('Content-Type: text/html; charset=utf-8');
include('./simplehtmldom_1_9_1/simple_html_dom.php');
$servername="localhost";
$username="cse20140400";
$password="cse20140400";
$dbname="db_cse20140400";


$chosun=file_get_html('https://www.chosun.com/');
$joins=file_get_html('https://joongang.joins.com/');
$donga=file_get_html('https://www.donga.com/');
$hani=file_get_html('http://www.hani.co.kr/');
$khan=file_get_html('http://www.khan.co.kr/');

$conn = new mysqli($servername,$username,$password,$dbname);


$today=date('Y-m-d',strtotime('+17 hours'));
echo $today."<br>";
//chosun
$results=$chosun->find('a.text__link');
foreach($results as $a){
	$url=$a->href;
	if(substr($url,0,1)!='h'){$url="https://www.chosun.com".$url;}
	$content=$a->plaintext;
	$sql="SELECT * FROM news where url='$url'";
	//echo $sql."<br>";
	$select=$conn->query($sql);
	if($select->num_rows>0){
		//do nothing
		while($row=$select->fetch_assoc()){
		//	echo $row['title']."<br>";
		}
	}else{
		
		$sql="INSERT INTO news (url, title, day) VALUES ('$url','$content','$today')";
		$conn->query($sql);
	}
}

//joongang
$results=$joins->find('.v2');
foreach($results as $tag){
	$aa=$tag->find('a');
	foreach($aa as $a){
		$b=$a->find('h2.headline',0)->plaintext;
		$c=$a->find('h3.headline',0)->plaintext;
		if($b!=null){
		//	echo $b."<br>";
			$url=$a->href;
			$sql="SELECT * FROM news where url='$url'";
		//
			$select=$conn->query($sql);
			if($select->num_rows>0){
				//do nothing
			}else{
				$sql="INSERT INTO news (url, title, day) VALUES ('$url','$b','$today')";
				$conn->query($sql);
			}
		}
		if($c!=null){
		//	echo $c."<br>";
			$url=$a->href;
			$sql="SELECT * FROM news where url='$url'";
			$select=$conn->query($sql);
			if($select->num_rows>0){
				//do nothing
			}else{
				$sql="INSERT INTO news (url, title, day) VALUES ('$url','$c','$today')";
				$conn->query($sql);
			}
		}

	}
}
//khan
$results=$khan->find('strong.hd_title');
foreach($results as $a){
	$aa=$a->plaintext;
	$title=str_replace("<br>","",$aa);
//	echo $title."<br>";
	$url=$a->find('a',0)->href;
	$sql="SELECT * FROM news where url='$url'";
	$select=$conn->query($sql);
	if($select->num_rows>0){
		//do nothing
	}else{
		$sql="INSERT INTO news (url, title, day) VALUES ('$url','$title','$today')";
		$conn->query($sql);
	}
}

//hani
$results=$hani->find('.article-area');
foreach($results as $a){
	$aa=$a->find('h4',0);
	$tx=$aa->plaintext;
//	echo $tx."<br>";
	$url=$aa->find('a',0)->href;
	if(substr($url,0,1)!='h'){$url="http://www.hani.co.kr".$url;}
	$sql="SELECT * FROM news where url='$url'";
	$select=$conn->query($sql);
	if($select->num_rows>0){
		//do nothing
	}else{
		
		$sql="INSERT INTO news (url, title, day) VALUES ('$url','$tx','$today')";
		$conn->query($sql);
	}

}


$conn->close();


?>


