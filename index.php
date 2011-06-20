<?php
/**
 * Smallapp framework
 *
 * Smallapp framework is based loosely on the MVC
 * model, where a dispatcher is launched and captures
 * all events before passing them over to the appropriate
 * component controllers in its designated location.
 *
 * Smallapp uses the <b>func</b> variable in the URL
 * to determine which component is being called. For
 * example, let's look at the following URL:
 *
 * - http://smallapp.weekeat.com/?func=content
 *
 * The above URL has a <b>func</b> variable named 'content'.
 * When Smallapp receives this variable, it will call
 * the Content component by calling the following file:
 *
 * - /path/to/site/components/content/content.control.php
 *
 * The above dispatching job is handled by a function called
 * dispatcher(), which is loaded via the template's body()
 * call. As shown above, are located in the components/
 * folder. All files must comform to a naming scheme like:
 *
 * - funcname.control.php
 *
 * As with any MVC framework, each components has its own set
 * of views, which mainly resides in the views/ folder. It 
 * will generally reside in a folder that carries the name
 * of the <b>func</b> variable name. So, for the URL mentioned
 * earlier in the above, the Content component will have its
 * view folder in the following path:
 *
 * - /path/to/site/views/content/
 *
 * You can call your views anytime in your component's 
 * controller by calling the setView() function, which
 * is located in the includes/main.functions.php file.
 *
 * <b>Note:</b>
 * All controllers should use the $_clp varioble to 
 * access $_POST, $_GET or $_REQUEST variables. 
 * The structure of the array will be the same
 * as the $_REQUEST array structure.
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: index.php 118 2006-11-26 04:13:44Z weekeat $
 * @package Smallapp
 **/

/**
 * Global constant that is used to ensure that files that 
 * are included or called comes from the main index page. 
 * This will prevent others from accessing those file directly.
 **/
define( '_VALID_ENTRY_' , true);

if ( !file_exists( 'config.php') ) {
	die('Please setup the configuration file first. Use config.php-example as guide.');
}

include_once( 'config.php');
include_once( 'includes/tools.functions.php' );
include_once( 'includes/main.functions.php' );
include_once( 'includes/sef.functions.php' );

$GLOBALS['_func']	= null;
$GLOBALS['_clp']	= null;
$GLOBALS['_tpl']	= null;

$GLOBALS['_clp'] 	= sanitise($_REQUEST);

if ( strlen(@$GLOBALS['_clp']['func']) > 0 ) {
	$GLOBALS['_func']	= (string) $GLOBALS['_clp']['func'];
}

ob_start();
loadTemplate( $GLOBALS['_template']);
ob_end_flush();
?>
