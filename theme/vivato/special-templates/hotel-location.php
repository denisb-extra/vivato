<?php $td = get_template_directory_uri(); ?>

<?php 
	if(isset($wp_query->query_vars['hotel_location'])) {
		$location_term = get_term_by('slug', $wp_query->query_vars['hotel_location'], 'location');
		$location_title = $location_term->name;
		
		global $g_location_term;
		$g_location_term = $location_term;
		
		global $meta_canonical;
		$meta_canonical = get_home_url() . "/בתי-מלון/" .  $location_term->slug . "/";
	}
	
	if( get_field('content-seo-hotels', $location_term )) {
		$seo = get_field('content-seo-hotels', $location_term )['seo'];
		global $meta_title;
		$meta_title = $seo['meta-title'];
		global $meta_description;
		$meta_description = $seo['meta-description'];	
	}
	
	
	
	global $my_bradcrumbs;
	$my_bradcrumbs[] = array(
		'url' => get_home_url(),
		'text' => 'בית',
	);
	$my_bradcrumbs[] = array(
		'url' => get_permalink(8),
		'text' => 'בתי מלון',
	);
	$my_bradcrumbs[] = array(
		'url' => "",
		'text' => $location_term->name,
	);
?>


<?php get_header(); ?>


<?php 
	require get_template_directory() . '/inc/hotels-search.php';
?>
	
<?php get_footer(); ?>