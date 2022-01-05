<?php
 
if ($_POST) {

// load form fields
$code = $_POST['code'];

if ($code == "yourcodehere") {
$filePath = $_POST['lijstnaam'];
$hetlijstje = $_POST['hetlijstje'];

// save to file

$fileeind = fopen($filePath, "w");
fwrite($fileeind, $hetlijstje);
fclose($fileeind);


} // end if code bon
} // end if post

?>



