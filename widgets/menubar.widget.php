<?php
/**
 * Menubar widget 
 *
 * A simple widget to demonstrate how it
 * can be used. It's a snippet of code in
 * PHP, HTML, or whatever which can function
 * independently but does not need the bulk
 * of components.
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: menubar.widget.php 95 2006-08-21 07:07:26Z weekeat $
 * @package WdgtMenubar
 **/
?>
<ul id="menubar">
	<li>
		<a href="<?php echo url('index.php'); ?>">home</a>
	</li>
	<li>
		<a href="<?php echo url('index.php?func=content&amp;page=usage'); ?>">usage</a>
	</li>
	<li>
		<a href="<?php echo url('index.php?func=content&amp;page=credits'); ?>">credits</a>
	</li>
	<li>
		<a href="<?php echo url('index.php?func=trialform'); ?>">sample</a>
	</li>
</ul>
