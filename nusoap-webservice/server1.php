<?php
require_once 'lib/nusoap.php';

//Web Servisimizi oluşturuyoruz...
$server=new nusoap_server();
$ns="localhost/damlakayali/server1.php";
//Config WSDL
$server->configureWSDL('SOAProje');
$server->wsdl->schemaTargetNamespace=$ns;

$server->register('UyeEkle',
    array('adi' => 'xsd:string', 'soyadi' => 'xsd:string', 'kullaniciAdi' => 'xsd:string', 'parola' => 'xsd:string'
    ), //Göndreilen veriler, geriye bool değer veriyor.
    array('return' => 'xsd:boolean'));
$server->register('UyeGiris',
			array('kullaniciAdi'=>'xsd:string','parola'=>'xsd:string'),
			array('return' =>'xsd:boolean'));
$server->register('TweetAt',
									array('kullaniciAdi'=>'xsd:string','tweet'=>'xsd:string'),
									array('return'=>'xsd:string'));
function UyeEkle($adi,$soyadi,$kullaniciAdi,$parola)
{
  $host='localhost';
	$username='root';
	$password='';
	$db_name='db-webservice';
	

	$db=@new mysqli($host,$username,'',$db_name);
	
	if($db->connect_errno) die ('Bağlanti hatası:'.$db->connect_error);
	$db->set_charset("utf8");
		$stmt=$db->prepare("INSERT INTO uyeler VALUES(NULL,?,?,?,?)");
		if($stmt===false) die('Sorgu hatasi...'.$db->error);
		$stmt->bind_param("ssss",$adi,$soyadi,$kullaniciAdi,$parola);
		$stmt->execute();
    $db->close();
   		return true;
   			
}

function UyeGiris($kullaniciAdi,$parola)
{

  $host='localhost';
	$username='root';
	$password='';
	$db_name='db-webservice';
	$db=@new mysqli($host,$username,'',$db_name);
	
	if($db->connect_errno) die ('Bağlanti hatası:'.$db->connect_error);
	$db->set_charset("utf8");
		$stmt=$db->prepare("SELECT * FROM uyeler
												WHERE kullaniciAdi=? AND  parola=?");
		if($stmt===false) die('Sorgu hatasi...'.$db->error);
		$stmt->bind_param("ss",$kullaniciAdi,$parola);
		$stmt->execute();
		$sonuc=$stmt->get_result();

		if($sonuc->num_rows)
		{
			return true;	
		}
		else
		{
			return false;
		}				
}

function TweetAt($kullaniciAdi,$tweet)
{

	$host='localhost';
	$username='root';
	$password='';
	$db_name='db-webservice';
	$fav=0;
	$db=@new mysqli($host,$username,'',$db_name);
	
	   if($db->connect_errno) die ('Bağlantı Hatası:'.$db->connect_errno);
    $db->set_charset("utf8");
    $stmt=$db->prepare("SELECT uyeID FROM uyeler WHERE kullaniciAdi=?");
    if($stmt===false) die('Sorgu hatasi...'.$db->error);
    $stmt->bind_param("s",$kullaniciAdi);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();
    $uyeID=$row['uyeID'];

	  
	
		if($db->connect_errno) die ('Bağlanti hatası:'.$db->connect_error);
		$db->set_charset("utf8");
		$stmt=$db->prepare("INSERT INTO tweet VALUES(NULL,?,?,?)");
		if($stmt===false) die('Sorgu hatasi...'.$db->error);
		$stmt->bind_param("isi",$uyeID,$tweet,$fav);
		$stmt->execute();
    $db->close();
   		return true;
   			
}





// Bilgi alışverişini sağlamak için bu kod kullanılır
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>