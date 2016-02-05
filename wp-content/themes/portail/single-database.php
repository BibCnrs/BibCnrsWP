<?php
/*
Template Name: single
*/
require 'config.php';
$context = Timber::get_context();
$context['post'] = new TimberPost();
Timber::render('single-database.twig', $context);
