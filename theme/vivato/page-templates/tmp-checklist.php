<?php
    // Template Name: Check List Page
?>

<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="checklist">
	<div class="section-inner">
		<div class="content">
			<?php the_content(); ?>
		</div>
	</div>
</section>

<script>
	$(document).ready(function ($) {
		$(".checklist .content ul li").on("click", function(){
			$(this).toggleClass("active");
		});
	});
</script>
	
<?php get_footer(); ?>