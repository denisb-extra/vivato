 <?php
    // Template Name: Locations Page
?>

<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php
	$id = 60;
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


<section class="locations">
	<div class="section-inner">
		<div class="content">
			<?=get_field('content-top');?>
		</div>
		<div class="boxes">
			<?php 
				$terms = get_terms( array(
					'taxonomy'   => 'location',
					'hide_empty' => false,
				));
				foreach($terms as $term) {
					template_location_box($term->term_id);
				}
			?>

		</div>
	</div>
</section>

	
<?php get_footer(); ?>