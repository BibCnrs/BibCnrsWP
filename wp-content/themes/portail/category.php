<?php
/*
Template Name: category
*/
/*  Connexion */
require 'config.php';
require 'models/getCategory.php';
$category = getCategory($config['category']['domains'], $config['category']['news']);

/* Display */
$context = Timber::get_context();
$context['visit'] = $category['visit'];
$context['currentDomain'] = $category['currentDomain'];
$context['userDomain'] = $category['userDomain'];

$context['postsdomain'] = Timber::get_posts(['category_name' => $category['currentDomain']->slug ]);
foreach ($config['category']['domains'] as $value) {
    $cat = get_category_by_slug($value);
    if ($cat->slug != $context['currentDomain']->slug) {
        $domainIds[] = get_category_by_slug($value)->term_id;
    }
}

$context['alltheposts'] = Timber::get_posts(array( 'category__in' => $domainIds, 'showposts' => '5'));
Timber::render('category.twig', $context);
