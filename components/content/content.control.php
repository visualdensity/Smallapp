<?php
/**
 * Content component
 *
 * This content commponent is a standard
 * component with this app. It also serves
 * as an example of how you can use it
 * to create your own component.
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: content.control.php 106 2006-08-24 22:01:45Z weekeat $
 * @package ComContent
 **/

/**
 * Global constant that is used to ensure that current file
 * is included or called via the main index page. This will
 * prevent others from accessing this file directly.
 **/
defined( '_VALID_ENTRY_' ) or die( 'Are you trying to be a smart ass?' );

loadConfig('content');

showPage();


/**
 * Show page function
 *
 * The name says it. This function is used
 * to show pages of the content component.
 *
 * @return void
 **/
function showPage() 
{
	$page = '';
	$page = (string) @$GLOBALS['_clp']['page'];
	
	if( strlen($page) > 0 ) {
		setView($page);
	} else {
		setView( 'home' );
	}
}
?>
