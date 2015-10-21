<?php
session_start();
if ($_POST["username"]){
	$_SESSION["domaine"]=$_POST["username"];
}
if ($_SESSION['domaine']){
	$domaine=$_SESSION['domaine'];
	if (is_single()OR is_category()) {
		$categ=get_the_category();
		$categ_nicename=$categ[0]->category_nicename;
		if ($categ_nicename != $_SESSION['domaine']){
			$visite="OK";
		}
	}
	query_posts("cat=-1,");
	while ( have_posts() ) {
		the_post();
		$category = get_the_category();
		$cat_nicename=$category[0]->category_nicename;
		if ($cat_nicename === $_SESSION['domaine']){
			$institut= $category[0]->category_description;
			$catname=$category[0]->name;
		}
	}
	wp_reset_query();
}
elseif (is_single()OR is_category()) {
// ne fonctionne que si chaque categorie a un post
	$visite="non";
	$category = get_the_category();
	$domaine=$category[0]->category_nicename;
	$institut= $category[0]->category_description;
	$catname=$category[0]->name;
}
else {
	$domaine="visite";
	$visite="non";
	}
?>
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
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/ie-9.css"/>
<![endif]-->

<!-- google font -->
<script src="<?php bloginfo('template_url'); ?>/js/skip.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>


<!-- wp_head -->
<?php wp_head(); ?>
<!-- wp_head -->

</head>
<!-- end head -->

<body class="<?php echo $domaine ?>"
<!-- begin container -->
<div class="container" >
	<!-- begin header -->
	<header id="header" class="bsbb">
	<div class="clear"></div>
	<!-- accessibilite
	<div id="access">
               <ul id="accessibility">
                    <li class="accessli"><a href="#haut"><?php _e( 'Aller au menu', 'portail')?> </a></li>
                    <li class="accessli"><a href="#content"><?php _e( 'Aller au contenu', 'portail')?> </a></li>
                    <?php if(function_exists('wptextsizerincutil')) { wptextsizerincutil(); } ?>
                </ul>
	</div> -->

	<!-- acces hierarchique -->
	<div id="hierarchie">
		<ul id="cnrs">
			<li class ="cnrsli"><a href="http://www.cnrs.fr" target="_blank">CNRS</a></li>
			<li class=cnrsli">&nbsp;|&nbsp;</li>
			<li class ="cnrsli"><a href="http://www.cnrs.fr/dist/" target="_blank">DIST</a></li>
			<li class=cnrsli">&nbsp;|&nbsp;</li>
			<li class ="cnrsli"><a href="http://www.cnrs.fr/
			<?php echo $insitut; ?>
			" target="_blank">
			<?php echo strtoupper($institut);?>
			</a></li
		</ul>
	</div>
	<div class="logo">
		<a href="<?php bloginfo('url'); ?>" title="accueil">
			<img src="<?php bloginfo('template_url'); ?>/images/logocnrs.png" alt="CNRS d�passer les fronti�res" class="bsbb">
		</a>
		<h1 class="font-<?php echo $domaine; ?>">
			<?php
			if ($_SESSION['domaine']){
			?>
				Domaine <?php echo $catname; ?>
			<?php }
			else {
			?>
				Visite du domaine <?php echo $catname; ?>
			<?php
			}
			?>
		</h1>
		<?php if ($_SESSION['domaine']) {
			if ($visite==="OK") { ?>
		<div id="soustitre">
				<?php echo "(en visite dans ";
				$category = get_the_category();
				echo $category[0]->cat_name;
				echo ")"; ?>
		</div>

			<div id="bouton" class="<?php echo $domaine; ?>">
				<a href="/category/<?php echo $domaine; ?>">Retour &agrave;<br/> mon domaine</a>
			</div>
		<?php } } ?>
	</div>
	<div id="separateur"></div>

	</header>
	<!-- end header -->
