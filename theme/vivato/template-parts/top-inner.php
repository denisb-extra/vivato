<?php $td = get_template_directory_uri(); ?>

<?php
	global $page_title;
	global $page_title_h1;
	
	if(!$page_title && isset(get_queried_object() -> name)) $page_title = get_queried_object() -> name;
	if(!$page_title && isset($post->post_title)) $page_title = $post->post_title;
	if(!$page_title) $page_title = get_the_title();
	
	$style = "background-image:url(" . $td . "/images/inner/bg-top.jpg)";
	if(wp_is_mobile()) $style = "background-image:url(" . $td . "/images/inner/bg-top-m.jpg)";
	global $g_location_term;
	if($g_location_term) {
		if(get_field("image-header", $g_location_term)) {
			$img = get_field("image-header", $g_location_term);
			$style = "background-image:url(" . $img['url'] . ")";
			if(wp_is_mobile()) $style = "background-image:url(" . $img['sizes']['thumb-location'] . ")";
		}
	}
?>



<?php if(is_singular('attraction') || is_singular('hotel') || get_cur_template() == "tmp-single-hotel.php") : ?>
<section class="top-inner-attraction">
	<div class="section-inner">
		<div class="breadcrumbs">
			<?php
				if ( function_exists('yoast_breadcrumb')) {
					yoast_breadcrumb( '' );
				}
			?>
		</div>
	</div>
</section>
<?php else : ?>
<section class="top-inner" style="<?=$style?>">
	<div class="section-inner">
		<?php if($page_title_h1): ?>
			<h1 class="title"><span><?=$page_title?></span></h1>
		<?php else: ?>
			<p class="title"><span><?=$page_title?></span></p>
		<?php endif; ?>

		<div class="breadcrumbs">
			<?php
				if ( function_exists('yoast_breadcrumb')) {
					yoast_breadcrumb( '' );
				}
			?>
		</div>
	</div>
</section>
<?php endif; ?>