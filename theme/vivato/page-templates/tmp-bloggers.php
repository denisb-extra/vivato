<?php
    // Template Name: Bloggers Page
?>
<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="bloggers">
		<div class="decor">
			<img src="<?=$td?>/images/inner/decor/decor-comments.png">
		</div>
		<div class="section-inner">
			<h2 class="section-title centered">בלוגרים <span>מובילים</span></h2>
			<div class="boxes">
				<?php 
					$args = array(
						'role'    => 'blogger',
					);
					$users = get_users( $args );
					foreach($users as $user) {
						template_blogger_box($user->data->ID);
					}

				?>
			</div>
			
			<div class="wrapper-button">
				<a href="<?=get_permalink(401);?>" class="button-icon">
					<div class="inner">
						<img src="<?=$td?>/images/icons/attraction/fav.svg">
						<span>הרשם לאתר כבלוגר</span>
					</div>
				</a>
			</div>
		</div>
	</section>

	<section class="blogger-stories">
		<div class="section-inner">
			<h2 class="section-title centered">כתבות מומלצות מהבלוג <span>שלנו</span></h2>
			<div class="boxes">
				<?php 
					$items = get_field('articles');
					foreach($items as $item) {
						template_blogger_story_box($item);
					}
				?>
			</div>
		</div>
	</section>

<?php get_footer(); ?>