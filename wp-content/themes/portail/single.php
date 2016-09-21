<?php
/*
Template Name: single
*/

require 'config.php';

$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$context['bibcnrs_header'] = '[bibcnrs_header language="' . substr($context['site']->language, 0, 2) . '"]';
$multicat=get_the_category();
if ($multicat[0]->slug == 'list-diff' or $multicat[0]->slug == 'mail-list') {
    $context['profile']=$config['profile_map'];
    $context['post'] = Timber::get_post();
    Timber::render('singlelist.twig', $context);
}
else {
    require 'models/BibCnrsCategoriesProvider.php';
    $categoriesProvider = new BibCnrsCategoriesProvider(get_the_category, get_category_by_slug, wp_get_current_user);
    $current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $categoryRetrieve = explode('category=' , $current_url);
    if ($categoryRetrieve[1]){
        $currentCategory = get_category_by_slug($categoryRetrieve[1]);
    }
    else {
        $currentCategory = $multicat[0];
    }
    $userCategory = $categoriesProvider->getUserCategory();

    require 'models/BibCnrsPostsProvider.php';
    $getPosts = function ($args) {
        return Timber::get_posts($args);
    };

    $postsProvider = new BibCnrsPostsProvider($config['category']['domains'], get_category_by_slug, $getPosts, TimberPost);

    /* Display */
    $preferences="pref-".$currentCategory->slug;
    $context['pref'] = Timber::get_posts(array('category_name' => $preferences));
    $context['currentCategory'] = $currentCategory;
    $context['userCategory'] = $userCategory;
    $context['ebsco_widget'] = '[ebsco_widget domain="' . $config['profile_map'][$currentCategory->slug] . '"]';
    $context['post'] = new TimberPost();

    $context['categoryPosts'] = $postsProvider->getPostsFor($currentCategory, 5);
    $context['allOtherPosts'] = $postsProvider->getPostsNotIn($currentCategory, 5);

    Timber::render('single.twig', $context);
}
