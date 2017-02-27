<?php
	if(isset($_POST['username'] )&& isset($_POST['Name']) && isset($_POST['Surname'] )&& isset($_POST['pass']))
	{
		$ad=$_POST['Name'];
		$soyad=$_POST['Surname'];
		$kullaniciAdi=$_POST['username'];
		$parola=$_POST['pass'];
		require_once '/lib/nusoap.php';
		// client örneği yaratılır
		$client = new nusoap_client("http://damlakayali.com/damlakayali/server1.php", false); // false : WSDL gereksiz
		// SOAP methodu çağrılır 
		$params=array('adi' =>$ad,'soyadi'=>$soyad,'kullaniciAdi'=>$kullaniciAdi,'parola'=>$parola );
		$uyeEkle=$client->call('UyeEkle',$params);
		if($uyeEkle==true)
		{
					print("<script>alert(\"Kayıt Başarılı...\");
					window.open(\"giris.php\",\"_self\")
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

     <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


    <title>Kaydol</title>
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
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div align="center">
              <h2 style="text-align:center">Kaydol</h2>
                <br />
              <div align="center" style="background-color:#e4e2e2 ; width:250px ; height:380px; border-radius:10px">
                <br />
                <br />
            <form action="" method="post">
            <label>Name</label>
            <br />
            <input type="text" name="Name" />
            <br /><br />
            <label>Surname</label>
            <br />
            <input type="text" name="Surname" />
            <br /><br />
            <label>E-Posta</label>
            <br />
            <input type="text" name="username" />
            <br /><br />
            <label>Parola</label>
            <br />
            <input type="password" name="pass" />
            <br /><br />
            <button type="submit" class="btn btn-info" id="kaydol">Kaydol</button>   
            </form>    
        </div>
		</div>
	</div>
</div>
</div>

    </body>
    </html>
