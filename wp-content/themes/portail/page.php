<?php
/**
 * Title: Page template.
 *
 * Description: Defines default template of a page.
 *
 */
?>
<?php get_template_part('header'); ?>

	<div id="content"  class="bsbb">

	<?php if (function_exists('seomix_content_breadcrumb')) seomix_content_breadcrumb();?>
	<br class="clear">

		<div id="center">

		<?php /*boucle standard*/ ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div id="pagenorm">
				<h1 class="soustitre"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
		<?php else : endif; ?>

<!-- siderbar-right -->
	<?php get_template_part('sidebar-right'); ?>
<!-- fin sidebar-->




	<br class="clear" />
	</div><!-- fin center -->
	</div><!--/content-->
<?php get_template_part('footer'); ?>
