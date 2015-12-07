<?php
/**
 * Title: Page template.
 *
 * Description: Defines default template of a page.
 *
 */
$context = Timber::get_context();
$context['userDomain'] = (object) ['slug' => 'visit'];
Timber::render('page.twig', $context);
