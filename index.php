<script>
function copia(testo) {
    var input = document.createElement('input');
    var area = document.getElementById(testo).value;
    input.setAttribute('value', area);
    document.body.appendChild(input);
    input.select();
    var risultato = document.execCommand('copy');
    document.body.removeChild(input);
    return risultato;
 }
</script>

<?PHP
// Generates a strong password of N length containing at least one lower case letter,
// one uppercase letter, one digit, and one special character. The remaining characters
// in the password are chosen at random from those four sets.
//
// The available characters in each set are user friendly - there are no ambiguous
// characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
// makes it much easier for users to manually type or speak their passwords.
//
// Note: the $add_dashes option will increase the length of the password by
// floor(sqrt(N)) characters.

$lenght = $_POST['l'];

if (!isset($lenght))
{
	$lenght = 14;

}

function generateStrongPassword($length = 4, $add_dashes = false, $available_sets = 'luds')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
	$password = str_shuffle($password);
	if(!$add_dashes)
		return $password;
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}


function getRandomLine($filename,$lenght) { 

    $string = '';

    while (strlen($string)!=$lenght) {
       $lines = file($filename) ; 
       $string = $lines[array_rand($lines)] ;
    }

    return $string;
} 

function upperacharacter($input) {

  $arr = str_split(trim(preg_replace('/\s+/', ' ', $input)));
  $dim = (count($arr))-1;
  $chr = rand (0, $dim);
  $arr[$chr] = strtoupper($arr[$chr]);

  return implode('',$arr);

}

function getspecials() {

  $spacial = array('.', '-', '_', '!', '?');
  $dim = (count($spacial))-1;
  $chr = rand (0, $dim);

  return $spacial[$chr];

}

function generateHumanPassword($lenght) {

   $pass = array();
   $password = "";

   $pass[0] = upperacharacter(getRandomLine('661562_parole_italiane.txt',$lenght-4));
   $pass[1] = getspecials();
   $pass[2] = getspecials();
   $pass[3] = rand (10, 99);
   $pass[4] = getspecials();

   shuffle($pass);

   foreach ($pass as $passkey) {
      $password = $password.$passkey;
   }

   return $password;

}





?>

<form action="" method="post">
    Lunghezza password (min 8 - MAX 20) <input type="number" value="<? echo $lenght;?>" name="l" min="8" max="20">
    <input type="submit" value="Genera">
</form>

<?php
echo "La tua nuova password semplice <input id='pass1' type='text' value='".generateHumanPassword($lenght)."' readonly size='".($lenght+10)."'>";
?><button onclick="copia('pass1')">copia</button><?php
echo "<br /><br />";
echo "La tua nuova password complicata <input id='pass2' type='text' value='".generateStrongPassword($lenght)."' readonly size='".($lenght+10)."'>";
?><button onclick="copia('pass2')">copia</button>
