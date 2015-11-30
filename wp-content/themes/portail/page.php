<?php
/**
 * Title: Page template.
 *
 * Description: Defines default template of a page.
 *
 */
$context = Timber::get_context();
$context['prefix'] = "visite";
Timber::render('page.twig', $context);
