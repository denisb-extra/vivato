<?php
    // Template Name: Registration Page
?>

<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>



<section class="registration wpuf-form">
	<div class="section-inner">
		<p class="section-title white centered">הרשמה לאתר</p>
		<div class="part-top">
			<p class="section-title white centered"><?=get_field('title')?></p>
			<div class="content white">
				<?=get_field('content-top')?>
			</div>
		</div>
		<div class="content">
			<?=get_field('content')?>
		</div>
	</div>
</section>
	
<?php get_footer(); ?>