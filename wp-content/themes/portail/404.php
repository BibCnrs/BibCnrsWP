<?php
$context = Timber::get_context();
$context['robot_index'] = $_ENV['ROBOT_INDEX'];
Timber::render('404.twig', $context);
