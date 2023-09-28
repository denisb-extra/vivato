<?php $td = get_template_directory_uri(); ?>


<?php 
	global $wp_query;
	if(isset($wp_query->query_vars['article_location'])) {
		$location_term = get_term_by('slug', $wp_query->query_vars['article_location'], 'location');
		$location_title = $location_term->name;
		
		global $g_location_term;
		$g_location_term = $location_term;
	}
	if(isset($wp_query->query_vars['article_category'])) {
		$cur_term = get_term_by('slug', $wp_query->query_vars['article_category'], 'category');
		$category_title = $cur_term->name;
	}
	else {
		$category_title = "מדריכים";
	}

	
	global $page_title;
	$page_title = $category_title . " על " . $location_title;
	

	
	if(isset($cur_term) && isset($location_term)) {
		$page_title = $category_title . " ב" . $location_title;
		
		$seo = get_seo_of_posts_category_in_location($cur_term->term_id, $location_term->term_id);
		
		global $meta_title;
		if(isset($seo['meta-title'])) $meta_title = $seo['meta-title'];
		else $meta_title = $category_title . " ב" . $location_title . " - מדריכים ומידע - " . get_bloginfo( 'name' );
		global $meta_description;
		if(isset($seo['meta-description'])) $meta_description = $seo['meta-description'];
		else $meta_description = " מדריכים ומידע על " . $category_title . " ב" . $location_title . " - כל המידע הנחוץ על " . $category_title . " ב" . $location_title . ", מאמרים, מדריכי טיולים, כתבות וסקירות, כל המידע הנחוץ לחופשה מושלמת";
		
		global $meta_canonical;
		$meta_canonical = get_home_url() . "/מדריכים/" .  $location_term->slug . "/" . $cur_term->slug . "/";
		
		
		global $my_bradcrumbs;
		$my_bradcrumbs = [];
		$my_bradcrumbs[] = array(
			'url' => get_home_url(),
			'text' => 'בית',
		);
		$my_bradcrumbs[] = array(
			'url' => get_permalink(20),
			'text' => 'מדריכים',
		);
		$my_bradcrumbs[] = array(
			'url' => "",
			'text' => $page_title,
		);
	}
	
	elseif(isset($location_term)) {
		global $meta_title;
		$meta_title = "מדריכים ומידע על " . $location_title . " - " . get_bloginfo( 'name' );
		global $meta_description;
		$meta_description = "מדריכים ומידע על " . $location_title . " - " . "כל המידע הנחוץ למטייל על " . $location_title . ", מאמרים, מדריכי טיולים, כתבות וסקירות, כל המידע לחופשה מושלמת ב" . $location_title;
		
		global $meta_canonical;
		$meta_canonical = get_home_url() . "/מדריכים/" .  $location_term->slug . "/";
		
		global $my_bradcrumbs;
		$my_bradcrumbs = [];
		$my_bradcrumbs[] = array(
			'url' => get_home_url(),
			'text' => 'בית',
		);
		$my_bradcrumbs[] = array(
			'url' => get_permalink(20),
			'text' => 'מדריכים',
		);
		$my_bradcrumbs[] = array(
			'url' => "",
			'text' => $page_title,
		);
	}
	
	
	
	
	
	
?>

<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' );
?>


<?php 
	require get_template_directory() . '/inc/posts.php';
?>
	
<?php get_footer(); ?>