<?php
/*
Template Name: single
*/

require 'config.php';

$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$language = substr($context['site']->language, 0, 2);
$context['bibcnrs_header'] = sprintf('[bibcnrs_header language="%s"]', $language);

$multicat=get_the_category();

for ($i = 0; $i < sizeof($multicat); $i++){
    if ($multicat[$i]->slug == 'decouverte' or $multicat[$i]->slug == 'discovery') {
        $discovery = TRUE;
        $parentCatName = $multicat[$i]->name;
    }
}
if ($discovery == TRUE) {
    $context['presentation'] = new TimberPost();
    $parentCatID = get_cat_ID($parentCatName);
    $slugs = get_categories( 'child_of='.$parentCatID );
    foreach($slugs as $slug){
        $nom=$slug->slug;
        $description=$slug->description;
    	$context['discoveryPosts'][] = [
            'title' => $config['correspondence_map'][$description],
    		'slug' => $slug,
    		'posts' => Timber::get_posts(array('category_name' => $nom , 'order' => 'ASC'))
    	];
    }
    $context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s" db_url="%s"]', $domain, $language, $dbUrl);
    Timber::render('discovery.twig', $context);
}
else {
    if ($multicat[0]->slug == 'list-diff' or $multicat[0]->slug == 'mail-list') {
        $context['profile']=$config['profile_map'];
        $context['post'] = Timber::get_post();
        Timber::render('singlelist.twig', $context);
    }
    else {
        require 'models/BibCnrsCategoriesProvider.php';
        $categoriesProvider = new BibCnrsCategoriesProvider(get_the_category, get_category_by_slug, wp_get_current_user);
        $current_url = "//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
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
        $preferences = "pref-" . $currentCategory->slug;
        $context['pref'] = Timber::get_posts(array('category_name' => $preferences));
        $context['currentCategory'] = $currentCategory;
        $context['userCategory'] = $userCategory;
        $domain = $config['profile_map'][$currentCategory->description];
        $dbUrl = $language === 'fr' ? '\/bases-de-donnees\/' : '\/data-bases\/';
        $context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s" db_url="%s"]', $domain, $language, $dbUrl);
        $context['post'] = new TimberPost();
        $context['page'] = "single";
        $context['categoryPosts'] = $postsProvider->getPostsFor($currentCategory, 5);
        $context['allOtherPosts'] = $postsProvider->getPostsNotIn($currentCategory, 5);

        Timber::render('single.twig', $context);
    }
}
