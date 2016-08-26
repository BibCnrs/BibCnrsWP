<?php
/*
Template Name: single
*/
// where do we come from ?
$exp = explode('/' , parse_url(wp_get_referer(), PHP_URL_PATH));
$categref = $exp['2'];
/*  Connexion */
require 'config.php';

require 'models/BibCnrsCategoriesProvider.php';
$categoriesProvider = new BibCnrsCategoriesProvider(get_the_category, get_category_by_slug, wp_get_current_user);
$currentCategory = get_category_by_slug($categref);
$userCategory = $categoriesProvider->getUserCategory();

require 'models/BibCnrsPostsProvider.php';
$getPosts = function ($args) {
    return Timber::get_posts($args);
};

$postsProvider = new BibCnrsPostsProvider($config['category']['domains'], get_category_by_slug, $getPosts, TimberPost);

/* Display */
$context = Timber::get_context();
$preferences="pref-".$currentCategory->slug;
$context['pref'] = Timber::get_posts(array('category_name' => $preferences));
$context['currentCategory'] = $currentCategory;
$context['userCategory'] = $userCategory;
$context['visit'] = $currentCategory->slug != $userCategory->slug;
$context['other'] = in_array($currentCategory->slug,$config['category']['domains']);
$context['post'] = new TimberPost();
$context['ebsco_widget'] = '[ebsco_widget domain="' . $config['profile_map'][$currentCategory->slug] . '"]';

$context['categoryPosts'] = $postsProvider->getPostsFor($currentCategory);
$context['allOtherPosts'] = $postsProvider->getPostsNotIn($currentCategory, 5);

Timber::render('single.twig', $context);

?>
