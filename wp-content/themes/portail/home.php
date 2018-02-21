<?php
/*Template Name: Home*/
require 'config.php';
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$language = substr($context['site']->language, 0, 2);
$context['long_title'] = $language === 'fr' ?
        'Accès aux ressources documentaires des unités de recherche du CNRS'
    :
        'CNRS research units documents access';
$context['short_title'] = $language === 'fr' ?
        'Accès aux ressources documentaires du CNRS'
    :
        'CNRS documents access';
$domain = $config['profile_map'][$currentCategory->description];
$dbUrl = $language === 'fr' ? '\/bases-de-donnees\/' : '\/data-bases\/';
$context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s" db_url="%s"]', $domain, $language, $dbUrl);
$slugs = $config['category']['news'];
$context['news'] = array();
foreach($slugs as $slug){
	$context['news'][] = [
		'title' => get_category_by_slug($slug)->name,
		'slug' => $slug,
		'posts' => Timber::get_posts(['category_name' => $slug, 'numberposts' => 3])
	];
}
$alert = $language === 'fr' ? 'alertes' : 'warning';
$context['alerte']=Timber::get_posts(['category_name' => $alert, 'numberposts' => 1]);
Timber::render('homepage.twig', $context);
