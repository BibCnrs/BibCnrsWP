<?php
/*
Template Name: category
*/
/*  Connexion */
require 'config.php';
require 'models/BibCnrsCategoriesProvider.php';
$categoriesProvider = new BibCnrsCategoriesProvider('get_the_category', 'get_category_by_slug', 'wp_get_current_user');

$userCategory = $categoriesProvider->getUserCategory();
$currentCategory = get_queried_object();
require 'models/BibCnrsPostsProvider.php';
$getPosts = function ($args) {
    return Timber::get_posts($args);
};

$postsProvider = new BibCnrsPostsProvider($config['category']['domains'], 'get_category_by_slug', $getPosts);
/* Display */
$context = Timber::get_context();
$context['ebsco_widget'] = '[ebsco_widget domain="' . $config['profile_map'][$currentCategory->slug] . '"]';

// IF FAQ other display and sub-categories
$parentCatName = single_cat_title('',false);
if ($parentCatName == "F.A.Q." OR $parentCatName == "FAQ"){
    $parentCatID = get_cat_ID($parentCatName);
    $slugs = get_categories( 'child_of='.$parentCatID );
    foreach($slugs as $slug){
        $nom=$slug->slug;
    	$context['faqPosts'][] = [
            'title' => get_category_by_slug($nom)->name,
    		'slug' => $slug,
    		'posts' => Timber::get_posts(array('category_name' => $nom))
    	];
    }
    Timber::render('faq.twig', $context);
}
else{
    $preferences="pref-".$currentCategory->slug;
    $context['pref'] = Timber::get_posts(array('category_name' => $preferences));
    $context['currentCategory'] = $currentCategory;
    $context['userCategory'] = $userCategory;
    $context['other'] = in_array($currentCategory->slug,$config['category']['domains']);
    $context['categoryPosts'] = $postsProvider->getPostsFor($currentCategory);
    $context['allOtherPosts'] = $postsProvider->getPostsNotIn($currentCategory, 5);
    $context['page'] = "category";
    Timber::render('category.twig', $context);
}
?>
