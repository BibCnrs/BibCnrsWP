<?php
/*
Template Name: single
*/
require 'config.php';
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$context['bibcnrs_header'] = '[bibcnrs_header language="' . substr($context['site']->language, 0, 2) . '"]';
$context['post'] = new TimberPost();
Timber::render('single-database.twig', $context);
