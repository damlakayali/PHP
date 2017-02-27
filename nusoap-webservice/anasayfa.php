<?php
session_start();
$kullaniciAdi=$_SESSION['kullaniciAdi'];
 if(isset($_POST['tweet']))
 {
  $tweet=$_POST['tweet'];

  require_once '/lib/nusoap.php';
    // client örneği yaratılır
    $client = new nusoap_client("http://localhost/damlakayali/server1.php", false); // false : WSDL gereksiz
    // SOAP methodu çağrılır 
    $params=array('kullaniciAdi' =>$kullaniciAdi,'tweet'=>$tweet);
    $TweetAt=$client->call('TweetAt',$params);
    if($TweetAt)
    {
      print("<script>alert(\"Tweet Atıldı\");
          
        </script>");
    }

 }
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial scale=1">
     <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script
      src="https://code.jquery.com/jquery-3.1.1.js"
      integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
      crossorigin="anonymous"></script>
            <style type="text/css">
          .tweetler{
            border:1px solid;
            width: 500px;
            margin: 5px;
          }
      </style>
    <title>Ana Sayfa</title>
  </head>
  <body>


    <div class="container-fluid">
      <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:#e8e8e8" align="center">
      <br/>
      <img src="logo.png" style="height:60px; width:100px; ">
      <br><br>
      </div>
    </div>
      <br/>
  <div>
  <div align="center">
  <form action="" method="post">  
    <label>Tweet At</label><br>
    <input type="text" id="tweet" name="tweet" style="height:60px; width:500px ;" placeholder="Tweetinizi yazın!"><br><br>
    <button type="submit" class="btn btn-info">Tweet At</button>
  </form>
  <br>
  <?php
   $host='localhost';
  $username='root';
  $password='';
  $db_name='db-webservice';
  $fav=0;
  $kullaniciAdi=$_SESSION['kullaniciAdi'];

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
        
  
    $temp=$db->prepare("SELECT takipEdilenID FROM takip
              WHERE takipEdenID=?");
    if($temp===false) die('Sorgu hatasi...'.$db->error);
    $temp->bind_param("i",$uyeID);
    $temp->execute();
    $result=$temp->get_result();
    $i=0;
    $deneme= array();
    while ($row=$result->fetch_assoc()) 
    {
      $takipEdilen=$row['takipEdilenID'];
      $tweetler=$db->prepare("SELECT tweet FROM tweet
                  WHERE uyeID=?
                  GROUP BY tweetID DESC");
      if($tweetler===false) die('Sorgu hatası:'.$db->error);
      $tweetler->bind_param("s",$takipEdilen);
      $tweetler->execute();
      $sonuclar=$tweetler->get_result();
      
      
      while ($tweetler=$sonuclar->fetch_assoc()) 
      {
        $tweetText=$tweetler['tweet'];
        $deneme[] = $tweetText;
      }
    }
     $db->close();
    
    $uzunluk=count($deneme);
    

    while($i<$uzunluk)
    {
      echo "<div style=\"width:500px,margin:0 auto,height:100px\" class=\"tweetler\">";
      echo "<p>";
      echo $deneme[$i];
      echo "</p><br>";
      echo "</div>";
      $i++;

    }
  ?>

    </div>
  </div>
 </div>

  </body>
</html>