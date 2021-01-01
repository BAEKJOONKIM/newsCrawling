<?php
header('Conten-Type: text/html; charset=utf-8');
$servername='localhost';
$username='cse20140400';
$password='cse20140400';
$dbname='db_cse20140400';

$conn=new mysqli($servername,$username,$password,$dbname);

$today=date('Y-m-d',strtotime("+17 hours"));
$last=date('Y-m-d',strtotime('-10 day +17 hours'));
//echo $today;
$sql="SELECT * FROM keyword WHERE day>='$last' AND day<='$today'";
//echo $sql;
$q=$_GET["q"];
$word_list=array();
$select=$conn->query($sql);
//echo "hh";
if($select->num_rows>0){
	while($row=$select->fetch_assoc()){
		$word_list[]=$row['word'];
		//echo $row['word']."<br>";
	}
}

$hint="";
echo $q." ";
//echo $word_list[0];
if($q !==""){
	$len=strlen($q);
	foreach($word_list as $word){
		if(stristr($q, substr($word,0,$len))){
			if($hint === ""){
				$hint=" ".$word_list[array_search($word,$word_list)];
			}else{
				$hint .= " ".$word_list[array_search($word,$word_list)];
			}
		}
	}
}
echo $hint === "" ? "" : $hint;

?>
