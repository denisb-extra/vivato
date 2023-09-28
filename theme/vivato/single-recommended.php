<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	$location_terms = get_the_terms($post, "location");
	if($location_terms) {
		$location_term = $location_terms[0];
		global $g_location_term;
		$g_location_term = $location_term;
	}
	
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="location-top">
	<div class="section-inner">
		<div class="parts ai-center">
			<div class="part">
				<div class="content">
					<?php 
						the_content();
					?>
					
				</div>
			</div>
			<?php 
				$image = get_the_post_thumbnail_url($post, 'full');
				if($image):
			?>
			
			<div class="part">
				<div class="image">
					<div class="image-shadow">
						<img src="<?=$image?>" alt="<?=$post->post_title?>" title="<?=$post->post_title?>">
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php 
	$items = get_field('sections');
	foreach($items as $item):
?>
<section class="location-hotels" id="s2">
	<div class="section-inner">
		<h2 class="section-title"><?=$item["title"];?></h2>
		<?php if($item["content"]) : ?>
		<br>
		<div class="content">
			<?=$item["content"];?>
		</div>
		<?php endif; ?>
		<div class="boxes">
			<?php 
				$hotels = $item['hotels'];
				foreach($hotels as $hotel){
					template_box_hotel_location(0, $hotel, "h3");
				}
			?>
		</div>
	</div>
</section>
<?php endforeach; ?>

<?php get_footer(); ?>