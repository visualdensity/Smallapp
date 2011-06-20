<?php
/**
 * Common functions collection
 *
 * Selection of functions that can be used for various
 * common tasks. 
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: tools.functions.php 125 2007-03-21 00:16:31Z weekeat $
 * @package Smallapp
 * @todo Add various validation functions for easy use
 **/

/**
 * Global constant that is used to ensure that current file
 * is included or called via the main index page. This will
 * prevent others from accessing this file directly.
 **/
defined( '_VALID_ENTRY_' ) or die( 'Are you trying to be a smart ass?' );


/**
 * Stripslashes recursive
 * 
 * Recursively stripslashes to data. But this
 * only happens if magic_quotes is on.
 *
 * @param array $arr
 * @return unknown
 */
function stripslashes_recur($arr) {
    $auto_quote = null;
    
    if( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) {
        foreach($arr as $key => $value) {
            if( is_array( $value ) ) {
                $c_arr[$key] = stripslashes_recur($value);
            } else {
                
                $value = stripslashes($value);
                $c_arr[$key] = $value;
            }
        }
    } else {
        $c_arr = $arr;
    }
        
    return $c_arr;
}

/**
 * Today's date
 *
 * Just a simple little function to get 
 * a standard formatted date string. Date
 * format can be overidden if you want to.
 * This date string returns the date WITH
 * the time offset set in the config.php
 *
 * <code>
 *	<?php
 *		$now = today();
 *		print $now;
 *		//Output: 26-08-2006 15:05:23
 *	
 *		$format_string = 'D JS F, Y'; //override default format
 *
 *		$now = $today($format_string);
 *		print $now;
 *		//Output: Sat 26th August, 2006
 *	?>
 * </code>
 *
 * @param string $date_format Date format as documented in PHP manual
 * @return string Date formatted to dd:mm:yyyy hh:mm:ss by default
 **/
function today( $date_format = 'd-m-Y H:i:s') 
{
	$offset = $GLOBALS['_time_offset'] * 60 * 60;
	return date( $date_format, time() + $offset );
}//today



/**
 * Is valid email
 *
 * This function checks if it is a valid email format.
 * It's not the most comprehensive email format validator but
 * it should do well under normal circumstances.
 *
 * This function provides an optional NULL value modifier, which
 * treats an empty string as valid. This is useful if you
 * make your email field optional.
 *
 * <code>
 *	<?php
 *	// Following is when email is mandatory and valid
 *	if( validEmail('me@example.com' ) {
 *		mail('admin@example.com', 'Subject here', $message );
 *	}
 *
 *	// Following is when email is NOT mandatory but if provided, must be valid
 *	if( validEmail( '', true ) {
 *		mail('admin@example', 'Subject here', $messsage );
 *	}
 *	?>
 * </code>
 *
 * @param string $email Email address
 * @param boolean $null_value Allow empty values
 * @return boolean
 **/
function validEmail( $email, $null_value = false ) 
{
	$regex 		= "/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i";
	return isValid( $regex, $email, $null_value );
}//validEmail



/**
 * Is valid string
 *
 * This function verifies that input is a valid
 * string. This includes spaces, alpha numerics,
 * etc. It does not, however recognises newlines. So,
 * if there are new lines, it will be considered invalid.
 *
 * <code>
 *	<?php
 *	// Following is when string is mandatory and valid
 *	if( validString('This is a typical 1123 string.' ) {
 *		setView('thankyou');
 *	}
 *
 *	// Following is when string is NOT mandatory but if provided, must be valid
 *	if( validString( '', true ) {	//This will will return true
 *		setView('thank you');
 *	}
 *	?>
 * </code>
 *
 * @param string $string String input
 * @param boolean $null_value To allow empty values
 * @return boolean
 **/
function validString( $string, $null_value = false )
{
	$is_valid 	= false;
	$regex		= "/^[^\x-\x1F]+$/";

	return isValid( $regex, $string, $null_value );
}//validString



/**
 * Is alpha numeric only
 *
 * This is different from string, where it is more lenient with
 * what character sets are allowed. But this function is very strict
 * on allowing on alpha or numeric characters only. 
 *
 * <b>Note: </b>You have ADDITIONAL option of allowing spaces for
 * this function via the $allow_spaces option by setting it to
 * <b>true</b>
 * 
 * <code>
 *	<?php
 *	// Following will return success: 
 *	//  - $alphanum = 'string123'
 *	//
 *	// Following will fail:
 *	//  - $alphanum = '';
 *	//  - $alphanum = 'string 1 23'
 *	if( validAlphaNum('typical123alhanum123' ) ) {
 *		setView('thankyou');
 *	}
 *
 *	// Following will return success: 
 *	//  - $alphanum = 'string123'
 *	//  - $alphanum = 'string 1 23'
 *	//
 *	// Following will fail:
 *	//  - $alphanum = '';
 *	if( validAlphaNum( $alphanum, true ) ) {	
 *		setView('thank you');
 *	}
 *
 *	// Following will return success: 
 *	//  - $alphanum = 'string123'
 *	//  - $alphanum = 'string 1 23'
 *	//  - $alphanum = '';
 *	if( validAlphaNum( $alphanum, true, true ) ) {
 *		setView('thankyou');
 *	}
 *	?>
 * </code>
 *
 * @param string $alphanum Values to be validated
 * @param boolean $allow_spaces Set this to true if you want to allow spaces
 * @param boolean $null_value Set this to true to allow empty values
 * @return boolean
 **/
function validAlphaNum( $alphanum, $allow_spaces = true, $null_value = false )
{
	if ( $allow_spaces ) {
		$regex = "/^[a-z0-9 ]+$/i";
	} else {
		$regex = "/^[a-z0-9]+$/i";
	}

	return isValid( $regex, $alphanum, $null_value );
}//validFilename



/**
 * Valid filename
 *
 * Use this function to determine if a filename is valid.
 * 
 * @param string $filename Values to be validated
 * @param boolean $null_value Set this to true to allow empty values
 * @return boolean
 **/
function validFilename( $filename, $null_value = false ) 
{
	$regex = "{^[^\\/\*\?\:\,]+$}";
	return isValid( $regex,  $filename, $null_value );
}//validFilename



/**
 * Is valid text
 *
 * This function is used to validate texts such as those that are obtained
 * from <textarea>. The main difference between the validText() and the 
 * validString() function is that the validText() function accepts newline
 * characters, while the validString function does not.
 *
 * @param string $text Text data to be validated against.
 * @param boolean $null_value Set this to true to allow empty values
 **/
function validText( $text, $null_value = false )
{
	$is_valid	= false;
	$regex		= "/^([^\x-\x1F]|[\r\n])+$/";

	return isValid( $regex, $text, $null_value );
}//validText



/**
 * Is valid number
 *
 * Well the name says it all. This function validates numbers. <b>Note:</b>
 * this function has an ADDITIONAL option to allow spaces within the 
 * numbers. 
 *
 * <code>
 *	<?php
 *	// Following is when numbers is mandatory and valid
 *	if( validNumber('812971' ) ) {
 *		setView('thankyou');
 *	}
 *
 *	// Following will allow spaces AND mandatory
 *	// '1234', '1 23 4' will pass. No value will fail.
 *	if( validNumber( $number, true ) ) {	
 *		setView('thank you');
 *	}
 *
 *	// Following will allow empty values AND allow spaces
 *	// So, '1234', '12 3 4' and '' will all be valid
 *	if( validNumber( $number, true, true ) ) {
 *		setView('thankyou');
 *	}
 *	?>
 * </code>
 *
 * @param string $number Values that needs to be validated
 * @param boolean $allow_spaces Allow spaces in numbers?
 * @param boolean $null_value Set this to true to allow empty values
 * @return boolean
 **/
function validNumber( $number, $allow_spaces = false,  $null_value = false )
{
	$is_valid	= false;
	
	if( $allow_spaces ) {
		$regex	= "/^[0-9 ]+$/";	
	} else {
		$regex	= "/^[0-9]+$/";
	}

	return isValid( $regex, $number, $null_value );
}



/**
 * Is valid URL
 *
 * This function takes in a URL value and ensures that it is
 * in the valid format. The regular expression used here is not
 * perfect, but should work for most common domain names.
 *
 * Let me know if you have a better regex to handle this. And no...
 * not the one that is 100% RFC compliant!!! Too long!
 *
 * @param string $url URL value to be validated
 * @param boolean $null_value Set this to true to allow empty values
 * @return boolean
 **/
function validUrl( $url, $null_value = true )
{
	$regex = "/(?:(?:dav|(?:ht|f)tps?)://)?([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?/";
	return isValid( $regex, $url, $null_value );
}



/**
 * Is valid
 *
 * This is an internal function that is used for comparing
 * a regex with the value provided.
 *
 * @access private
 * @param string $regex Regular expression
 * @param string $value Value that needed to be evaluated against
 * @param boolean $null_value To allow empty values
 * @return boolean
 **/
function isValid( $regex, $value, $null_value )
{

	$is_valid = false;

	if( $null_value ) {
		if(	preg_match($regex, $value, $trash) || strlen( $value) == 0 ) {
			$is_valid = true;
		}
	} else {
		if(	preg_match($regex, $value, $trash) ) {
			$is_valid = true;
		}
	}

	return $is_valid;
}//isValid


/**
 * Extended print_r function
 * 
 * This function outputs the array structure using print_r
 * function, but it also wraps it around <pre> tags so that
 * we don't need to write the same thing evertime.
 *
 * This function is copied from CakePHP (www.cakephp.org).
 *
 * <code>
 *  <?php
 *      pr( $_POST );
 *
 *      // Is equivalent to:
 *      // print '<pre>';
 *      // print_r( $_POST );
 *      // print '</pre>';
 *  ?>
 * </code>
 * 
 * @param mixed $arr Any type of array.
 * @return void
 **/
function pr( $arr )
{
    print '<pre>'; 
    print_r($arr);
    print '</pre>';
}//pr
?>
