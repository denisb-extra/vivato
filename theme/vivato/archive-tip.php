 <?php
    // Template Name: Tips Page
?>

<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php
	$id = 456;
	setup_postdata($id);
	global $post;
	$post = get_post($id);
	global $wp_query;
	$wp_query -> queried_object = $post;
?>
<?php
	global $page_title;
	$page_title = $post -> post_title;
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>


<?php 
	require get_template_directory() . '/inc/location/location-tips.php';
?>


	
<?php get_footer(); ?>