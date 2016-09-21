<?php
/**
 * Title: Page template.
 *
 * Description: Defines default template of a page.
 *
 */
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$context['bibcnrs_header'] = '[bibcnrs_header language="' . substr($context['site']->language, 0, 2) . '"]';
Timber::render('page.twig', $context);
