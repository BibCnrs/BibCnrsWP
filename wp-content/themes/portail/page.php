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
$context['bibcnrs_header'] = sprintf('[bibcnrs_header language="%s"]', $language);
Timber::render('page.twig', $context);
