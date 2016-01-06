<?php
/**
 * Title: Page template.
 *
 * Description: Defines default template of a page.
 *
 */
$context = Timber::get_context();
$context['userCategory'] = (object) ['slug' => 'visite'];
Timber::render('page.twig', $context);
