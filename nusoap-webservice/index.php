<?php
  session_start();
  if(isset($_POST['kullaniciAdi'] )&& isset($_POST['parola']))
  {
    
    $kullaniciAdi=$_POST['kullaniciAdi'];
    $parola=$_POST['parola'];
    $_SESSION['kullaniciAdi']=$kullaniciAdi;
    require_once '/lib/nusoap.php';
    // client örneği yaratılır
    $client = new nusoap_client("http://localhost/damlakayali/server1.php", false); // false : WSDL gereksiz
    // SOAP methodu çağrılır 
    $params=array('kullaniciAdi'=>$kullaniciAdi,'parola'=>$parola );
    $uyeGiris=$client->call('UyeGiris',$params);
    if($uyeGiris==true)
    {
      
          print("<script>alert(\"Giris yapıldı... Anasayfaya yönlendirileceksiniz...\");
          window.open(\"anasayfa.php\",\"_self\")
        </script>");
        
    }
    else
    {
       print("<script>alert(\"KullanıcıAdı veya Şifre yanlış tekrar giriş yapın...\");
        window.open(\"index.php\",\"_self\")
          
        </script>");
    }
  }
      
?>


<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
 <link rel="stylesheet" type="text/css" href="cas/bootstrap.css">
 <meta name="viewport" content="width=device-width,initial scale=1">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

     <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script type="text/javascript">
      $(function(){
    
    $("#kayit").click(function()
        window.open("kayit.php","_self");

      );
    });

  })
</script>

    <title>Giriş Yap</title>
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
 <br/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div align="center">
              <h2 style="text-align:center">Giriş Yap</h2> <br />
               
              <div align="center" style="background-color:#e4e2e2 ; width:250px ; height:250px; border-radius:10px"> <br /> <br />
              <form action="" method="post">
                           
               <input type="text" name="kullaniciAdi" id="kullaniciAdi" placeholder="Kullnıcı Adı" /><br />                      
               <input type="password" name="parola" placeholder="Şifre"/><br /><br />           
               <button type="submit" class="btn btn-info" id="gonder">Giriş Yap</button>
               <button class="btn btn-info" id="kayit">Kaydol</button>
             
               </form> 
                       
            </div>
		</div>
	</div>
</div>
</div>

</body>
</html>
