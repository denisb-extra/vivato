<?php
    // Template Name: Page with banners
?>
<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="page-with-banners">
	<div class="section-inner">
		<div class="parts">
			<div class="part part-main">
				<div class="content">
					<?php the_content(); ?>
				</div>
			</div>
			<?php if(get_field('banners')) : ?>
			<div class="part part-sidebar">
				<div class="banners">
					<?php 
						$items = get_field('banners');
						foreach($items as $item):
					?>
						<a class="banner" href="<?=$item['url']?>" >
							<div class="inner">
								<?php 
									$f = $item['image-desktop']; 
									if(wp_is_mobile() && $item['image-mobile']) $f = $item['image-mobile']; 
								?> 
								<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		
	</div>
</section>

<?php get_footer(); ?>