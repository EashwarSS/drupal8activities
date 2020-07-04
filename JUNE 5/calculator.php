<title>Basic Calculator</title>
<?php  
  
interface CreateCalculator { 
   public  function addition($x,$y); 
   public  function subtraction($m,$n); 
   public  function multiplication($e,$f); 
   public  function divide($a,$b); 
}  
  
class Calculator implements CreateCalculator{ 
  
    public function addition($x,$y){ 
        $z=$x+$y;
		echo "This is calculator using interface: <br> <br>";
		echo "addition of  $x , $y is " .$z. "<br>"; 
	}
  
    public function subtraction($m,$n){ 
        $l=$m-$n;
		echo "subtraction  of  $m  - $n is " .$l. "<br>"; 
    } 
	public function multiplication($e,$f){ 
		$g=$e*$f;
		echo "multiplication  of  $e * $f is " .$g. "<br>"; 
    } 
  
    public function divide($a,$b){ 
        $c=$a/$b;
		echo "division  of  $a / $b is " .$c. "<br>"; 
    } 
}  
  
$obj = new Calculator; 
$obj->addition(6,3); 
$obj->subtraction(15,6); 
$obj->multiplication(3,3); 
$obj->divide(18,2); 
