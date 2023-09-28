<?php
    // Template Name: Hotels Page
?>

<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php
	$id = 8;
	setup_postdata($id);
	global $post;
	$post = get_post($id);
	global $wp_query;
	$wp_query -> queried_object = $post;
?>


<?php 
	require get_template_directory() . '/inc/hotels-search.php';
?>

	
<?php get_footer(); ?>