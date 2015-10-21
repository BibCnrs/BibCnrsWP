<?php 
/**
 * The template for displaying 404 pages
 *

 */
?>

<?php get_template_part('header'); ?>          
	<div id="content"  class="bsbb">

	<?php if (function_exists('seomix_content_breadcrumb')) seomix_content_breadcrumb();?>
	<br class="clear">

		<div id="center2">
			<div id="pagenorm">
				<h1>Page non trouv&eacute;e</h1>
				<br/>
				<p><?php _e( 'Le site a chang&eacute;.', 'bsn' ); ?></p>
				<p>
					<?php _e( 'Rechercher dans', 'bsn' ); ?>					
					<a href="				
						<?php //selon la langue afficher le lien vers la page sitemap ou vers plan du site
						 $currentlang = get_bloginfo('language');
						 if($currentlang=="en-US"){
							echo get_permalink(( get_page_by_title( 'Site map' ) ));
						 }else{
							echo get_permalink(( get_page_by_title( 'Plan du site' ) ));
						 }
						?>
					">
					<?php _e( 'Plan du site', 'bsn' ); ?>
					</a>
				</p>
			</div> <!--finpagenorm -->				
<!-- siderbar-right -->
	<?php get_template_part('sidebar-right'); ?> 
<!-- fin sidebar-->

	<br class="clear" />
	</div><!-- fin center -->
	<img src="<?php bloginfo('template_url') ?>/images/separateur-footer.png" alt="separation pied" class="separateurlogo"/>				

	
	
	</div><!--/content-->
<?php get_template_part('footer'); ?>
