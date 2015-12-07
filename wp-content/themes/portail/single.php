<?php
/*
Template Name: single
*/
/*  Connexion */
require 'config.php';

require 'models/BibCnrsCategory.php';
$category = new BibCnrsCategory($config['category']['domains'], $config['category']['news']);
force_login($category->currentCategory, $config['category']['domains']);

require 'models/BibCnrsPosts.php';
$posts = new BibCnrsPosts($config['category']['domains']);

/* Display */
$context = Timber::get_context();
$context['visit'] = $category['visit'];
$context['title'] = $category['title'];
$context['currentCategory'] = $category['currentCategory'];
$context['institute'] = $category['institute'];
$context['userCategory'] = $category['userCategory'];

$context['post'] = $posts->getCurrentPost();

$context['categoryPosts'] = $posts->getPostsFor($category->currentCategory);
$context['allOtherPosts'] = $posts->getPostsNotIn($category->currentCategory, 5);

Timber::render('single.twig', $context);
