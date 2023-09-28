<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>


<?php 
	$location_terms = get_the_terms($post, "location");
	if($location_terms) {
		$location_term = $location_terms[0];
		global $g_location_term;
		$g_location_term = $location_term;
	}
	
	require get_template_directory() . '/inc/hotels-search.php';
?>
<?php get_footer(); ?>