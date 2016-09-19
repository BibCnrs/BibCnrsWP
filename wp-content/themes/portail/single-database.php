<?php
/*
Template Name: single
*/
require 'config.php';
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
$context['post'] = new TimberPost();
Timber::render('single-database.twig', $context);
