<?php
/*
Template Name: category
*/
/*  Connexion */
require 'config.php';

require 'models/BibCnrsCategoriesProvider.php';
$categoriesProvider = new BibCnrsCategoriesProvider(get_the_category, get_category_by_slug, wp_get_current_user);

$currentCategory = $categoriesProvider->getCurrentCategory();
$userCategory = $categoriesProvider->getUserCategory();

require 'models/BibCnrsPostsProvider.php';
$getPosts = function ($args) {
    return Timber::get_posts($args);
};

$postsProvider = new BibCnrsPostsProvider($config['category']['domains'], get_category_by_slug, $getPosts);

/* Display */
$context = Timber::get_context();
$context['currentCategory'] = $currentCategory;
$context['userCategory'] = $userCategory;
$context['visit'] = $currentCategory->slug != $userCategory->slug;

$context['categoryPosts'] = $postsProvider->getPostsFor($currentCategory);
$context['allOtherPosts'] = $postsProvider->getPostsNotIn($currentCategory, 5);

Timber::render('category.twig', $context);
