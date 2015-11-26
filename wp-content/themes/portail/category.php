<?php
/*
Template Name: category
*/
/*  connexion */
session_start();
$category=get_the_category();
$title=$category[0]->name;
$subtitle=$category[0]->name;
$nicename= $category[0]->category_nicename;
$slugs = array('une', 'formations', 'infosist');
if ($nicename == 'une' OR $nicename == 'formations' OR $nicename == 'infosist'){
    $prefix = "visite";
}
else {
force_login();
}
if (is_user_logged_in()){
    $_SESSION["domaine"]='biologie';
}
if (isset($_SESSION['domaine'])){
    $domain = $_SESSION['domaine'];
    $categOrigin=get_category_by_slug($_SESSION['domaine']);
    $institute= $categOrigin->category_description;
    $prefix=$_SESSION['domaine'];
    $subprefix=$_SESSION['domaine'];
    $visit = false;
    if ($nicename != $_SESSION['domaine']){
        $visit = true;
        $subtitle = $title;
        $title = $categOrigin->name;
        $subprefix = $nicename;
    }
}
else {
    $domain = $nicename;
    $visit = false;
    if ($nicename == 'une' OR $nicename == 'formations' OR $nicename == 'infosist'){
        $prefix = "visite";
        $subprefix = "visite";
        $institute= '';
    }
    else {
        $subprefix = $nicename;
        $prefix = $nicename;
        $institute = $category[0]->category_description;
    }
}
/* affichage */
$context = Timber::get_context();
$context['prefix'] = $prefix;
$context['subprefix'] = $subprefix;
$context['visit'] = $visit;
$context['title'] = $title;
$context['subtitle'] = $subtitle;
$context['institute'] = $institute;
$context['postsdomain'] =Timber::get_posts(['category_name' => $domain ]);
$context['alltheposts'] = Timber::get_posts(array( 'cat' => '-1,-13,-14,-15,-16', 'showposts' => '5'));
Timber::render('category.twig', $context);
?>
