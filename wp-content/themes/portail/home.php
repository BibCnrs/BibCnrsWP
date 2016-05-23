<?php
/*Template Name: Home*/
require 'config.php';
$context = Timber::get_context();
$slugs = $config['category']['news']; //category list by slug
$context['news'] = array();
$context['ebsco_widget'] = '[ebsco_widget domain="' . $config['profile_map'][$currentCategory->slug] . '"]';
foreach($slugs as $slug){
	$context['news'][] = [
		'title' => get_category_by_slug($slug)->name,
		'slug' => $slug,
		'posts' => Timber::get_posts(['category_name' => $slug, 'numberposts' => 3])
	];
}
Timber::render('homepage.twig', $context);
?>
