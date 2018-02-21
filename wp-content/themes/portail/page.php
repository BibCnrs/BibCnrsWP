<?php
/**
 * Title: Page template.
 *
 * Description: Defines default template of a page.
 *
 */
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
Timber::render('page.twig', $context);
