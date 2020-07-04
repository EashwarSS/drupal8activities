<title>Trait</title>
<?php
require_once('traitlog.php');
$Log = new Log();
$Log->Read('test.txt');
echo "<pre>";
echo $Log->Read('test.txt');