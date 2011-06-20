<?php
/**
 * Home view for the content component
 *
 * This view is just a mini template for components
 * to display what is needed to display. Interlace
 * them with PHP codes, or whatever. But always avoid
 * heavy logics here, which should be done in the 
 * component itself.
 *
 * @author Wee Keat <weekeat@visualdensity.com>
 * $Id: home.view.php 76 2006-08-17 10:37:25Z weekeat $
 * @package ComContent
 **/
?>
<h1>Welcome to Smallapp!</h1>

You've just got Smallapp running. It should have been easy, isn't it? 
That's the whole idea of this little app. It's meant to serve as a 
basic framework for people like me who have to constantly write overly
simple stuff like a signup form, contact form and other 2-3 stepped forms.
<br /><br />

<h2>Birth of Smallapp</h2>
Having to write those forms are not difficult. It is just annoying. Annoying
because I have to always start from scratch. So, I've decided to keep a
generic framework that will allow me to only focus on the controller and
the view. Hence, the birth of Smallapp.
<br /><br />

<h2>Smallapp architecture</h2>
This framework is based loosely on the architecture of Mambo/Joomla - 
a content management system, whereby it provides an easy way of 
creating your own template (in just one file) and it supports unlimited
number of components and widgets to extend the capability &amp; features
of the app. 
<br /><br />
However, bear one important thing in mind - in order to keep
this app really small, it's all done using functions. Therefore, don't
expect it to have any OOP in it! Plus, there's no built-in goodies 
like user management, database connectivity, etc.
<br />

