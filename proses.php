<?php
/*
*autor: Benito Alfredo Reyes Hernandez
*fecha:23-11-2015
*/
function ordutf8($string, &$offset) { //fungsi yang mengubah teks utf-8 ke integer ASCII
    $code = ord(substr($string, $offset,1)); 
    if ($code >= 128) {        //
        if ($code < 224) $bytesnumber = 2;               
        else if ($code < 240) $bytesnumber = 3;        
        else if ($code < 248) $bytesnumber = 4; 
        $codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
        for ($i = 2; $i <= $bytesnumber; $i++) {
            $offset ++;
            $code2 = ord(substr($string, $offset, 1)) - 128;        
            $codetemp = $codetemp*64 + $code2;
        }
        $code = $codetemp;
    }
    $offset += 1;
    if ($offset >= strlen($string)) $offset = -1;
    return $code;
}
//<!-- ========= fungsi php: ascii ke biner, biner ke x-encoding ============ -->
$text = $_POST["text"];
$offset = 0;
while ($offset >= 0) {
    $T_Ascii= ordutf8($text, $offset);
    $T_Bin= sprintf( "%08d", decbin( $T_Ascii )); 
    for ($i=0; $i <8 ; $i++) { 
      $arr[]=$T_Bin[$i];
    }   
    $arr_Ascii[]=$T_Ascii;
}

$_SESSION['data']=$arr;

if($_POST["EncodType"]==1){
      foreach ($arr as &$valor) {
        $arrLabel[]="      ".$valor;        
    }
    $_SESSION['data']=$arrLabel;    
    $_SESSION['EncodTitle']="Codificación Unipolar 1+";
}
if($_POST["EncodType"]==2){
    foreach ($arr as &$valor) {
        $arrLabel[]="\n        ".$valor;        
    }
    $_SESSION['data']=$arrLabel;

    foreach ($arr as &$valor) {
    if($valor==0)
    $valor = 1;
    else
        $valor=-1;
    }            
    unset($valor); 
    $_SESSION['EncodTitle']="Codificación NRZ-L 0+";
}
if($_POST["EncodType"]==3){
        foreach ($arr as &$valor) {
        $arrLabel[]="\n        ".$valor;        
    }
    $_SESSION['data']=$arrLabel;

    $varAux=1;
    foreach ($arr as &$valor) {
    if($valor==0)
    $valor = $varAux;
    else{
            $varAux=$varAux*-1;
            $valor=$varAux;
        }
    }    
    unset($valor); 
    $_SESSION['EncodTitle']="Codificación NRZ-I 0+";
}
if($_POST["EncodType"]==4){    
    foreach ($arr as &$valor) {
    if($valor==1){
        $arrAux[]=1;
        $arrAux[]=0;
    }    
    else{
            $arrAux[]=-1;
            $arrAux[]=0;
        }
    }        
    unset($valor); 
    foreach ($arr as &$valor) {
        $arrLabel[]="\n        ".$valor;
        $arrLabel[]=" ";
    }        
    $_SESSION['data']=$arrLabel;    
    $_SESSION['EncodTitle']="Retorno a cero";
}
if($_POST["EncodType"]==5){    
    foreach ($arr as &$valor) {
    if($valor==1){
        $arrAux[]=-1;
        $arrAux[]=1;
    }    
    else{
            $arrAux[]=1;
            $arrAux[]=-1;
        }
    }        
    unset($valor); 
    foreach ($arr as &$valor) {
        $arrLabel[]="\n        ".$valor;
        $arrLabel[]=" ";
    }        
    $_SESSION['data']=$arrLabel;    
    $_SESSION['EncodTitle']="Codificación Manchester 1+ (1= 0,1)";
}
if($_POST["EncodType"]==6){    
  $va1=-1;
  $va2=1;
    foreach ($arr as &$valor) {
    if($valor==0){
        $arrAux[]=$va1;
        $arrAux[]=$va2;
    }    
    else{      
            $arrAux[]=$va2;
            $arrAux[]=$va1;
            $va2=$va2*-1;
            $va1=$va1*-1;
        }       
    }        
    unset($valor); 
    foreach ($arr as &$valor) {
        $arrLabel[]="\n        ".$valor;
        $arrLabel[]=" ";
    }        
    $_SESSION['data']=$arrLabel;        
    $_SESSION['EncodTitle']="Codificación Manchester Diferencial";
}
if($_POST["EncodType"]==7){
	    foreach ($arr as &$valor) {
        $arrLabel[]="\n        ".$valor;        
    }        
    $_SESSION['data']=$arrLabel;
    $vaux=1;
    foreach ($arr as &$valor) {
    if($valor==0)
    $valor = 0;
    else{
        $valor=$vaux;
        $vaux=$vaux*-1;
      }
    }    
    unset($valor); 
    $_SESSION['EncodTitle']="Codificación AMI";
}
if($_POST["EncodType"]==8){
    $vaux=1;
    $i=0; 
    $band=0;   
    $cont=0;
    foreach ($arr as &$valor) {      
        if($valor==0){
            //if($band!=1)
            $cont++;
            $arrAux[$i] = 0;
            if ($cont==8) {
                if($sigUno=="+"){
                  $arrAux[$i-7]=0;
                  $arrAux[$i-6]=0;
                  $arrAux[$i-5]=0;
                  $arrAux[$i-4]=1;
                  $arrAux[$i-3]=-1;
                  $arrAux[$i-2]=0;
                  $arrAux[$i-1]=-1;
                  $arrAux[$i-0]=1;
                }
                else{
                  $arrAux[$i-7]=0;
                  $arrAux[$i-6]=0;
                  $arrAux[$i-5]=0;
                  $arrAux[$i-4]=-1;
                  $arrAux[$i-3]=1;
                  $arrAux[$i-2]=0;
                  $arrAux[$i-1]=1;
                  $arrAux[$i-0]=-1;
                }                                                    
            $cont=0;
            } 
          //$band=0;     
        } 
        else{           
            $arrAux[$i]=$vaux;
            if($vaux>0)
              $sigUno="+";
              else
                $sigUno="-";
            $vaux=$vaux*-1;
            //$band=1;
            $cont=0;
          }
        $i++;  
    }        
    unset($valor); 
    //funciones generales
    $_SESSION['EncodTitle']="Codificación B8ZS";
    foreach ($arr as &$valor) {
        $arrLabel[]="           ".$valor;        
    }
    $_SESSION['data']=$arrLabel;   
}

if($_POST["EncodType"]==9){
    $vaux=1;
    $i=0; 
    $band1=0;   
    $cont=0;
    foreach ($arr as &$valor) {      
        if($valor==0){            
            $cont++;
            $arrAux[$i] = 0;
            if ($cont==4) {
                if($band1%2==0){
                    if($sigUno=="+"){
                      
                      $arrAux[$i-3]=-1;
                      $arrAux[$i-2]=0;
                      $arrAux[$i-1]=0;
                      $arrAux[$i-0]=-1;
                      $vaux=$vaux*1;
                    }
                    else{                      
                      $arrAux[$i-3]=1;
                      $arrAux[$i-2]=0;
                      $arrAux[$i-1]=0;
                      $arrAux[$i-0]=1;
                      $vaux=$vaux*1;
                    } 
                } 
                else{
                    if($sigUno=="+"){
                      
                      $arrAux[$i-3]=0;
                      $arrAux[$i-2]=0;
                      $arrAux[$i-1]=0;
                      $arrAux[$i-0]=1;
                      $vaux=$vaux*-1;
                    }
                    else{                      
                      $arrAux[$i-3]=0;
                      $arrAux[$i-2]=0;
                      $arrAux[$i-1]=0;
                      $arrAux[$i-0]=-1;
                      $vaux=$vaux*1;
                    }                                                                   
            $cont=0;
            $band1=0;    
            }            
        }
        } 
        else{           
            $arrAux[$i]=$vaux;
            if($vaux>0)
              $sigUno="+";
              else
                $sigUno="-";
            $vaux=$vaux*-1;
            $band1++;
            $cont=0;
          }
        $i++;  
    }        
    unset($valor); 
    //funciones generales
    $_SESSION['EncodTitle']="Codificación HDB3";
    foreach ($arr as &$valor) {
        $arrLabel[]="           ".$valor;        
    }
    $_SESSION['data']=$arrLabel;   
}

$_SESSION['arr']=$arr;
$_SESSION['type']=$_POST["EncodType"];    
if($_SESSION['type']==4||$_SESSION['type']==5||$_SESSION['type']==6||$_SESSION['type']==8||$_SESSION['type']==9)
    $_SESSION['arr']=$arrAux;
?>