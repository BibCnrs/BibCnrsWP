<?php
/*
Template Name: single
*/
require 'config.php';
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$language = substr($context['site']->language, 0, 2);
$context['bibcnrs_header'] = sprintf('[bibcnrs_header language="%s"]', $language);
$context['post'] = new TimberPost();
Timber::render('single-database.twig', $context);
