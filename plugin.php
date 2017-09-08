<?php
/*
Plugin Name: Dynamic linker
Plugin URI: 
Description: This plugin allows you to add links on the fly by adding a dash plus any text to the end of a already shortened url
Version: 1.0
Author: Brayden Storms
Author URI: https://github.com/Storm-Engineering
*/
// Hook our custom function into the 'pre_redirect' event
yourls_add_action( 'redirect_keyword_not_found', 'peters_redirection' );

/*
This intercepts the default keyword not found event and adds it
the database if it has a parent short url.

For instance if the user has a short url of /s going to google.com
and he typed into an email website.com/s-header it would create that link and redirect to google.com
*/
function peters_redirection( $args ) {
	//Grab the keyword
	$keyword = $args[0];
	
	//This is the original keyword we are going to grab the url from
	$shortKeyword = explode("-",$keyword);
	
	//Grabbing the url
	
	$decoded = json_decode(file_get_contents(yourls_site_url(false)."/yourls-api.php?username=chicken&password=yokien&action=url-stats&shorturl=".$shortKeyword[0]."&format=json"), true);
	//Get the link
	$url = $decoded["link"]["url"];
	//Put the new pair in the database
	file_get_contents(yourls_site_url(false)."/yourls-api.php?username=chicken&password=yokien&action=shorturl&url=$url&keyword=".$args[0]);
	//This doesn't change because it hasn't updated the database in time so we have to do it manually here
	yourls_update_clicks( $keyword );
	yourls_log_redirect( $keyword );
	//Redirect manually
	yourls_redirect($url,302);
}
//Taken from Ozh
// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_filter( 'get_shorturl_charset', 'ozh_hyphen_in_charset' );
function ozh_hyphen_in_charset( $in ) {
	return $in.'-';
}
?>