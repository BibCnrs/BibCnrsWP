<?php
/*
Template Name: Archives chronologique
*/
?>
<?php
$previous_year = $year = 0;
$previous_month = $month = 0;
$ul_open = false;
$category=get_the_category();
$cat_id= $category[0]->cat_ID;
$args =array(
	'category' => $cat_id,
	'numberposts' => -1,
	'orderby' => 'post_date',
	'order' => 'DESC'
	);
$myposts = get_posts($args);


get_template_part('header'); ?>

<div id="content" class="bsbb">

	<?php if (function_exists('seomix_content_breadcrumb')) seomix_content_breadcrumb();?>
	<br class="clear">

<div id="center">

	<div id="pagenorm">
	<?php
	if ($category[0]->category_nicename != 'infosist' &&
		$category[0]->category_nicename != 'formations' &&
		$category[0]->category_nicename != 'une') {
			echo do_shortcode('[ebsco_widget]');
		}
	?>

	</div>	<!-- fin pagenorm -->
	<!-- siderbar-right -->
	<?php if (!$_SESSION['domaine']) {get_template_part('sidebar-right-visite'); }
	else {get_template_part('sidebar-right'); }
	?>
	<!-- fin sidebar-->
</div><!--/center-->
</div><!--/#content-->
<?php get_template_part('footer'); ?>
