<?php
/**
 * Title: Page template.
 *
 * Description: Defines default template of a page.
 *
 */
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
Timber::render('page.twig', $context);
