<?php
/*
Template Name: Archives chronologique
*/
?>
<?php

$previous_year = $year = 0;
$previous_month = $month = 0;
$ul_open = false;

$myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');


get_template_part('header'); ?>        

<div id="content" class="bsbb">

	<?php if (function_exists('seomix_content_breadcrumb')) seomix_content_breadcrumb();?>
	<br class="clear">

<div id="center">
	<div id="pagenorm">

<?php foreach($myposts as $post) : ?>	

	<?php

	setup_postdata($post);

	$year = mysql2date('Y', $post->post_date);
	$month = mysql2date('n', $post->post_date);
	$day = mysql2date('j', $post->post_date);

	?>

	<?php if($year != $previous_year || $month != $previous_month) : ?>

		<?php if($ul_open == true) : ?>
		</ul>
		<?php endif; ?>

		<h3><?php the_time('F Y'); ?></h3>

		<ul>

		<?php $ul_open = true; ?>

	<?php endif; ?>

	<?php $previous_year = $year; $previous_month = $month; ?>

	<li><span><?php the_time('j F'); ?> - </span> <span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span></li>

<?php endforeach; ?>
</ul>

	</div>	<!-- fin pagenorm -->
	<!-- siderbar-right -->
	<?php get_template_part('sidebar-right'); ?> 
	<!-- fin sidebar-->
</div><!--/center-->  
</div><!--/#content-->
<?php get_template_part('footer'); ?>    	
	