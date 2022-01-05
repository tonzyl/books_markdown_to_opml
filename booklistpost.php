<?php
//this script takes some opml files and posts them to a form on my webserver
$formurl= "http://yourdomain/path/bookformserverside.php";
$code="yourcodehere"; // make calling the form at random slightly harder
//iterate through folder for OPML files changed today, grab name and content for each
$filecount = 0;
$path = './yourfolder/';
foreach (new DirectoryIterator($path) as $fileInfo) {
    if($fileInfo->isDot()) continue;
    $testname = $fileInfo->getFilename();
    $testtime = $fileInfo->getMTime();
    $testname = substr($testname, -4);
    $lastday = time()-86400; // in unix seconds
    //if file is an opml file and edited within last 24h   
    if ($testname == "opml" AND $testtime >= $lastday) {
    $filelist[$filecount] = $fileInfo->getFilename();    
    $filecount = $filecount+1;
    } // end if    
} // end foreach
//write name and content into a form, submit form
$schrijfcount=0;
$filecount = $filecount - 1; // counting from 0
while ($schrijfcount <= $filecount) {
//grab source opml 
$bestand = $path.$filelist[$schrijfcount];
$content[$schrijfcount]= file_get_contents($bestand);
// make form
$formData = array('code' => $code, 'lijstnaam' => $filelist[$schrijfcount], 'hetlijstje' => $content[$schrijfcount]);
$formOptions = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded",
        'method'  => 'POST',
        'content' => http_build_query($formData)
    )
);
// send form
$context = stream_context_create($formOptions);
$resp = file_get_contents($formurl, false, $context);
$schrijfcount=$schrijfcount+1;   
} //close while

//all done
?>