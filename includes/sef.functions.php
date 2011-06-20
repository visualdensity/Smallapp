<?php
/**
 * Experimental mod_rewrite integration
 *
 * This is still a development spike. Working out
 * various methodologies on the best implementation
 * of mod_rewrite strategy
 *
 * @author Wee Keat Chin <weekeat@visualdensity.com>
 * $Id: sef.functions.php 117 2006-11-26 04:13:18Z weekeat $
 * @package Smallapp
 * @todo Move codes into functions
 * @todo Create SEF without mod_rewrite will be best
 **/

/**
 * Splitting URLs up into variables
 *
 * The format should be as follows:
 * /func/task/value/action/value
 **/
if ( $GLOBALS['_sef_url'] && 
	 !preg_match('/index.php/', $_SERVER['REQUEST_URI'], $matches) 
	) {

	// First, we strip off the http://somedomain.com from the site url
	if( preg_match('!^https?://[^/]+(\/.*)$!', $GLOBALS['_site_url'], $site_url_matches)) {
		$matched_folders = trim( $site_url_matches[1] );
	} else {
		trigger_error('Sorry, but your site url configuration does ' .
					  'seemed to be correct. Please check your config.'
					 );
	}

	if( strlen( $matched_folders) > 1 ) {
		// Match the above with the request URI and remove the folders
		$stripped_request_uri = str_replace( $matched_folders, '', $_SERVER['REQUEST_URI'] );
	} else {
		$stripped_request_uri = $_SERVER['REQUEST_URI'];
	}
	
	// Strip off the last / if it exist
	if( preg_match('!/$!', $stripped_request_uri, $matches) ) {
		$stripped_request_uri = substr( $stripped_request_uri, 0, -1);
	}

	// Strip off the first / if it exist
	if( preg_match('!^/!', $stripped_request_uri, $matches) ) {
		$stripped_request_uri = substr( $stripped_request_uri, 1 );
	}

	//Break them up into arrays
	$parameters = explode('/', $stripped_request_uri);

	// First value is always for _func variable
	// So, assign it appripriately and remove it
	$_REQUEST['func'] = $parameters[0];
	array_shift($parameters);

	// Recontruct variables into pairs of key=>values
	if ( sizeof($parameters) > 0 ) {
		$i = 0;
		do {
			$_REQUEST[ $parameters[$i] ] = $parameters[ $i+1 ];
			$i = $i+2;
		} while( isset( $parameters[$i] ) );
	}
}
?>
