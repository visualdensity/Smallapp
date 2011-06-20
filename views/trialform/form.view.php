<?php
/**
 * Trial default page
 * 
 * Default form page that is used
 * for the trial rerquest.
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: form.view.php 97 2006-08-21 10:24:06Z weekeat $
 * @package ComTrialform
 **/
?> 
<h1>Miro trial software request</h1>

<em>
	Items marked with <img src="images/required.gif" alt="Required (*)" /> are
	mandatory fields.
</em>

<br /><br />

<form action="<?php echo url('index.php?func=trialform&amp;action=processrequest'); ?>" method="post">
<table id='trial_form_table'>
	<tbody>
	
	<tr>
		<td>First name:</td>
		<td>
			<input class="<?php echo $GLOBALS['_tf_required']['firstname']; ?>" type="text"
				 name="firstname" size="30" value="<?php echo @$GLOBALS['_clp']['firstname']; ?>" />
		</td>
	</tr>

	<tr>
		<td>Last name:</td>
		<td>
			<input class="<?php echo $GLOBALS['_tf_required']['lastname']; ?>" type="text" 
				name="lastname" size="30" value="<?php echo @$GLOBALS['_clp']['lastname']; ?>" />
		</td>
	</tr>

	<tr>
		<td>Email:</td>
		<td>
			<input class="<?php echo $GLOBALS['_tf_required']['email']; ?>" type="text" 
				name="email" size="30" value="<?php echo @$GLOBALS['_clp']['email']; ?>" />
		</td>
	</tr>

	<tr>
		<td>Company:</td>
		<td>
			<input class="<?php echo $GLOBALS['_tf_required']['company']; ?>" type="text" 
				name="company" size="30" value="<?php echo @$GLOBALS['_clp']['company']; ?>" />
		</td>
	</tr>

	<tr>
		<td>Telephone: </td>
		<td>
			<input type="text" name="telephone" size="30" 
				value="<?php echo @$GLOBALS['_clp']['telephone']; ?>" />
		</td>
	</tr>	

	<tr>
		<td colspan="2"><br />How did you hear about Oi!?</td>
	</tr>

	<tr>
		<td colspan="2">
			<select name="referral">
				<?php echo $GLOBALS['_tf_referral_options']; ?>
			</select>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<br />
			Additional comments:
			<br />
			<textarea name="comments" rows="10" cols="38"><?php echo @$GLOBALS['_clp']['comments']; ?></textarea>	
		</td>
	</tr>

	</tbody>
</table>

<br />
<input type="submit" name="processrequest" value="Request for 30-day Oi! Trial" />
</form>
