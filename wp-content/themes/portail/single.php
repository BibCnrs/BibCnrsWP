<?php
/*
Template Name: single
*/
/*  Connexion */
$category = get_the_category();
$title = $category[0]->name;
$subtitle = $category[0]->name;
$nicename = $category[0]->category_nicename;
/* Include CNRS domains definition ($cnrscat) and home category definition ($homenews) arrays*/
include 'config/catconfig.php';
if (in_array($nicename,$homenews)){
    $prefix = 'visite';
}
else {
force_login();
}
if (is_user_logged_in()){
    $_SESSION['domaine'] = 'biologie';
}
if (isset($_SESSION['domaine'])){
    $domain = $_SESSION['domaine'];
    $categOrigin = get_category_by_slug($_SESSION['domaine']);
    $institute = $categOrigin->category_description;
    $prefix = $_SESSION['domaine'];
    $subprefix = $_SESSION['domaine'];
    $visit = false;
    if ($nicename != $_SESSION['domaine']){
        $visit = true;
        $subtitle = $title;
        $title = $categOrigin->name;
        $subprefix = $nicename;
        if (in_array($nicename,$homenews)){
            $subprefix = 'visite';
        }
    }
    /* Delete origin domain from domains array for searching all the posts */
    while ( ($key = array_search($domain, $cnrscat)) !== false) {
        unset($cnrscat[$key]);
    }
    foreach ($cnrscat as $value){
        $cnrscatId[] = get_category_by_slug($value)->term_id;
    }
}
else {
    $domain = $nicename;
    $visit = false;
    if (in_array($nicename,$homenews)){
        $prefix = 'visite';
        $subprefix = 'visite';
        $institute = '';
    }
    else {
        $subprefix = $nicename;
        $prefix = $nicename;
        $institute = $category[0]->category_description;
    }
}
/* Display */
$context = Timber::get_context();
$context['prefix'] = $prefix;
$context['subprefix'] = $subprefix;
$context['visit'] = $visit;
$context['title'] = $title;
$context['subtitle'] = $subtitle;
$context['institute'] = $institute;
$context['domain'] = $domain;
$context['post'] = new TimberPost();
$context['postsdomain'] =Timber::get_posts(['category_name' => $domain ]);
$context['alltheposts'] = Timber::get_posts(array( 'category__in' => $cnrscatId, 'showposts' => '5'));
Timber::render('single.twig', $context);
