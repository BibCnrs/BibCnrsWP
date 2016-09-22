<?php
/**
* Title: taxonomy-databases template.
*
* Description: Defines default template of Databases.
*
*/
require 'config.php';
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$language = substr($context['site']->language, 0, 2);
$domain = $config['profile_map'][$currentCategory->description];
$context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s"]', $domain, $language);
$context['bibcnrs_header'] = sprintf('[bibcnrs_header language="%s"]', $language);
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
