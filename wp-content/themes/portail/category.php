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
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$language = substr($context['site']->language, 0, 2);
$domain = $config['profile_map'][$currentCategory->description];
$context['links'] = $config['cnrs_links'][$currentCategory->description];
$dbUrl = $language === 'fr' ? '\/bases-de-donnees\/' : '\/data-bases\/';
$context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s" db_url="%s"]', $domain, $language, $dbUrl);
$context['bibcnrs_header'] = sprintf('[bibcnrs_header language="%s"]', $language);
$context['alerte']=Timber::get_posts(['category_name' => 'alertes', 'numberposts' => 1]);

// IF FAQ sub-categories display
$parentCatName = single_cat_title('',false);
if ($parentCatName == "F.A.Q." OR $parentCatName == "FAQ"){
    $parentCatID = get_cat_ID($parentCatName);
    $slugs = get_categories( 'child_of='.$parentCatID );
    $context['currentCategory'] = $currentCategory;
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
    $context['categoryPosts'] = $postsProvider->getPostsFor($currentCategory, 5);
    $context['allOtherPosts'] = $postsProvider->getPostsNotIn($currentCategory, 5);
    Timber::render('category.twig', $context);
}
