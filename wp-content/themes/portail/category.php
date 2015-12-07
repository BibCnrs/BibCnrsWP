<?php
/*
Template Name: category
*/
/*  Connexion */
require 'config.php';

require 'models/BibCnrsCategory.php';
$category = new BibCnrsCategory($config['category']['domains'], $config['category']['news']);

force_login($category->currentCategory, $config['category']['domains']);

require 'models/BibCnrsPosts.php';
$bibCnrsPosts = new BibCnrsPosts($config['category']['domains']);

/* Display */
$context = Timber::get_context();
$context['visit'] = $category->visit;
$context['currentCategory'] = $category->currentCategory;
$context['userCategory'] = $category->userCategory;

$context['categoryPosts'] = $bibCnrsPosts->getPostsFor($category->currentCategory);
$context['allOtherPosts'] = $bibCnrsPosts->getPostsNotIn($category->currentCategory, 5);

Timber::render('category.twig', $context);
