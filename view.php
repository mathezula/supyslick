<?php
include('parse.php');

$directory = 'chanlogs';
$logfile = $_GET['parse'];

$parser = new LogParser($directory . '/' . $logfile, new HtmlLogRenderer());
$parser->parse();

?>
