<?php
/**
 * Trialform configuration file
 *
 * Just a bunch of configuration stuff
 * kept in one place for easy access
 * and maintainability.
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: trialform.config.php 76 2006-08-17 10:37:25Z weekeat $
 * @package ComTrialform
 * @todo Change all variable names to use namespaces like _tf prefix for all trialforms variables
 **/

// Check that users don't come here directly
defined( '_VALID_ENTRY_' ) or die( 'Are you trying to be a smart ass?' );


// Mailing stuff
$GLOBALS['_mail_from']			= 'sales@miro.com.au';
$GLOBALS['_mail_from_name']		= 'Miro Sales Team';
$GLOBALS['_user_mail_subject']	= 'Software trial request: Thank you';
$GLOBALS['_admin_mail_subject'] = 'Oi! trial request';
$GLOBALS['_admin_mails']		= array( 'My name' => 'me@example.com' ); 


// Mail body for admin
$GLOBALS['_admin_mail_body']	= 	"Hi, \n\n" .
									"A potential client has just requested a trial copy of Oi!. " .
									"Please look into this matter. User details are as follows: ";

$GLOBALS['_user_mail_body']		= 	"Hi {firstname},\n\n" .
									"Thank you for requesting our Oi! 30-day Trial. A customer service " .
									"representative will contact you within 2 business days with details " .
									"concerning your trial request.";

$GLOBALS['_user_mail_sig']		= 	"\n\n\n" .
									"Thank you." .
									"\n\n\n\n" .
									"Regards,\n" .
									"Miro Sales Team\n";


// Form configuration
$GLOBALS['_referral_list']		= array(
									'Search engine',
									'Friend',
									'Direct referral',
									'Banner ad',
									'Other website',
									'Event',
									'News article'
									);

$GLOBALS['_tf_required']		= array( 
									'firstname' => 'required',
									'lastname'  => 'required',
									'email'		=> 'required',
									'company'	=> 'required'
									);

?>
