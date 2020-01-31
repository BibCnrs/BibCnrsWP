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
$context['long_title'] = $language === 'fr' ?
        'Accès aux ressources documentaires des unités de recherche du CNRS'
    :
        'CNRS research units documents access';
$context['short_title'] = $language === 'fr' ?
        'Accès aux ressources documentaires du CNRS'
    :
        'CNRS documents access';
$domain = $config['profile_map'][$currentCategory->description];
$context['links'] = $config['cnrs_links'][$currentCategory->description];
$context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s"]', $domain, $language, $dbUrl);
$alert = $language === 'fr' ? 'alertes' : 'warning';
$context['alerte']=Timber::get_posts(['category_name' => $alert, 'numberposts' => 1]);

$nicename = $currentCategory->slug;
$name = $currentCategory->name;
$context['currentCategory_name'] = $name; 
$parentCatID = get_cat_ID($name);
$slugs = get_categories( 'child_of='.$parentCatID );


// IF FAQ sub-categories display
if ($nicename == "faq-".$language){
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
elseif ($nicename == "news" OR $nicename == "actus"){
    $general= $language === 'fr' ? 'Générales' : 'General';
    $generalID = get_cat_ID($general);
    $generalCat = get_category($generalID);
    foreach($slugs as $slug){
        $catID = $slug->cat_ID;
        $nom=$slug->slug;
        if ($generalID == $catID) {
            $posts = Timber::get_posts(['category' => $generalID, 'numberposts' => -1]);           
        }
        else {
            $posts = Timber::get_posts(['category' => $catID, 'numberposts' => -1]);
        }
        for ($i = 0; $i < count($posts) ; $i++) {
            $multicat = get_the_category($posts[$i]->ID);
             if ($multicat[0]->cat_ID == $generalID) {
                $posts[$i]->category_name = $generalCat->name;
                $posts[$i]->category = $generalCat;
                $posts[$i]->color = $config['color'][$generalCat->description];
            }
            else {
                $posts[$i]->category_name = $slug->name;
                $posts[$i]->category = $slug;
                $posts[$i]->color = $config['color'][$slug->description]; 
            }
        }
        $context['news'][] = [
            'title' => get_category_by_slug($nom)->name,
            'slug' => $slug,
            'color' => $config['color'][$slug->description],
            'posts' => $posts
        ];
    }
    Timber::render('news.twig', $context);    
}
else if ($nicename == "decouverte" OR $nicename == "discovery" ) {
    $today = date(Ymd);
    foreach($slugs as $slug){
        $catID = $slug->cat_ID;
        $nom=$slug->slug;
        $posts = Timber::get_posts(['category' => $catID, 
                                'numberposts' => -1, 
                                'meta_query' => array(array(
                                                'key' => 'end_date',
                                                'value' => $today, 
                                                'type' => 'NUMERIC', 
                                                'compare' => '>'),
                                                ),
                                    ]);
        for ($i = 0; $i < count($posts) ; $i++) {
            $posts[$i]->category = $slug;
            $posts[$i]->color = $config['color'][$slug->description];
        }
        if ($nom == "disc-commun" OR $nom =="disc-common") {
            $context['common'][] =[
                'slug' => $slug,
                'color' => $config['color'][$slug->description],
                'posts' => $posts
            ];
        }
        else {
            $context['disc'][] = [
                'slug' => $slug,
                'color' => $config['color'][$slug->description],
                'posts' => $posts
            ];
        }
    }
//     print_r($context['common']);
    Timber::render('discovery.twig', $context);
}

else {
    Timber::render('category.twig', $context);
}
