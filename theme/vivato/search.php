<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $wp_query;
	
	global $page_title_h1;
	$page_title_h1 = true;
	
	global $page_title;
	$page_title = "תוצאות חיפוש";
	
	get_template_part( 'template-parts/top-inner' ); 
?>
<?php 
	global $wp_query;
	$posts = $wp_query -> posts;
?>

<section class="search-results">
	<div class="section-inner">
		<p class="section-title">תוצאות חיפוש עבור "<span><?=$wp_query->query['s']?></span>"</p>

		<div class="boxes">
			<?php 
				foreach($posts as $p) {
					template_search_box($p->ID);
				}
			?>
		</div>
	</div>
</section>
	
<?php get_footer(); ?>