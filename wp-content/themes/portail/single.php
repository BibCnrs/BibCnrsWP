<?php
/*
Template Name: single
*/
/*  Connexion */
require 'config.php';
require 'models/BibCnrsDomain.php';

$domain = new BibCnrsDomain($config['category']['domains'], $config['category']['news']);
force_login($domain->currentDomain, $config['category']['domains']);

/* Display */
$context = Timber::get_context();
$context['visit'] = $domain['visit'];
$context['title'] = $domain['title'];
$context['currentDomain'] = $domain['currentDomain'];
$context['institute'] = $domain['institute'];
$context['userDomain'] = $domain['userDomain'];

$context['postsdomain'] = Timber::get_posts(['category_name' => $domain['userDomain']->name ]);
$context['post'] = new TimberPost();

foreach ($config['category']['domains'] as $value){
    $domainIds[] = get_category_by_slug($value)->term_id;
}
$context['alltheposts'] = Timber::get_posts(array( 'category__in' => $domainIds, 'showposts' => '5'));
Timber::render('single.twig', $context);
