<?php
require('txt2html.php');

$log_dir="chanlogs";
$log_name="#slackhappy.20110126.log.txt";
$log_path=$log_dir.'/'.$log_name;
$log_handle=fopen($log_path,"r");
$log_size= filesize($log_path);


$print_contents=file_get_contents($log_path, false);
$print_contents=txt2html($print_contents);

?>

<html><head></head><body>

<?php
	echo($print_contents);
?>
</body></html>
