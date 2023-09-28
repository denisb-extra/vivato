<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
	
	global $wp_query;

	
?>

<section class="post">
	<div class="section-inner">
		<div class="content">
		
			<p><?=$wp_query->query_vars['attraction_location']?></p>
		</div>
	</div>
</section>
	
<?php get_footer(); ?>