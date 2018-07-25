<?php
require_once"talas.php";

  Class Hidrogram extends Talas
  {
     
	 public function SCS($name)
		{
           echo'Metoda Talas SCS naziv sliva = '.$name.' <br><br>';
          	
		}

	  public function trKi($Tk)
		  {
		  	echo'Trajanje efektivne kise :';
		  	echo'<br>';
           $result = [];
           foreach($Tk as $value)
	           {
                array_push($result,$value);

                echo'Tk= '.$value.' min.<br>';
	           }
	        return $result;
		  }

	  public function vKa($L,$Lc,$Iu)  //vreme kasnjenja----
	    {
	    	
	      $tp =0.751 * ((($L*$Lc)/(($Iu)**0.5))**0.336);
           
           //echo'vreme kasnjenja tp = '.$tp.'<br>';

           return $tp;
	      	      
	    }
	  public function vPHi($Tk,$a,$L,$Lc,$Iu)  //vreme porasta hidrograma---
	    {
		    $result=[];

		  	foreach($Tk as $value)
		  	{
	         array_push($result,$value/$a);

	          $Tph = ($value/$a) + $this->vKa($L,$Lc,$Iu);

	          //echo'vreme porasta hidrograma Tph ='.$Tph.'<br>';
		  	}
		  	
		  	return $result;
          
   	    }

	  public function vOHi($Tk,$k,$a,$L,$Lc,$Iu) //vreme opdanja hidrograma  $Tr=k * Tph
	    {
		     $result = [];

		     foreach($Tk as $value)
		     {
		     	array_push($result,$value/$a);
		       
		       $Tr = $k * (($value/$a) + $this->vKa($L,$Lc,$Iu));
	          
	          //echo'vreme opadanja hidrograma Tr = '.$Tr.'<br>';
	         }
	        
	          return $result;  

	    }

	  public function bazaHi($Tk,$k,$a,$L,$Lc,$Iu) //baza hidrograma----//$Tb = $Tph + $Tr;//$Tb =($this->vOHi($Tk,$L,$Lc,$Iu)) + ($this->vPHi($Tk,$L,$Lc,$Iu));
		  {
		       $result = [];
		       foreach($Tk as $value)
		       {
	           array_push($result,$value/$a);
	           
	           $Tb = (($value/$a) + $this->vKa($L,$Lc,$Iu))+( $k * ($value/$a) + $this->vKa($L,$Lc,$Iu));
		       
	           //echo'baza hidrograma Tb ='.$Tb.'<br>'; 
	           }
	           
	           return $result;
          
		  }

	  public function mKiTr($Tk,$Ap,$b,$c,$Bm,$H24h) //merodavna kisa trajanja--//$Htp =(($a*$Tk)/1440)*(((1440*$A+1)/($A*$Tk+1))**0.82)*$H24h;
		  {
			   $result = [];
			   foreach($Tk as $value)
			   {
			    array_push($result,$value/$b,$value*$c);	 

		        $Htp = ($value/$b) *((((1440*$Ap)+1)/(($value*$c) + 1))**$Bm)*$H24h;          

		       // echo'merodavna kisa trajanja Htp = '.$Htp.'<br>';
	           }
	         
		         return $result;            
		  }

	  public function defV($CN)  //deficit vlage----
		  {
		  	

            $d = 25.4*((1000/$CN)-10);           

            //echo'deficit vlage d = '.$d.'<br>';

             return $d;
           
		  }

	  public function efPad($Tk,$Ap,$b,$c,$H24h,$Bm,$CN) //efektivne padavine---//$Pe =(($Htp-0.2*$d)**2)/($Htp+0.8*$d);
		  {
			   $result = [];
			   foreach($Tk as $value)
			   {
	            array_push($result,$value/$b,$value*$c);

		       $Pe =(((($value/$b) *((((1440*$Ap)+1)/(($value*$c) + 1))**$Bm)*$H24h) - (0.2 * $this->defV($CN)))**2)/((($value/$b) *((((1440*$Ap)+1)/(($value*$c) + 1))**$Bm)*$H24h) + (0.8 * $this->defV($CN)));	       

		      // echo'efektivne padavine Pe = '.$Pe.'<br>';	          
	           }
	          
		       return $result;	       
		  }

	  public function maxO($Tk,$Ap,$k,$a,$L,$Lc,$Iu) //max Ordinata-----//$q_max = (0.56 * $A)/$Tb;
		  {
			  	$result = [];
			  	foreach($Tk as $value)
			  	{
			  	 array_push($result,$value/$a);

		        $q_max = (0.56 * $Ap)/((($value/$a) + $this->vKa($L,$Lc,$Iu))+($k*(($value/$a) + $this->vKa($L,$Lc,$Iu))));            
	            
		       // echo'max. Ordinata q_max = '.$q_max.'<br>';
	            }
	           
		        return $result;	        
		  }

	   public function maxP($Tk,$Ap,$k,$a,$b,$c,$L,$Lc,$Iu,$H24h,$Bm,$CN) //max proticaj----// $Qmax = $q_max * $Pe;
	   {	
	        echo'<br>';
	        echo'maksimalni proticaj Qmax verovatnoce 1% ';
	        echo'<br><br>';	   	  		   	  
		   	$result = [];
            
		   	foreach($Tk as $value)
		   	{		   	  	
		         //array_push($result,$value/$a,$value/$b,$value*$c);

		       $Qmax =  (0.56 * $Ap)/((($value/$a) + $this->vKa($L,$Lc,$Iu))+($k*(($value/$a) + $this->vKa($L,$Lc,$Iu)))) * (((($value/$b) *((((1440*$Ap)+1)/(($value*$c) + 1))**$Bm)*$H24h) - (0.2 * $this->defV($CN)))**2)/((($value/$b) *((((1440*$Ap)+1)/(($value*$c) + 1))**$Bm)*$H24h) + (0.8 * $this->defV($CN)));

		        array_push($result,$Qmax);

	               if($result < $Qmax)
	               {

	                  $result = $Qmax;

	               }
	               
		        echo 'Qmax = '.$Qmax.'<br>';
		      
             }
             rsort($result);
             echo'<br>';
             echo'Usvaja se Qmax = '; print_r($result[0]); echo' m3/sec ';
             echo'<br>';
             
	         return $result;
			
	    } 

   
	public function connect($servername,$username,$password,$dbname,$name,$a,$b,$c,$k,$L,$Lc,$Iu,$Ap,$Bm,$H24h,$CN,$r)

	{
	
   $conn = new PDO("mysql:host=localhost;dbname=talas",$username,$password);  
      try
      {
      	$sql ="INSERT INTO scs(name,a,b,c,k,L,Lc,Iu,Ap,Bm,H24h,CN,Qmax)
       VALUES('$name','$a','$b','$c','$k','$L','$Lc','$Iu','$Ap','$Bm','$H24h','$CN','$r[0]')";
       
       $conn->exec($sql);
       echo'<br>';	
       echo'New record insert successfully';
       echo'<br>';

      }catch(PDOException $e)
      {
      	die('ERROR : record can not be insert '.$e->getMessage());
      }  
 //    try{
 //    	$sql = "UPDATE scs SET T_min=50, Qmax=4.42 WHERE id=2 ";
 //    	$conn->exec($sql);
 //    	echo'<br>';
 //    	echo'New  record update successfully';
       
	//    }catch(PDOException $e)
	//    {
 //         echo'ERROR: record can not be update '.$e->getMessage();
	//    }


 //       // try
 //       // {
 //       //   $sql="SELECT id,T_min, Qmax FROM scs WHERE id=7";
        
 //       //   $result= $conn->query($sql);

 //       //   if($result->rowCount()>0)
	//       //    {
 //       //        while($row = $result->fetch())
	//       //         {
 //       //              echo $row['id'].'<br>';
 //       //              echo $row['T_min'].'<br>';
 //       //              echo $row['Qmax'].'<br>';
	//       //         }
	//       //    }else
	//       //    {
	//       //    	echo'No records';
	//       //    }
         
 //       // }catch(PDOException $e)
 //       // {
 //       // 	echo'ERROR:'.$e->getMessage();
 //       // }
	 }    
  }    
 

?>