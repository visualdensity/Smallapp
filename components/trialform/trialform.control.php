<?php
/**
 * Form processor
 *
 * This script processes the trial form data
 * sends an email to user and admin upon 
 * successful validation
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: trialform.control.php 114 2006-10-13 01:58:39Z weekeat $
 * @package ComTrialform
 * @todo Remove third party dependcy here - just an example will do
 **/

/**
 * Global constant that is used to ensure that current file
 * is included or called via the main index page. This will
 * prevent others from accessing this file directly.
 **/
defined( '_VALID_ENTRY_' ) or die( 'Are you trying to be a smart ass?' );

loadConfig('trialform');
compileVariables();

$action = strtolower( @$GLOBALS['_clp']['action'] );

switch( $action ) {

	case 'processrequest' :
		processRequest();
		break;

	default :
		setView( 'form' );
		break;	

}//switch


/**
 * Process request
 * 
 * This function contains the logic for
 * processing the form data and calls
 * the sendMail() function if successful.
 * Else, it will spit an error
 *
 * @return void
 **/
function processRequest() 
{
	$GLOBALS['_tf_formerrors'] = null;

	if ( !@$_POST['processrequest'] ) {
		setView( 'form' );
		exit;
	}

	// Are there any missing required fields?
	$GLOBALS['_tf_formerrors'] = validate($GLOBALS['_clp']);
	
	compileErrors();

	//Check if there's value in errors if there is, let user know
	if ( count($GLOBALS['_tf_formerrors']) > 0 ) {
		setView( 'form' );
		exit;
	}

	// No errors? Send email to user & admin, then done. 
	$senderrors = sendMails();
	setView( 'thanks' );

}//processRequest



/**
 * Validate function
 *
 * Fixed validation function for this form
 * only. It's not to be used generally. The
 * reason it's here is due to refactoring 
 * of code for readability & maintainability
 *
 * @param array $clp Cleaned or sanitised $_REQUEST var
 * @return array
 **/
function validate($clp) 
{
	$errors = null;

	if( !validString( trim($clp['firstname']) ) ) {
		$errors['firstname'] = true;
	}

	if( !validString( trim($clp['lastname']) ) ) {
		$errors['lastname'] = true;
	}
	
	if( !validEmail( trim($clp['email']) ) ) {
		$errors['email'] = true;
	}

	if( !validString( trim($clp['company']) ) ) {
		$errors['company'] = true;
	}

	return $errors;
}//validate


/**
 * Prepare variables for view
 * 
 * This function is where all the variables needed by
 * the trialform view.
 *
 * @return void
 **/
function compileVariables() 
{
	$GLOBALS['_tf_referral_options'] = null;

	// Setup the initial values
	foreach( $GLOBALS['_referral_list'] as $item ) {
		if( @$GLOBALS['_clp']['referral'] == $item ) {
			$GLOBALS['_tf_referral_options'] .= '<option value="'.$item.'" selected>'.$item.'</option>';
		} else {
			$GLOBALS['_tf_referral_options'] .= '<option value="'.$item.'">'.$item.'</option>';
		}
	}
}//prepVariables



/** 
 * Compile errors
 *
 * Compiles the errors for user feedback. Shows
 * various errors that is needed by the form to
 * alert the user.
 *
 * @return void
 **/
function compileErrors() 
{
	// Preapare the form bit
	if ( @$GLOBALS['_tf_formerrors'] ) {
		foreach( $GLOBALS['_tf_required'] as $name => $value ) {
			$GLOBALS['_tf_required'][$name] = 'passed';
		}

		foreach( $GLOBALS['_tf_formerrors'] as $name => $value ) {
			$GLOBALS['_tf_required'][$name] = 'error';
		}
	}

}//compileErrors



/**
 * Send the emails to admin and users
 * 
 * This function uses PHPMailer to send emails out
 * to the user requesting the trial and to the staff
 * listed in the $GLOBALS['_admin_mails'] array.
 *
 * @return array Array of errors ['user'] and ['admin'] true if error occurs
 **/
function sendMails() 
{
	$errors = array();
	$headers = '';

	//Send the user a response
	$user_name		= $GLOBALS['_clp']['firstname'] . ' ' . $GLOBALS['_clp']['lastname'];
	$user_body		= processMailBody( $GLOBALS['_user_mail_body'] );

	$headers .= 'From: '. $GLOBALS['_mail_from_name'] . ' <'. $GLOBALS['_mail_from'] . '>' 	. "\r\n" ;
	$headers .= 'X-Mailer: Smallapp 0.1'													. "\r\n";

	mail( $GLOBALS['_clp']['email'], $GLOBALS['_user_mail_subject'], $user_body, $headers );

	return $errors;

}//sendMails



/**
 * Capture data function
 *
 * This function captures data that is 
 * passed from the form and returns it
 * in a formatted string
 **/
function captureData() 
{
	$data_str	= '';
	$now = today();

	$data_str  .= "User details\n===\n\n";
	$data_str  .= "Date: \t\t"		. $now							. "\n";
	$data_str  .= "First name: \t" 	. $GLOBALS['_clp']['firstname']	. "\n";
	$data_str  .= "Last name: \t"	. $GLOBALS['_clp']['lastname'] 	. "\n";
	$data_str  .= "Email: \t\t"		. $GLOBALS['_clp']['email'] 	. "\n";
	$data_str  .= "Company: \t"		. $GLOBALS['_clp']['company'] 	. "\n";
	$data_str  .= "Telephone: \t"	. $GLOBALS['_clp']['telephone'] . "\n";
	$data_str  .= "Referral: \t"	. $GLOBALS['_clp']['referral'] 	. "\n\n";
	$data_str  .= "Comments: \n"	. $GLOBALS['_clp']['comments'] 	. "\n";

	return $data_str;

}//captureData



/** 
 * Process user's mail body
 *
 * Does the string replace of tags before
 * getting returned. Nothing much
 *
 * @param string $body
 * @return string
 **/
function processMailBody($body) 
{
	$new_body = null;
	$captured = captureData();

	$new_body = str_replace( '{firstname}', $GLOBALS['_clp']['firstname'], $body);
	$new_body = str_replace( '{lastname}', $GLOBALS['_clp']['lastname'], $new_body );
	$new_body = $new_body . "\n\n\n" . $captured . $GLOBALS['_user_mail_sig'];
	
	return $new_body;
}//processMailBody

?> 
