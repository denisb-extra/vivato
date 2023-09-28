<?php
    // Template Name: About Page
?>
<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>


<section class="about">
	<div class="section-inner">
		<div class="parts ai-center">
			<div class="part">
				<div class="content">
					<?=get_field('text-1')?>
				</div>
			</div>
			<div class="part">
				<div class="image centered">
					<?php $f = get_field('logo'); ?> 
					<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
				</div>
			</div>
		</div>

		<div class="parts ai-center">
			<div class="part">
				<div class="image-shadow">
					<?php $f = get_field('image'); ?> 
					<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
				</div>
			</div>
			<div class="part">
				<div class="content">
					<?=get_field('text-2')?>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="plan">
	<div class="section-inner">
		<div class="wrapper-content">
			<p class="section-title"><?=get_field('section-about', 2)['title']?></p>

			<div class="boxes">
				<?php 
					$items = get_field('section-about', 2)['advantages'];
					foreach($items as $item):
				?>
					<div class="box box-plan">
						<div class="inner">
							<div class="icon">
								<?php $f = $item['icon']; ?> 
								<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
							</div>
							<p class="title"><?=$item['title']?></p>
							<div class="content">
								<?=$item['text']?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>