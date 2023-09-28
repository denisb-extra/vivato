<?php $td = get_template_directory_uri(); ?>


<?php 
	global $wp_query;
	
	if(isset($wp_query->query_vars['tip_location'])) {
		$location_term = get_term_by('slug', $wp_query->query_vars['tip_location'], 'location');
		$location_title = $location_term->name;
		
		global $g_location_term;
		$g_location_term = $location_term;
		
		$category_title = "טיפים והמלצות";
		global $page_title;
		$page_title = $category_title . " על " . $location_title;
		
		global $meta_title;
		$meta_title = $page_title;
		
		if(isset($location_term)) {
			$seo = get_field('tips-meta', $location_term )['seo'];
			global $meta_title;
			if($seo['meta-title']) $meta_title = $seo['meta-title'];
			else $meta_title = "טיפים למטיילים ב" . $location_term->name . " - " . get_bloginfo( 'name' );
			global $meta_description;
			if($seo['meta-description']) $meta_description = $seo['meta-description'];
			else $meta_description = "טיפים למטיילים ב" . $location_term->name . ", כל הטיפים והמלצות הגולשים לחופשה מושלמת ב" . $location_term->name . ", שתפו וגלו המלצות וטיפים מובילים ל" . $location_term->name . " עם Vivato Greece, השער שלך ליוון!";
		}
		
		
		global $my_bradcrumbs;
		$my_bradcrumbs[] = array(
			'url' => get_home_url(),
			'text' => 'בית',
		);
		$my_bradcrumbs[] = array(
			'url' => get_permalink(456),
			'text' => 'טיפים והמלצות',
		);
		$my_bradcrumbs[] = array(
			'url' => "",
			'text' => $location_term->name,
		);
	
		
		global $meta_canonical;
		$meta_canonical = get_home_url() . "/טיפים/" .  $location_term->slug . "/";
		
		
		
	}
?>


<?php get_header(); ?>

<?php 
	
	
	
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<?php 
	require get_template_directory() . '/inc/location/location-tips.php';
?>
	
<?php get_footer(); ?>