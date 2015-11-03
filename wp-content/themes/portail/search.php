<?php
/*Template Name: Search*/
?>
<?php
get_header();
?>
<div id="center3">
<?php
get_sidebar('left');
echo do_shortcode('[ebsco_widget]');
get_sidebar('right');
?>
<p align="left"></p></div>
<?php
get_footer();
?>
