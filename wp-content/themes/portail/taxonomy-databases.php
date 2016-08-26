<?php
/**
* Title: taxonomy-databases template.
*
* Description: Defines default template of Databases.
*
*/
require 'config.php';
$context = Timber::get_context();
$context['ebsco_widget'] = '[ebsco_widget domain="' . $config['profile_map'][$currentCategory->slug] . '"]';
$context['domain'] = (array) $wp_query->queried_object;
$args = (array(
    'showposts' => -1,
    'post_type' => 'database',
    'tax_query' => array(
        array(
        'taxonomy' => 'databases',
        'field' => 'slug',
        'terms' =>  $context['domain']['slug'])
    ),
    'orderby' => 'post_title',
    'order' => 'ASC')
);
$context['terms'] = get_terms('databases');
$context['origin'] = Timber::get_posts( $args );
Timber::render('taxonomy-databases.twig', $context);
