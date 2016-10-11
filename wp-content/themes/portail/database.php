<?php
/**
* Template Name: databases
*
* Description: Defines default template of Databases.
*
*/

require 'config.php';
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$language = substr($context['site']->language, 0, 2);
$domain = $config['profile_map'][$currentCategory->description];
$dbUrl = $language === 'fr' ? '\/bases-de-donnees\/' : '\/data-bases\/';
$context['ebsco_widget'] = sprintf('[ebsco_widget domain="%s" language="%s" db_url="%s"]', $domain, $language, $dbUrl);
$context['bibcnrs_header'] = sprintf('[bibcnrs_header language="%s"]', $language);
$args = (array(
    'posts_per_page' => -1,
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
