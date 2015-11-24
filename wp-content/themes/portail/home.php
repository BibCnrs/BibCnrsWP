<?php
/*Template Name: Home*/
$context = Timber::get_context();
$slugs = array('une', 'formations', 'infosist'); //category list by slug (max3)
$context['news'] = array();
foreach($slugs as $slug){
	$context['news'][] = [
			'title' => get_category_by_slug($slug)->name,
			'slug' => $slug,
			'posts' => Timber::get_posts(['category_name' => $slug, 'numberposts' => 5])
	];
}
Timber::render('homepage.twig', $context);

?>
