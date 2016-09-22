<?php
/*Template Name: Home*/
require 'config.php';
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$language = substr($context['site']->language, 0, 2);
$domain = $config['profile_map'][$currentCategory->slug];
$context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s"]', $domain, $language);
$context['bibcnrs_header'] = sprintf('[bibcnrs_header language="%s"]', $language);
$slugs = $config['category']['news']; //category list by slug
$context['news'] = array();
foreach($slugs as $slug){
	$context['news'][] = [
		'title' => get_category_by_slug($slug)->name,
		'slug' => $slug,
		'posts' => Timber::get_posts(['category_name' => $slug, 'numberposts' => 3])
	];
}
$context['alerte']=Timber::get_posts(['category_name' => 'alertes', 'numberposts' => 1]);
Timber::render('homepage.twig', $context);
