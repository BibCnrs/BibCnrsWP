<?php
/*
Template Name: category
*/
/*  Connexion */
require 'config.php';

require 'models/BibCnrsDomain.php';
$domain = new BibCnrsDomain($config['category']['domains'], $config['category']['news']);

force_login($domain->currentDomain, $config['category']['domains']);

require 'models/BibCnrsPosts.php';
$bibCnrsPosts = new BibCnrsPosts($config['category']['domains']);

/* Display */
$context = Timber::get_context();
$context['visit'] = $domain->visit;
$context['currentDomain'] = $domain->currentDomain;
$context['userDomain'] = $domain->userDomain;

$context['postsdomain'] = $bibCnrsPosts->getPostsFor($domain->currentDomain);
$context['alltheposts'] = $bibCnrsPosts->getPostsNotIn($domain->currentDomain, 5);

Timber::render('category.twig', $context);
