Yourls Dynamic Linker
=====================

A plugin for YOURLS allowing dynamic short url generation by having a base short url and adding a dash to it with whatever text you want.

To Install:
====================
Simply put plugin.php into a folder in your plugins folder under user/plugins/ and don't forget to disable unique urls in
config.php  If you didn't understand what i just said replace: define( 'YOURLS_UNIQUE_URLS', true); 
with define( 'YOURLS_UNIQUE_URLS', false ); in config.php


Example:
=====================
If the user has a short url of /s going to google.com
and he typed into an email http://hiswebsite.com/s-header it would create that link and redirect to google.com,
without ever having to create a new url in the yourls dashboard
