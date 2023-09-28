<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title;
	$page_title = "404";
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="post">
	<div class="section-inner">
		<div class="content">
			<p>עמוד לא נמצא במערכת</p>
			<p>חזרה ל <a href="<?=get_home_url();?>">עמוד הבית</a></p>
		</div>
	</div>
</section>
	
<?php get_footer(); ?>