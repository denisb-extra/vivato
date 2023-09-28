<?php $td = get_template_directory_uri(); ?>

<?php 
	if(isset($wp_query->query_vars['attraction_location'])) {
		$location_term = get_term_by('slug', $wp_query->query_vars['attraction_location'], 'location');
		$location_title = $location_term->name;
		
		global $g_location_term;
		$g_location_term = $location_term;
		
		global $meta_canonical;
		$meta_canonical = get_home_url() . "/אטרקציות/" .  $location_term->slug . "/";
	}
	if(isset($wp_query->query_vars['attraction_category'])) {
		$category_term = get_term_by('slug', $wp_query->query_vars['attraction_category'], 'attraction_category');
		$category_title = $category_term->name;
	}
	else {
		$category_title = "אטרקציות";
	}
	
	if(isset($category_term) && isset($location_term)) {
		$seo = get_seo_of_attraction_category_in_location($category_term->term_id, $location_term->term_id);
		
		global $meta_title;
		if(isset($seo['meta-title'])) $meta_title = $seo['meta-title'];
		else $meta_title = $category_title . " ב" . $location_title . " - " . get_bloginfo( 'name' );
		global $meta_description;
		if(isset($seo['meta-description'])) $meta_description = $seo['meta-description'];
		else $meta_description = $category_title . " ב" . $location_title . ", כל המידע על " . $category_title . " ב" . $location_title . ", מגלים את יוון, Vivato Greece השער שלך ליוון! ";
		
		
		global $meta_canonical;
		$meta_canonical = get_home_url() . "/אטרקציות/" .  $location_term->slug . "/" . $category_term->slug . "/";
	}
	
	if(isset($location_term)) {
		global $my_bradcrumbs;
		$my_bradcrumbs[] = array(
			'url' => get_home_url(),
			'text' => 'בית',
		);
		$my_bradcrumbs[] = array(
			'url' => get_permalink(10),
			'text' => 'אטרקציות',
		);
		$my_bradcrumbs[] = array(
			'url' => "",
			'text' => 'אטרקציות ב' . $location_term->name,
		);
		
		if(isset($category_term)) {
			$my_bradcrumbs = [];
			$my_bradcrumbs[] = array(
				'url' => get_home_url(),
				'text' => 'בית',
			);
			$my_bradcrumbs[] = array(
				'url' => get_home_url() . "/אטרקציות/" .  $location_term->slug . "/",
				'text' => 'אטרקציות ב' . $location_term->name,
			);
			$my_bradcrumbs[] = array(
				'url' => "",
				'text' => $category_term->name . " ב" . $location_term->name,
			);
		}
		
		if(!isset($category_term)) {
			$seo = get_field('attractions-meta', $location_term )['seo'];
			global $meta_title;
			$meta_title = $seo['meta-title'];
			global $meta_description;
			$meta_description = $seo['meta-description'];
		}
	}
	
	
?>



<?php get_header(); ?>

<?php 
	global $page_title;
	$page_title = $category_title . " ב" . $location_title;
	
	global $wp_query;
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<?php 
	if(isset($category_term)) require get_template_directory() . '/inc/attraction_category.php';
	else require get_template_directory() . '/inc/location/location-attraction.php';
?>	

<?php get_footer(); ?>