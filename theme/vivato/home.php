<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php
	$id = get_option( 'page_for_posts' );
	setup_postdata($id);
	global $post;
	$post = get_post($id);
?>

<?php 
	if(isset($_GET['location_id'])) {
		$location_term = get_term($_GET['location_id']);
		global $page_title;
		$page_title = "מדריכים" . " על " . $location_term->name;
	}
	
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<?php 
	require get_template_directory() . '/inc/posts.php';
?>


<?php get_footer(); ?>