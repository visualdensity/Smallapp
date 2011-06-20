<?php
/**
 * Default template file
 *
 * This is the default template file for
 * Smallapp. This default template must NOT 
 * be removed because the core will use 
 * this template as a fallback.
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: index.tpl.php 115 2006-11-22 03:47:15Z weekeat $
 * @package TplDefault
 **/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php pageTitle(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" title="default" 
	href="<?php echo $GLOBALS['_site_url']; ?>templates/default/css/template_css.css" />

</head>
	<body>
		<div id="wrapper">
			<div id="menu">
				<?php loadWidget('menubar'); ?>
			</div>
			<div id="mainbody">
				<?php body(); ?>
			</div>
		</div>
	</body>
</html>
