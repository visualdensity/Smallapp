<?php
/**
 * Core functions that powers Smallapp
 *
 * Functions included in this file serves as the main
 * functions that is frequently used by Smallapp. Most
 * likely you won't be needing to use these functions.
 * For various common task functions, please refer
 * to the tools.functions.php
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: main.functions.php 106 2006-08-24 22:01:45Z weekeat $
 * @package Smallapp
 * @todo Add a setPageTitle() function for title customisation
 **/

/**
 * Global constant that is used to ensure that current file
 * is included or called via the main index page. This will
 * prevent others from accessing this file directly.
 **/
defined( '_VALID_ENTRY_' ) or die( 'Are you trying to be a smart ass?' );


/**
 * Dispatcher function
 *
 * Since this is a small script, just use
 * function to call the files for processing.
 * The reason for this method is to make sure
 * it'll be easier to manage and extend in the
 * future.
 *
 * @access private
 * @param string $func Function parameter, which will be used to call the file
 * @return void
 **/
function dispatch( $func = null ) 
{
	if( $func ) {
		$function = $func;	
	} else {
		$function = $GLOBALS['_default_func'];
	}

	$path 		= $GLOBALS['_control_path'] . $function. '/';
	$filename 	= $function . '.control.php'; 
	
	if ( file_exists( $path . $filename) ) {
		include( $path . $filename );
	} else {
		trigger_error( "Sorry, but '" . $function. 
						"' component's control file cannot be found" 
					 );
	}
}//dispatch


/**
 * Load config
 *
 * Automatically load controller's config file
 * using a standard naming convention -
 * controllername.config.php in the the controller's
 * folder.
 * <code>
 * <?php
 * 	loadConfig('content');
 * 	//same as include('components/content/content.config.php');
 * ?>
 * </code>
 *
 * @param string $func Controller name
 * @return void
 **/
function loadConfig( $func = null ) 
{
	if( $func ) {
		$function = $func;	
	} else {
		$function = $GLOBALS['_default_func'];
	}

	$path 		= $GLOBALS['_control_path'] . $function. '/';
	$filename 	= $function . '.config.php'; 

	if ( file_exists( $path . $filename) ) {
		include( $path . $filename );
	} 
}//config



/**
 * Set view for component
 *
 * This function loads the component views, which are
 * located in the views/<component_name>/ folder. All
 * views must comply to a naming scheme for this function
 * to work. The naming scheme is:
 *		- view_name.view.php
 *
 * So, you may have a collection of views in your views
 * folder (e.g. views/contact/) like:
 *		- form.view.php
 *		- thanks.view.php
 *		- errors.view.php
 *
 * To use setView() function in your controller, you
 * can follow this example:
 *
 * <code>
 *<?php
 *	//Current component - contact
 *	//process form here 
 *	if( $form_validate ) {
 * 		setView('thanks'); //load views/contact/thanks.view.php
 *	} 
 *?>
 * </code>
 * 
 * @param string $view_name The name of view you wish to use.
 * @return void
 **/
function setView( $view_name = "" ) 
{
	if( $GLOBALS['_func'] ) {
		$function = $GLOBALS['_func'];	
	} else {
		$function = $GLOBALS['_default_func'];
	}

	$path = $GLOBALS['_view_path'] . $function . '/';
	$file = $view_name . '.view.php';

	if ( file_exists( $path . $file) ) {
		include( $path . $file );
	} else {
		trigger_error( "Sorry, but '" . $view_name . "' view for '" .  
						$GLOBALS['_func'] . "' component cannot be found"
					 );
	}
}//setView


/**
 * Load template function
 *
 * This function loads the current template for the overall
 * site. If the current template could not be found, it will
 * revert to Smallapp's default template. 
 *
 * All custom templates must reside in the following path:
 * - /path/to/site/templates/<template_name>/
 *
 * All templates <b>must have a index.tpl.php</b> file 
 * for it to work.
 *
 * @param string $func Component name
 * @access private
 * @return void
 **/
function loadTemplate($template) 
{

	$path = $GLOBALS['_tpl_path'] . $template. '/';
	$file = 'index.tpl.php';
	
	if ( file_exists( $path . $file ) ) {
		include( $path . $file );
	} else {
		include( $GLOBALS['_tpl_path'] . 'default/index.tpl.php' );
	}
}//loadTemplate


/**
 * Body function
 *
 * This is a reference or alias of dispatch() function in the
 * above. This function is used in the template to generate
 * the body of the website. 
 *
 * The reason for this is so that it is easier to
 * understand and remember this function.
 *
 * Example of use:
 * <code>
 * 	<html>
 * 	<head>
 *		<title><?php pageTitle(); ?></title>
 *	</head>
 *
 * 	<body>
 *		<div id="mainbody">
 *			<?php body(); ?>
 *		</div>
 * 	</body>
 *	</html>
 * </code>
 *
 * @access public
 * @see dispatch()
 * @return void
 **/
function body() 
{
	dispatch($GLOBALS['_func']);
}//body



/**
 * Sanitise recursively
 * 
 * A separate function to recursively sanitise variables.
 * This function strips all HTML tags by default for safety
 * purposes. If you do not wish to have any tags strip, you
 * can use $_POST, $_GET or $_REQUEST instead.
 *
 * <code>
 * <?php
 * 	$dirty_arr = array( "<script>alert('hello');</script>", "O'Reilly" );
 *
 * 	$clean_arr = sanitise( $dirty_arr );
 * 	print_r( $clean_arr );
 * 	// Result will be the following:
 * 	// alert('hello')
 * 	// O\'Reilly
 * ?>
 * </code>
 *
 * @param array $arr
 * @return $arr
 */
function sanitise($arr) 
{
    $c_arr		= null;
    $auto_quote = false;
    $to_remove  = array( ";", "`", "--", "\\\\");
    
    if( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) {
        $auto_quote = true;
    }
    
    foreach($arr as $key => $value) {
        
        if( is_array( $value ) ) {
            $c_arr[$key] = sanitise($value);
        } else {
            
			$value = trim( $value );

            if( !$auto_quote ) {
                $value = addslashes($value);
            }
            
            $value = str_replace($to_remove, '', $value);
			$value = strip_tags($value);
            
            $c_arr[$key] = $value;
        }
    }
    
    return $c_arr;
}//sanitize



/**
 * Page title
 *
 * This function allows you to override page title
 * of the site at a particular page. 
 *
 * @param string $title Title to be appended to the site title
 * @param boolean $override_all Set to true if you do not want the title to be appended to site title
 **/
function setPageTitle( $title, $override_all = false ) 
{

}



/**
 * Output of page title
 *
 * This function outputs the current page's title. It
 * is meant to be used in the template of Smallapp.
 *
 * <code>
 * 	<!-- index.tpl.php template file -->
 * 	<html>
 *	<head>
 *		<title><?php pageTitle(); ?></title>
 *	</head>
 *	<body>
 *		<!-- whatever elements here... -->
 *	</body>
 *	</html>
 * </code>
 *
 * @return void
 **/
function pageTitle() 
{
	$title = '';

	if ( strlen($GLOBALS['_func']) > 0 ) {

		$title = $GLOBALS['_site_title'] 		. ' ' .
				 $GLOBALS['_site_title_spacer'] . ' ' .
				 ucfirst($GLOBALS['_func']);

	} else {
		$title = $GLOBALS['_site_title'];
	}

	echo $title;
}



/**
 * Load widget function
 *
 * This function is used to load widgets
 * in the template. Use the widget name
 * only like:
 * <code>
 * 	<html>
 * 	<head>
 *		<title><?php pageTitle(); ?></title>
 *	</head>
 *
 * 	<body>
 * 		<div id="menu">
 * 			<?php loadWidget('menubar'); //loads menubar.widget.php ?>
 * 		</div>
 *
 *		<div id="mainbody">
 *			<?php body(); ?>
 *		</div>
 * 	</body>
 *	</html>
 * </code>
 *
 * @param string $name Name of the widget
 **/
function loadWidget($name) 
{
	$widget = $name . '.widget.php';

	if ( file_exists($GLOBALS['_widget_path'] . $widget) ) {
		include( $GLOBALS['_widget_path'] . $widget );
	} else {
		trigger_error( "Widget could not be found." );
	}
}//loadWidget



/**
 * Redirect to new page
 *
 * Use this function to redirect use to another
 * page. The redirect can be internal, or external.
 * All relative paths will be directed internally
 * while full URL paths will be considered externals.
 *
 * <code>
 * //for internal
 * redirect('index.php?func=trialform');
 *
 * //for external
 * redirect('http://example.com');
 * </code>
 *
 * @param string $url Either relative URL path or full URL path to redirect to
 * @return void
 **/
function redirect( $url ) 
{
	if ( preg_match( '/(ht|f)tps?/', $url, $matches ) ) {
		header("Location: " . $url);
	} else {
		header("Location: " . $GLOBALS['_site_url'] . $url);
	}
}



/**
 * URL handler
 *
 * Function that outputs URLs into SEF format if the
 * _mod_rewrite feature is enabled. This way, it can 
 * be handled automatically on the fly. However the 
 * developer will need to use this function on every
 * internal link throughout his/her/their component.
 * The formatted url with SEF ON will be:
 *	- http://fullsiteurl.com/index.php?func...
 *
 * The formatted url with SEF OFF will be:
 *	- http://fullsiteurl.com/func_name/var1/value1...
 *
 * Usage:
 * <code>
 * <!-- Someview.view.php -->
 * <a href="<?php echo url('index.php?func=content&page=usage'); ?>">
 *	Click Here
 * </a>
 * </code>
 *
 * <b>NOTE:</b> Please use RELATIVE path only. DO NOT use
 * full site url manually.
 *
 * @param string $URL Relative URL of an internal page
 * @return string Final URL format
 **/
function url( $url ) 
{
	$formatted_url = $GLOBALS['_site_url'];

	//Remove the index.php? part of the url first
	$cl_url = preg_replace( '/index.php\??/', '',  $url);

	if ( $GLOBALS['_sef_url'] ) {

		// Split the url strings up accordingly
		if( preg_match("/&amp;/", $cl_url, $matches) ) {
			$parameters = explode( '&amp;', $cl_url);
		} else {
			$parameters = explode( '&', $cl_url);
		}


		// Locate the func=content part. Doesn't need paired value
		// Once it has been located, grab the function value and 
		// remove it from the array
		$key = array_search( 'func', $parameters);

		if ( isset($parameters[$key]) ) {
			$function = str_replace('func=', '', $parameters[$key]);
			unset( $parameters[$key]);
		}


		// Lastly, concatenate them into a string 
		$formatted_url .= $function . '/';

		foreach( $parameters as $param ) {
			$formatted_url .= str_replace( '=', '/', $param) . '/';
		}

		$formatted_url = substr( $formatted_url, 0, -1);

	} else {
		$formatted_url .= $url;
	}

	return $formatted_url;
}//url
?>
