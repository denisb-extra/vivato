<?php
    // Template Name: Single Hotel Page
?>
<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>
<?php 
	get_template_part( 'template-parts/top-inner' ); 
?>
<?php 
	require get_template_directory() . '/inc/hotel.php';
?>
<?php get_footer(); ?>