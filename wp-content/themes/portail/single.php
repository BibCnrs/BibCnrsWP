<?php
/*
Template Name: single
*/
/*  Connexion */
require 'config.php';

require 'models/BibCnrsDomain.php';
$domain = new BibCnrsDomain($config['category']['domains'], $config['category']['news']);
force_login($domain->currentDomain, $config['category']['domains']);

require 'models/BibCnrsPosts.php';
$posts = new BibCnrsPosts($config['category']['domains']);

/* Display */
$context = Timber::get_context();
$context['visit'] = $domain['visit'];
$context['title'] = $domain['title'];
$context['currentDomain'] = $domain['currentDomain'];
$context['institute'] = $domain['institute'];
$context['userDomain'] = $domain['userDomain'];

$context['post'] = $posts->getCurrentPost();

$context['postsdomain'] = $posts->getPostsFor($domain->currentDomain);
$context['alltheposts'] = $posts->getPostsNotIn($domain->currentDomain, 5);

Timber::render('single.twig', $context);
