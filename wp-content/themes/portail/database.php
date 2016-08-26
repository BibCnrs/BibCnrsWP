<?php
/**
* Template Name: databases
*
* Description: Defines default template of Databases.
*
*/

require 'config.php';
$context = Timber::get_context();
$context['ebsco_widget'] = '[ebsco_widget domain="' . $config['profile_map'][$currentCategory->slug] . '"]';
$args = (array(
    'showposts' => -1,
    'post_type' => 'database',
    'tax_query' => array(
        array(
            'taxonomy' => 'databases',
            'field' => 'slug',
            'terms' => $config['category']['domains']
        )
    ),
    'orderby' => 'title',
    'order' => 'ASC')
);
$context['terms'] = get_terms('databases');
$context['origin'] = Timber::get_posts( $args );
Timber::render('database.twig', $context);
