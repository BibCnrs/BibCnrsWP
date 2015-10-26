<?php
/*Template Name: Home*/
?>
<?php get_template_part('header-accueil'); ?>
<div id="contentaccueil" class="bsbb">
	<img src="<?php bloginfo('template_url'); ?>/images/sommaire.jpg" alt="bsn reseau" class="bsbb"/>
	<img src="<?php bloginfo('template_url'); ?>/images/logocnrs2.png" alt="bsn reseau" class="bsbb logoaccueil"/>
	<div id="recherchegenerale">
		<form action="<?php bloginfo('url')?>/search/" id="recherchebase" method="get">
			<label for "searchterm"><input type="text" id="searchterm" name="term" placeholder="d&eacute;passer les fronti&egrave;res">
			<input type="submit" value="Chercher"/>
		</form>
	</div>
	<nav role="navigation" id="principal">
		<?php wp_nav_menu( array('depth' => 1,  'menu'=>'principal', 'container_class' => 'principalbas' , 'walker'=> new Custom_Walker_Nav_Menu())); ?>
	</nav>
</div><!--/contentaccueil-->

<?php get_template_part('footer'); ?>
