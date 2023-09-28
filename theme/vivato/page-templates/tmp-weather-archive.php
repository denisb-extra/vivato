<?php
    // Template Name: Weather Archive Page
?>

<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="post">
	<div class="section-inner">
		<div class="content">
			<?php the_content(); ?>
		</div>
	</div>
</section>

<?php if(false) : ?>
<section class="list-cols">
	<div class="section-inner">
	   <p class="section-title centered">מזג אויר בערים</p>
		<ul>
			<?php 
				$terms = get_terms( array(
					'taxonomy'   => 'location',
					'hide_empty' => false,
				));
				
				foreach($terms as $term):
				if(!get_field('booking-data', $term)['location']['lat']) continue;
			?>
				<li><a href="/מזג-אוויר/<?=$term->slug?>/">מזג אויר ב<?=$term->name?></a></li>
			<?php endforeach; ?>
		</ul>
		
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>