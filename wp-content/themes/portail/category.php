<?php
/*
Template Name: category
*/
/*  Connexion */
require 'config.php';

/* Display */
$context = Timber::get_context();
$context['currentCategory'] = get_queried_object();
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

$nicename = $context['currentCategory']->slug;
$name = $context['currentCategory']->name;
$parentCatID = get_cat_ID($name);
$slugs = get_categories( 'child_of='.$parentCatID );

// IF FAQ sub-categories display
switch ($nicename) {
    case "faq-".$language:
        foreach($slugs as $slug){
            $nom=$slug->slug;
        	$context['faqPosts'][] = [
                'title' => $slug->name,
        		'slug' => $slug,
        		'posts' => Timber::get_posts(array('category_name' => $nom))
        	];
        }
        Timber::render('faq.twig', $context);
        break;
    case "news":
    case "actus":
        /* news */
        $general= $language === 'fr' ? 'Commun' : 'Common';
        $generalID = get_cat_ID($general);
        $generalCat = get_category($generalID);
        foreach($slugs as $slug){
            $catID = $slug->cat_ID;
            $nom = explode("-",$slug->slug);
            $tag = $nom[1];
            $posts = Timber::get_posts(['category' => $catID,
                                        'date_query' => array(
                                         array(
                                         'after' => '-1 years',
                                         'column' => 'post_date',
                                         ),
                                         ),
                                     ]);
            for ($i = 0; $i < count($posts) ; $i++) {
                    $posts[$i]->category = $slug;
                    $posts[$i]->color = $config['color'][$slug->description]; 
            }
            $context['news'][] = [
                'tag' => $tag,
                'slug' => $slug,
                'color' => $config['color'][$slug->description],
                'posts' => $posts
            ];
        }
        /* discovery */
        $discovery= $language === 'fr' ? 'Découverte' : 'Discovery';
        $discoveryID = get_cat_ID($discovery);
        $ssdiscs = get_categories( 'child_of='.$discoveryID );
        $today = date(Ymd);
        foreach($ssdiscs as $ssdisc){
            $catID = $ssdisc->cat_ID;
            $nom = explode("-",$ssdisc->slug);
            $tag = $nom[1];
            $discs = Timber::get_posts(['category' => $catID, 
                                    'numberposts' => -1, 
                                    'meta_query' => array(array(
                                                    'key' => 'end_date',
                                                    'value' => $today, 
                                                    'type' => 'NUMERIC', 
                                                    'compare' => '>'),
                                                    ),
                                        ]);
           for ($i = 0; $i < count($discs) ; $i++) {
                $discs[$i]->category = $ssdisc;
                $discs[$i]->color = $config['color'][$slug->description];
            }
            $context['disc'][] = [
                'tag' => $tag,
                'slug' => $ssdisc,
                'color' => $config['color'][$ssdisc->description],
                'posts' => $discs
            ];
        }
        Timber::render('news.twig', $context);
        break;   
    case "outils":
    case "tools":
        foreach($slugs as $slug){
            $nom=$slug->slug;
            $context['bibcnrs'][] = [
                'slug' => $slug,
                'posts' => Timber::get_posts(array('category_name' => $nom))
            ];
        }
        Timber::render('tools.twig', $context);
        break;   
    case "decouvrir_bibcnrs":
    case "discover_bibcnrs":
        Timber::render('discovery.twig', $context);
        break;
    default:
        Timber::render('category.twig', $context);
}
