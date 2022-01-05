# books_markdown_to_opml
Proof of concept for OPML book lists generated from individual Obsidian book notes in markdown<br/>
<br/>
Assumptions: <br/>
a) you run a webserver locally on the device where you Obsidian.md book notes are<br/>
b) you have all your book notes in a specific folder that does not contain anything else but book notes<br/>
c) in Obsidian.md you use a template for book notes that adds these fields on the first 14 lines of any book note:<br/>
<br/>
Type:: book <br/>
Text::  <br/>
Name:: <br/>
Author:: <br/>
Isbn::<br/>
Url::<br/>
Authorurl::<br/>
Referencelisturl::<br/>
Referenceurl::<br/>
inLanguage:: <br/>
Category:: <br/>
Comment::<br/>
List:: <br/>
Maand::<br/>
<br/>
Then the script mdtoopmltemplate.php will generate OPML lists based on those book notes.<br/>
After which you can use the script booklistpost.php to post those OPML files to your website's domain.<br/>
On the server that hosts your domain you have bookformserverside.php that receives the posted OPML files and writes them to your webserver.<br/>
<br/>
Thist blogpost describes the workflow for which these scripts were made as proof of concept: https://www.zylstra.org/blog/2022/01/federated-bookshelves-obsidian-notes-to-opml/
