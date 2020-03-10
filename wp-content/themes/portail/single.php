<?php
/*
Template Name: single
*/

require 'config.php';
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$language = substr($context['site']->language, 0, 2);
$context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s"]', $domain, $language, $dbUrl);

$context['long_title'] = $language === 'fr' ?
        'Accès aux ressources documentaires des unités de recherche du CNRS'
    :
        'CNRS research units documents access';
$context['short_title'] = $language === 'fr' ?
        'Accès aux ressources documentaires du CNRS'
    :
        'CNRS documents access';
$category=get_the_category()[0];
if ($category->parent != 0) {
    $context['parentCat'] = get_category($category->parent);
}
Timber::render('single.twig', $context);

