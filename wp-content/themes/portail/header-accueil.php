<?php session_start(); ?>
<!doctype html>
<html dir="ltr" lang="fr">

<!-- begin head -->
<head>

<title><?php wp_title(' | ', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<!-- begin meta -->
<meta charset="utf-8"/>
<meta name="description" content="site des portails CNRS">
<meta name="apple-mobile-web-app-capable" content="yes" />
<!-- end meta -->

<!-- Mobile Specific Metas
   ================================================== -->
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


<link rel="stylesheet" media="all" href="<?php bloginfo('template_url'); ?>/style.css" type="text/css">
<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=10" />
<![endif]-->

<!--[if IE 9]>
	<script src="<?php bloginfo('template_url'); ?>/js/html5-ie.js" type="text/javascript"></script>
<![endif]-->

<!-- google font -->
<script src="<?php bloginfo('template_url'); ?>/js/skip.js" type="text/javascript"></script>


<!-- wp_head -->
<?php wp_head(); ?>
<!-- wp_head -->

</head>
<!-- end head -->

<body <?php body_class($mybodyclass); ?>>

<!-- begin container -->
<div class="container" >
	<!-- begin header -->
	<header id="header" class="bsbb">

	<!--	<div class="slogan block">
			<h2><?php bloginfo('description');?></h2>
		</div>
	-->
		<div class="clear"></div>
		<!-- acces hierarchique -->
		<div id="hierarchie">
			<ul id="cnrs">
				<li class ="cnrsli"><a href="http://www.cnrs.fr" target="_blank">CNRS</a></li>
				<li class=cnrsli">&nbsp;|&nbsp;</li>
				<li class ="cnrsli"><a href="http://www.cnrs.fr/dist/" target="_blank">DIST</a></li>
			</ul>
		</div>
	</header>
	<!-- end header -->
