<?php

require_once"hidrogram.php";
//$id = $_POST["id"];
$name = $_POST["name"];
$Tkh = $_POST["Tkh"];
$Tk = explode(',',$Tkh);

$a= 120; //min -> h;
$b=1440; //za 24 h p = 1% 1440 ; 12h p = 1%  770 ;
$c=0.3;
$k=1;
$L=$_POST["L"];    //km;
$Lc=$_POST["Lc"]; //km;
$Iu=$_POST["Iu"];  // %;
$Ap=0.3;
$Bm=0.82;  //koef. sa grafikona za date uslove;
$H24h=$_POST["H24h"]; // mm/24h;
$CN=$_POST["CN"];


$servername = 'localhost';
$username = 'root';
$password = NULL;
$dbname = 'talas';

$hidroscs = new Hidrogram();
$hidroscs->SCS($name);
$hidroscs->trKi($Tk);
$hidroscs->vKa($L,$Lc,$Iu);
$hidroscs->vPHi($Tk,$a,$L,$Lc,$Iu);
$hidroscs->vOHi($Tk,$k,$a,$L,$Lc,$Iu);
$hidroscs->bazaHi($Tk,$k,$a,$L,$Lc,$Iu);
$hidroscs->mKiTr($Tk,$Ap,$b,$c,$Bm,$H24h);
$hidroscs->defV($CN);
$hidroscs->efPad($Tk,$Ap,$b,$c,$H24h,$Bm,$CN);
$hidroscs->maxO($Tk,$Ap,$k,$a,$L,$Lc,$Iu);

$r = $hidroscs->maxP($Tk,$Ap,$k,$a,$b,$c,$L,$Lc,$Iu,$H24h,$Bm,$CN);


$hidroscs->connect($servername,$username,$password,$dbname,$name,$a,$b,$c,$k,$L,$Lc,$Iu,$Ap,$Bm,$H24h,$CN,$r);


echo'a = '.$a.'<br>'; //min -> h;
echo'b = '.$b.' za 24h p = 1%<br>'; //za 24 h p = 1% 1440 ; 12h p = 1%  770 ;
echo'c = '.$c.'<br>';
echo'k = '.$k.'<br>';
echo'L = '.$L.' km.<br>';    //km;
echo'Lc = '.$Lc.' km.<br>'; //km;
echo'Iu = '.$Iu.' %.<br>';  // %;
echo'Ap = '.$Ap.'<br>';
echo'Bm = '.$Bm.' koef. za date uslove<br>'; //koef. sa grafikona za date uslove;
echo'H24h = '.$H24h.'<br>'; // mm/24h;
echo'CN = '.$CN.'<br>';
?>