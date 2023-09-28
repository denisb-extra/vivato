<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	$cur_term = get_queried_object();
	global $g_location_term;
	$g_location_term = $cur_term;
	
	global $page_title_h1;
	$page_title_h1 = true;
	
	$content_type = "";
	
	
	if(isset($_GET['content_type'])) {
		$content_type = $_GET['content_type'];
		
		if($_GET['content_type'] == "attraction"){
			global $page_title;
			$page_title = "אטרקציות" . " ב" . $cur_term->name;
		}
		
		if($_GET['content_type'] == "tips"){
			global $page_title;
			$page_title = "טיפים לטיולים";
		}
	}
	get_template_part( 'template-parts/top-inner' );
?>



<?php 
	if($content_type == "attraction") {
		require get_template_directory() . '/inc/location/location-attraction.php';
	}
	elseif($content_type == "tips") {
		require get_template_directory() . '/inc/location/location-tips.php';
	}
	else {
		require get_template_directory() . '/inc/location/location.php';
	}
?>


<?php get_footer(); ?>