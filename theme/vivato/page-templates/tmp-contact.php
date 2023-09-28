<?php
    // Template Name: Contact Page
?>

<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="contact">
	<div class="decor">
		<img src="<?=$td?>/images/inner/decor/contact.png" />
	</div>
	<div class="section-inner">
		<div class="parts ai-center">
			<div class="part part-form">
				<p class="section-title"><?=get_field('title-1')?></p>
				<p class="subtitle"><?=get_field('title-2')?></p>
				<p class="section-subtitle"><?=get_field('title-3')?></p>

				<?=do_shortcode('[contact-form-7 id="'.get_field('contact-form').'" title="טופס בעמוד צור קשר"]');?>
			</div>
			<div class="part part-info">
				<p class="section-title small"><?=get_field('title-4')?></p>
				<div class="content">
					<?=get_field("text");?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="image-wide">
	<img src="<?=$td?>/images/index/gal.png" />
</section>
<?php get_footer(); ?>