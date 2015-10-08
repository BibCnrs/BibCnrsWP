<?php get_template_part('header');  ?>         
<?php $category=get_the_category(); ?>
<?php $id=$category[0]->cat_ID; ?>
<?php $link= get_category_link($id); ?>
<div id="content" class="bsbb">
	<?php if (function_exists('seomix_content_breadcrumb')) seomix_content_breadcrumb();?>
	<br class="clear">

<div id="center">
	<div id="pagenorm">
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>	
			<div id="titrerubnorm2">
				<h1 class="font-<?php echo $category[0]->category_nicename; ?>"><?php echo the_title(); ?></h1>			
			</div>
			<div id="retour"><a href="<?php echo $link; ?>" class="font-<?php echo $category[0]->category_nicename; ?>">Voir toutes les actualit&eacute;s de <?php echo $category[0]->cat_name; ?></a></div>
			<?php the_content(); ?>
		<?php endwhile; ?>	
		<?php else : endif; ?>	
	</div>	<!-- fin pagenorm -->
	<!-- siderbar-right -->
	<?php if (!$_SESSION['domaine']) {get_template_part('sidebar-right-visite'); }
	else {get_template_part('sidebar-right'); }
	?>
	<!-- fin sidebar-->
</div><!--/center-->  
</div><!--/#content-->
<?php get_template_part('footer'); ?>    

<?php echo get_category_link($id); ?>