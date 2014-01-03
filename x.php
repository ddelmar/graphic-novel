<?php 
/* include('includes/head.php'); */
$hometown = "Syracuse, NY";

$parts = explode(",",$hometown);
$hometown = $parts['0'];

echo $hometown;
?>

