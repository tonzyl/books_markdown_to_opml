<?php
// this script goes through a folder to create lists of books
// 

// iterate through folder
$folder = "./relativepath/yourfolder";
// Counts all files and directories in directory except "." and "..".
$filecount = 0;
foreach (new DirectoryIterator($folder) as $fileInfo) {
    if($fileInfo->isDot()) continue;
    $filelist[$filecount] = $fileInfo->getFilename();
    $filechanged[$filecount] = $fileInfo->getMTime();
    $filecount = $filecount+1;
}
$totalfiles = $filecount-1; //count from 0
$filecount = 0;

//go through ALL files in folder, to build the lists
//for each filename, read the lines that have the data fields and store in a variable for that file
//then increase counter
$telfile = 0;
while ($telfile <= $totalfiles) { 
if ($file = fopen($folder.$filelist[$telfile], "r")) {
    $tellijn=1;
    while($tellijn<15) { 
      $line = fgets($file);
      $bestand[$telfile][$tellijn] = $line;
      $tellijn = $tellijn+1;  
    }
    fclose($file);
    }
    $telfile=$telfile+1;   
} //close while
$telfile = 0;
// all files and their first 14 rules are now in an array

// for each opml list the line that describes the collection change to your prefs
$collectienaam[1]= '<outline type="collection" text="Fiction I read in 2021" author="Ton Zijlstra" url="https://zylstra.org/opml/books/fiction2021.opml" comment="I read about one fiction book per week, and tend towards science fiction. Last read is top of list.">';
$collectienaam[2]= '<outline type="collection" text="Fiction I read in 2020" author="Ton Zijlstra" url="https://zylstra.org/opml/books/fiction2022.opml" comment="I read about one fiction book per week, and tend towards science fiction. Last read is top of list.">';

// loop to create an outline line and add it to the correct opml list
$boekregel ='';
while ($telfile <= $totalfiles) { 
      // loads all lines with data fields
     $type = $bestand[$telfile][1];
     $text = $bestand[$telfile][2];
    $name = $bestand[$telfile][3];
    $author = $bestand[$telfile][4];
    $isbn = $bestand[$telfile][5];
$url = $bestand[$telfile][6];
$authorurl = $bestand[$telfile][7];
$referencelisturl = $bestand[$telfile][8];
$referenceurl = $bestand[$telfile][9];
$language = $bestand[$telfile][10];
$category = $bestand[$telfile][11];
$comment = $bestand[$telfile][12];
$list = $bestand[$telfile][13];
// cuts the loaded lines to the content of a datafield, the -1 is to cut the eol
$type = substr($type, 7, 4);
$text = mb_substr($text, 7, -1);
$name = mb_substr($name, 7, -1);
$author = mb_substr($author, 9, -1);
$isbn = mb_substr($isbn, 7, -1);
$url = mb_substr($url, 6, -1);
$authorurl = mb_substr($authorurl, 12, -1);
$referencelisturl = mb_substr($referencelisturl, 19, -1);
$referenceurl = mb_substr($referenceurl, 15, -1);
$language = mb_substr($language, 13, -1);
$category = mb_substr($category, 11, -1);
$comment = mb_substr($comment, 10, -1);
$list = mb_substr($list, 7, -1);

//make an outline line for a book in the following format
//<outline type="book" text="mandatory" name="" author="" isbn="" url="" comment="" authorurl="" referencelisturl="" referenceurl="" inLanguage="" category=""/>
if ($type=="book") {
$boekregel='<outline type="book" text="'.$text.'" name="'.$name.'" author="'.$author.'" isbn="'.$isbn.'" url="'.$url.'" authorurl="'.$authorurl.'" referencelisturl="'.$referencelisturl.'" referenceurl="'.$referenceurl.'" inLanguage="'.$language.'" category="'.$category.'" comment="'.$comment.'" />';

//add it to the right collection = opml list  
if ($list == "fiction2021") {
	$collectienaam[1]=$collectienaam[1]."\n".$boekregel;
}
if ($list == "fiction2020") {
	$collectienaam[2]=$collectienaam[2]."\n".$boekregel;
}
} // end if book
$boekregel='';   
    $telfile=$telfile+1;   
} //close while
$telfile = 0;
// now add the front stuff and the ending to complete opml file
$ending = "\n</outline>\n</body>\n</opml>";
$voorkom = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<?xml-stylesheet type="text/xsl" href="https://zylstra.org/opml/books/test.xsl"?>'."\n".'<opml version="2.0">'."\n".'<head>'."\n".'<title>Ton Zijlstra';
$voorkom = $voorkom."'";
$voorkom = $voorkom.'s Booklists</title>'."\n".'<url>https://zylstra.org/opml/books/books.opml</url>'."\n".'<dateCreated>';
$nu = date("j F Y H:i:s");
$voorkom = $voorkom.$nu."</dateCreated>\n<ownerName>Ton Zijlstra</ownerName>\n<ownerId>https://zylstra.org/blog</ownerId>\n<ownerEmail>blog@zylstra.org</ownerEmail>\n</head>\n<body>\n";
$collectienaam[1]=$voorkom.$collectienaam[1].$ending;
$collectienaam[2]=$voorkom.$collectienaam[2].$ending;


//write the files 
file_put_contents("fiction2021.opml", $collectienaam[1]);
file_put_contents("fiction2020.opml", $collectienaam[2]);
//file_put_contents("extendasneeded.opml", $content)
?>
