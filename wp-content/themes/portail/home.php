<?php
/*Template Name: Home*/
?>
<?php get_template_part('header-accueil'); ?>
<div id="contentaccueil" class="bsbb">
	<div id="entete">
		<img src="<?php bloginfo('template_url'); ?>/images/sommaire2.jpg" alt="bsn reseau" class="bsbb"/>
		<img src="<?php bloginfo('template_url'); ?>/images/logocnrs2.png" alt="bsn reseau" class="bsbb logoaccueil"/>
		<div id="recherchegenerale">
			<form action="<?php bloginfo('url')?>/connexion/" id="recherchebase" method="post">
				<label for "searchterm"><input type="text" id="searchterm" name="recherche" placeholder="d&eacute;passer les fronti&egrave;res">
					<input type="submit" value="Chercher"/>
				</form>
			</div>
			<nav role="navigation" id="principal">
				<?php wp_nav_menu( array('depth' => 1,  'menu'=>'principal-fr', 'container_class' => 'principalbas' , 'walker'=> new Custom_Walker_Nav_Menu())); ?>
			</nav>
		</div>
	</div>
		<div id="center3">
			<div class="boite">
				<?php
				$category_name='a la une';
				$category_id = get_cat_ID( $category_name );
				$category_link = get_category_link($category_id);
				query_posts(array(cat => $category_id, posts_per_page => 5)); ?>
				<?php if (have_posts()) { ?>
				<div id="titrerubactus">
					<h2 id="titreactus"><?php single_cat_title( '', true ); ?></h2>
				</div>
				<?php while ( have_posts() ) {the_post(); ?>
				<div class="itemactus">
					<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					<div class="resume"><?php echo the_excerpt(); ?></div>
					<hr class ="separ"/>
				</div>
				<?php } ?>
				<br class="clear"/>
				<div id="archivesactus"><a href="<?php echo esc_url( $category_link ); ?> ">Voir tout</a></div>
				<?php } ?>
				<?php wp_reset_query();?>
			</div>
			<div class="boite">
				<?php
				$category_name='formations';
				$category_id = get_cat_ID( $category_name );
				$category_link = get_category_link($category_id);
				query_posts(array(cat => $category_id, posts_per_page => 5)); ?>
				<?php if (have_posts()) { ?>
				<div id="titrerubactus">
					<h2 id="titreactus"><?php single_cat_title( '', true ); ?></h2>
				</div>
				<?php while ( have_posts() ) {the_post(); ?>
				<div class="itemactus">
					<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					<div class="resume"><?php echo the_excerpt(); ?></div>
					<hr class ="separ"/>
				</div>
				<?php } ?>
				<br class="clear"/>
				<div id="archivesactus"><a href="<?php echo esc_url( $category_link ); ?> ">Voir tout</a></div>
				<?php } ?>
				<?php wp_reset_query();?>
			</div>
			<div class="boite">
				<?php
				$category_name='informations';
				$category_id = get_cat_ID( $category_name );
				$category_link = get_category_link($category_id);
				query_posts(array(cat => $category_id, posts_per_page => 5)); ?>
				<?php if (have_posts()) { ?>
				<div id="titrerubactus">
					<h2 id="titreactus"><?php single_cat_title( '', true ); ?></h2>
				</div>
				<?php while ( have_posts() ) {the_post(); ?>
				<div class="itemactus">
					<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					<div class="resume"><?php echo the_excerpt(); ?></div>
					<hr class ="separ"/>
				</div>
				<?php } ?>
				<br class="clear"/>
				<div id="archivesactus"><a href="<?php echo esc_url( $category_link ); ?> ">Voir tout</a></div>
				<?php } ?>
				<?php wp_reset_query();?>
			</div>
		</div><!-- fin center -->
	</div><!--/content-->
	<?php get_template_part('footer'); ?>
