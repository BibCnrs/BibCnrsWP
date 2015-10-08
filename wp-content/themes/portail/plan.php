<?php 
/*Template Name: Plan*/ 
?>
<?php get_template_part('header'); ?> 
<div id="content"  class="bsbb">
	<?php if (function_exists('seomix_content_breadcrumb')) seomix_content_breadcrumb();?>
	<br class="clear">
	<div id="center2">
		<div id="pagenorm" >
			<div id="titrerubnorm2">
				<h1 id="titrenorm"><?php the_title(); ?></h1>
			</div>
			<?php preg_replace('/ class="sub-menu"/','/ class="myclass" /', wp_nav_menu( array('depth' => 2, 'theme_location' => 'principal-fr', 'menu'=>'principal-fr' , 'menu_id'=>'plan2', 'menu_class'=>'menuplan') ) ); ?> 
			<ul class="menuplan">
				<?php $category_link = get_category_link( '2' ); ?>
				<li><a href="<?php echo esc_url( $category_link ); ?> ">Voir toutes les actualit&eacutes</a></li>
				<?php $category_link = get_category_link( '11' ); ?>
				<li><a href="<?php echo esc_url( $category_link ); ?> ">Voir la veille en IST</a></li>
			</ul>			
		</div><!--/pagenorm-->				
		<!-- siderbar-right -->
		<?php get_template_part('sidebar-right'); ?> 
	<!-- fin sidebar-->
	<br class="clear" />
	</div><!-- fin center -->
	<img src="<?php bloginfo('template_url') ?>/images/separateur-footer.png" alt="separation pied" class="separateurlogo"/>				
</div><!--/content-->
<?php get_template_part('footer'); ?>