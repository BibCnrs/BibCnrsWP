<?php
/*
Template Name: single
*/
/*  Connexion */
require 'config.php';

require 'models/BibCnrsCategoriesProvider.php';
$categoriesProvider = new BibCnrsCategoriesProvider(get_the_category, get_category_by_slug, wp_get_current_user);
$currentCategory = $categoriesProvider->getCurrentCategory();
$userCategory = $categoriesProvider->getUserCategory();

force_login($currentCategory, $config['category']['domains']);

require 'models/BibCnrsPostsProvider.php';
$postsProvider = new BibCnrsPostsProvider($config['category']['domains']);

/* Display */
$context = Timber::get_context();
$context['currentCategory'] = $currentCategory;
$context['userCategory'] = $userCategory;
$context['visit'] = $currentCategory->slug != $userCategory->slug;

$context['post'] = $postsProvider->getCurrentPost();

$context['categoryPosts'] = $postsProvider->getPostsFor($currentCategory);
$context['allOtherPosts'] = $postsProvider->getPostsNotIn($currentCategory, 5);

Timber::render('single.twig', $context);
