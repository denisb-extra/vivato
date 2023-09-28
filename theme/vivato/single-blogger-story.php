<?php $td = get_template_directory_uri(); ?>

<?php 
	$location_terms = get_the_terms($post, "location");
	if($location_terms) {
		$location_term = $location_terms[0];
		global $g_location_term;
		$g_location_term = $location_term;
	}
?>
<?php 
	$author_id = $post->post_author;
	$id = $post->ID;
	
	$author_display_name = get_the_author_meta('display_name', $author_id);
	
	$meta = get_user_meta($author_id);
	$avatar_id = $meta['user_avatar'][0];
	$avatar_url = wp_get_attachment_image_src( $avatar_id, 'thumb-cube' )[0];
	
	

	$curent_user = wp_get_current_user();
	if(isset($curent_user->data->ID)) {
		$curent_user_id = $curent_user->data->ID;
		$am_i_following_author = am_i_following_author($curent_user_id , $author_id);
		if($am_i_following_author) $button_text = "עוקב";
		else $button_text = "עקבו אחריי";
	}
	
	$views = pvc_get_post_views($post->ID);
	$likes = (int)wp_ulike_get_post_likes($post->ID);	
	$date = get_the_date(get_option( 'date_format' ), $post->ID);
	$blogger_post_id = get_blogger_post_id($author_id);
	
	$author_posts_url = get_author_posts_url($author_id);
	$author_posts_url_ar = explode("/", $author_posts_url);
	$author_slug = $author_posts_url_ar[count($author_posts_url_ar)-2];
	
	
	$blogger_url = get_home_url() . "/בלוגר/" . $author_slug . "/";

	global $my_bradcrumbs;
	$my_bradcrumbs = [];
	$my_bradcrumbs[] = array(
		'url' => get_home_url(),
		'text' => 'בית',
	);
	$my_bradcrumbs[] = array(
		'url' => get_permalink(16),
		'text' => 'בלוג מטיילים',
	);

	$my_bradcrumbs[] = array(
		'url' => $blogger_url,
		'text' => "הבלוג של " . $author_display_name,
	);
	
	$my_bradcrumbs[] = array(
		'url' => '',
		'text' => $post->post_title,
	);
	
	
?>


<?php get_header(); ?>

<?php 
	global $page_title;
	$page_title = "בלוג";
	get_template_part( 'template-parts/top-inner' );
?>

<section class="story">
	<div class="section-inner">
		<div class="parts">
			<div class="part part-main">
				<h1 class="section-title"><?=hl_last_word($post->post_title)?></h1>
				
				<?php require get_template_directory() . '/inc/edit-post-button.php';?>
				
				<div class="content">
					<?php 
						the_content();
					?>
					
				</div>
				
				<?php 
					require get_template_directory() . '/inc/panel-like-share.php';
				?>
			</div>
			<div class="part part-sidebar">
				<div class="pannel-blogger">
					<a class="image" href="<?=$blogger_url?>">
						<img src="<?=$avatar_url?>" alt="<?=$author_display_name?>" title="<?=$author_display_name?>">
					</a>
					<div class="info">
						<div class="part-top">
							<a class="title" href="<?=$blogger_url?>"><?=$author_display_name?></a>
							<div class="reward">
								<img src="<?=$td?>/images/icons/prize.svg">
							</div>
							<?php if(is_user_logged_in()) : ?>
							<div class="button-follow cont-like">
								<?= do_shortcode("[wp_ulike id='$blogger_post_id']"); ?>
								<span>עקבו אחריי</span>
							</div>
							<?php else : ?>
								<a class="button-follow" href="<?=get_permalink(462)?>">
									<img src="<?=$td?>/images/icons/heart-empty.svg">
									<span>עקבו אחריי</span>
								</a>
							<?php endif; ?>
						</div>
						<div class="part-bottom">
							<p class="date"><?=$date?></p>
							<div class="item">
								<img src="<?=$td?>/images/icons/eye.svg">
								<span><?=$views;?></span>
							</div>
							<div class="item">
								<img src="<?=$td?>/images/icons/like.svg">
								<span><?=$likes?></span>
							</div>
						</div>
					</div>
				</div>

				<p class="title-articles">כתבות נוספות של <?=$author_display_name?></p>

				<div class="boxes">
					<?php 
						$args = Array(
							'post_type' => 'blogger-story',
							'numberposts' => -1,
							'author' =>  $author_id,
							'fields' => 'ids',
							'post__not_in'   => array( get_the_ID() ),
						);
						
						$items = get_posts($args);
						foreach($items as $item) {
							template_blogger_story_story_page_box($item);
						}
					?>	
				</div>
			</div>
		</div>
	</div>
</section> 


<section class="comments">
	<div class="decor">
		<img src="<?=$td?>/images/inner/decor/decor-comments.png">
	</div>
	<div class="section-inner">
		<p class="section-title">תגובות <span>גולשים</span></p>
		<div class="content">
			<?php comments_template(); ?>
		</div>
	</div>
</section>

<section class="blogger-stories">
	<div class="section-inner">
		<p class="section-title centered">עוד <span>מהבלוג</span></p>
		<div class="boxes">
			<?php 
				$args = Array(
					'post_type' => 'blogger-story',
					'numberposts' => -1,
					'author' =>  $author_id,
					'fields' => 'ids',
					'post__not_in'   => array( get_the_ID() ),
				);
				
				$items = get_posts($args);
				foreach($items as $item) {
					template_blogger_story_box($item);
				}
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>