<?php
header('Content-Type: text/html; charset=utf-8');
$servername="localhost";
$username="cse20140400";
$password="cse20140400";
$dbname="db_cse20140400";

$conn = new mysqli($servername,$username,$password,$dbname);

$today=date('Y-m-d',strtotime('+17 hours'));

$sql="SELECT * FROM news WHERE day='$today'";

$select=$conn->query($sql);
$collection=array();
$t_num=0;
$str=array();
$word_list=array();
if($select->num_rows>0){
	while($row = $select->fetch_assoc()){
		$t_num++;
		$string=$row['title'];
	//	$collection[$t_num]=$string;
		$str=explode(' ',$string);
		foreach($str as $s){
		//	$word=trim($s,"\"\"''.,");
			$word=str_replace('"','',$s);
			$word=str_replace('\'','',$word);
			$word=str_replace(',','',$word);
			$word=str_replace('.','',$word);
			$word=str_replace('[','',$word);
			$word=str_replace(']','',$word);
		//	echo $word." ";
		//	echo $s."<br>";
			if($word==''){continue;}
			if(!isset($word_list[$word])){
				$word_list[$word]=0;
			}
			$word_list[$word]++;
		//	echo $word_list[$word]."<br>";
		}
	}
}
$rank_list=array();
$tmp_cnt=0;
$i=1;
while($i<=10){
	$tmp_cnt=0;
	foreach ($word_list as $wo => $cnt) {
		if($cnt>=$tmp_cnt){
			$temp=$wo;
			$tmp_cnt=$cnt;
		}
	}
	$rank_list[$i]=$temp;
	$word_list[$temp]=0;
	$i++;
}
foreach($rank_list as $r=>$w){
	echo "rank:".$r." word:".$w;
	echo "<br>";
	$sql="SELECT * FROM keyword WHERE day='$today' AND word='$w'";
	echo " hi <br>";
	$res=$conn->query($sql);
	if($res->num_rows>0){
		while($row=$res->fetch_assoc()){
			echo "rr ".$row['word']."<br>";
		}
	}else{
		$sql="INSERT INTO keyword VALUES('$r','$w','$today')";
		$conn->query($sql);
	}
}
$conn->close();




/*
$dictionary=array();
$docCount=array();
$words=array();
$w_num=0;

foreach ($collection as $docID => $doc) {
	$terms=explode(' ',$doc);
	$docCount[$docID]=count($terms);
	foreach ($terms as $t) {

		if(!isset($dictionary[$term])){
			$dictionary[$term]=array('df'=>0,'postings'=>array());
		}
		if(!isset($dictionary[$term]['postings']['$docID'])){
			$dictionary[$term]['df']++;
			$dictionary[$term]['postings'][$docID]=array('tf'=>0);
		}
		$dictionary[$term]['postings'][$docID]['tf']++;
	}

}
$tfidf=array();

$temp=('docCount'=>$docCount, 'dictionary'=>$dictionary);
$index=$temp;
$dCount=count()
*/
?>
