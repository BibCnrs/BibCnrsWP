<?php
/*
Template Name: category
*/
/*  Connexion */
require 'config.php';
require 'models/BibCnrsDomain.php';
$domain = new BibCnrsDomain($config['category']['domains'], $config['category']['news']);
force_login($domain->currentDomain, $config['category']['domains']);

/* Display */
$context = Timber::get_context();
$context['visit'] = $domain->visit;
$context['currentDomain'] = $domain->currentDomain;
$context['userDomain'] = $domain->userDomain;

$context['postsdomain'] = Timber::get_posts(['category_name' => $domain->currentDomain->slug ]);

$domainIds = [];
foreach ($config['category']['domains'] as $value) {
    $cat = get_category_by_slug($value);
    if ($cat->slug != $context['currentDomain']->slug) {
        $domainIds[] = get_category_by_slug($value)->term_id;
    }
}
$context['alltheposts'] = Timber::get_posts(array( 'category__in' => $domainIds, 'showposts' => '5'));
Timber::render('category.twig', $context);
