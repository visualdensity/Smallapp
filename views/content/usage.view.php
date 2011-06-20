<?php
/**
 * Usage view for the content component
 *
 * This view is just a mini template for components
 * to display what is needed to display. Interlace
 * them with PHP codes, or whatever. But always avoid
 * heavy logics here, which should be done in the 
 * component itself.
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: usage.view.php 124 2007-03-21 00:13:45Z weekeat $
 * @package ComContent
 **/
?>

<h1>Using Smallapp</h1>
Smallapp is  meant to serve as a basic framework for people like 
me who have to constantly write overly simple stuff like 
a signup form, contact form and other 2-3 stepped forms.
<br />

<h3>System Requirements</h3>
<p>Smallapp has a very small requirement. It should run 
fairly well on any webserver that is able to serve
PHP scripting. It basically should work with the following:
    <ul>
	    <li>PHP 4+/5</li>
	    <li>Apache (tested) IIS/Lighttpd (not tested)</li>
    </ul>
</p>
<br />

<h3>Installation</h3>
<p>Installation of Smallapp is just as easy. Just rename
config.php-example to config.php and it should run just
fine.</p>

<p>Although Smallapp is designed to run config-free, you
do have the option of specifying absolute paths as well
as URLs for convenience.</p>

<p>Installation instructions:

    <ol>
        <li>
            Download Smallapp from 
            <a href="http://smallapp.weekeat.com">http://smallapp.weekeat.com</a>
        </li>

        <li>Untar the files into your web root using the following:<br />
            <pre>tar -xzvf smallapp_x.x.tgz</pre>
        </li>

        <li>
            Copy or rename the <em>config.php-example</em> file to 
            <em>config.php</em> by doing the following:
            <br />	
            <pre>cp config.php-example config.php</pre>
        </li>

        <li>Call your web and it should be up and running!</li>
    </ol>
</p>
<br />

<h3>Support</h3>
If you need support, email Wee Keat at weekeat [at] visualdensity.com.
<br />
Thank you for using Smallapp.
