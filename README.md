# books_markdown_to_opml
Proof of concept for OPML book lists generated from individual Obsidian book notes in markdown

Assumptions: 
a) you run a webserver locally on the device where you Obsidian.md book notes are
b) you have all your book notes in a specific folder that does not contain anything else but book notes
c) in Obsidian.md you use a template for book notes that adds these fields on the first 14 lines of any book note:
Type:: book \n
Text::  
Name:: 
Author:: 
Isbn::
Url::
Authorurl::
Referencelisturl::
Referenceurl::
inLanguage:: en
Category:: 
Comment::
List:: 
Maand::

Then the script mdtoopmltemplate.php will generate OPML lists based on those book notes.
After which you can use the script booklistpost.php to post those OPML files to your website's domain
On the server that hosts your domain you have bookformserverside.php that receives the posted OPML files and writes them to your webserver.

Thist blogpost describes the workflow for which these scripts were made as proof of concept: https://www.zylstra.org/blog/2022/01/federated-bookshelves-obsidian-notes-to-opml/
