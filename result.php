<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="images/logoS.jpg" />
    <style type="text/css">
      .p_result{background: #fff; color: #000; font-size: 1.1em;}
      .boxResult{padding-top:80px;}
    </style>
    <title>Sinyal</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/cover.css" rel="stylesheet">
  </head>
  
<?php 
session_start(); 
include("proses.php");
?>
  <body>
   <div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Hasil</h3>              
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="index.html">Mulai</a></li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="boxResult">          
            <h4>Text</h4>           
            <p class="p_result"><?php echo $text;?></p>
            <h4>Kode ASCII:</h4>
            <p class="p_result"><?php foreach($arr_Ascii as $value)print($value." ");?></p>
            <h4>Kode Binary:</h4>
            <p class="p_result"><?php $cont=1; foreach($_SESSION['data'] as $value){print($value);if($cont==8){print(" ");$cont=0;}$cont++;};?></p>
          </div>        
        </div>
      </div>
    </div>    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>