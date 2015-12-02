<?php
/*
Template Name: single
*/
/*  Connexion */
require 'config.php';
require 'models/getCategory.php';

$category = getCategory($config['category']['domains'], $config['category']['news']);
/* Display */
$context = Timber::get_context();
$context['visit'] = $category['visit'];
$context['title'] = $category['title'];
$context['currentDomain'] = $category['currentDomain'];
$context['institute'] = $category['institute'];
$context['userDomain'] = $category['userDomain'];

$context['postsdomain'] = Timber::get_posts(['category_name' => $category['userDomain']->name ]);
$context['post'] = new TimberPost();

foreach ($config['category']['domains'] as $value){
    $domainIds[] = get_category_by_slug($value)->term_id;
}
$context['alltheposts'] = Timber::get_posts(array( 'category__in' => $domainIds, 'showposts' => '5'));
Timber::render('single.twig', $context);
