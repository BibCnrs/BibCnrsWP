<?php
/**
 * Template Name: Page Resultats
 *
 * Description: Defines default template of a page.
 *
 */
?>

<?php get_template_part('header'); ?>
<div id="content" class="bsbb">

	<?php if (function_exists('seomix_content_breadcrumb')) seomix_content_breadcrumb();?>
	<br class="clear">

	<div id="center">
		<!-- siderbar-left -->
		<?php get_template_part('sidebar-left'); ?>
		<!-- fin sidebar-left-->

		<div id="pagenorm">
		[ebsco_widget]
		<div class="clear"></div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
		<?php endwhile; ?>
		<?php else : endif; ?>
		</div>
		<!-- siderbar-right -->
		<?php get_template_part('sidebar-right'); ?>
		<!-- fin sidebar-right-->
	</div><!--/center-->
</div><!--/#content-->
<?php get_template_part('footer'); ?>
