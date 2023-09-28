<?php
    // Template Name: Wishlist Page
?>
<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>


<?php 
	$curent_user = wp_get_current_user();
	if(isset($curent_user->data->ID)) {
		$curent_user_id = $curent_user->data->ID;
	}
	
	
	
	global $wp_ulike_class;
	$args = array(
		"user_id" 	=> $wp_ulike_class -> get_reutrn_id(),			//User ID
		"col" 		=> 'post_id',				//Table Column (post_id,comment_id,activity_id,topic_id)
		"table" 	=> 'ulike',					//Table Name
		"limit" 	=> 999,						//limit Number
	);
	
	$likes = $wp_ulike_class -> get_current_user_likes($args);
	$hotels = Array();
	$posts = Array();
	$bloggers = Array();
	$tips = Array();

	$attraction_cats = Array();
	foreach($likes as $like) {
		$like_post = get_post($like->post_id);
		if(!$like_post) continue;
		if($like_post->post_type == "attraction") {
			
			$terms = get_the_terms($like->post_id, "attraction_category");
			$term_id = "0";
			if($terms) $term_id = $terms[0] -> term_id;
			$attraction_cats[$term_id][] = $like->post_id;
		}
		if($like_post->post_type == "hotel") $hotels[] = $like->post_id;
		if($like_post->post_type == "post") $posts[] = $like->post_id;
		if($like_post->post_type == "blogger") $bloggers[] = $like->post_id;
		if($like_post->post_type == "tip") $tips[] = $like->post_id;
	}
?>
<?php if(!is_user_logged_in()) : ?>
<section class="post">
	<div class="section-inner">
		<div class="content">
			<p>אזור זה מיועד למשתמשים רשומים</p>
			<p><a href="<?=get_permalink(462)?>">התחבר למערכת</a></p>
		</div>
	</div>
</section>

<?php endif; ?>

<?php if($hotels) : ?>
<section class="wishlist-hotels">
	<div class="section-inner">
		<p class="section-title">מלונות <span>שאהבתי</span></p>
		<div class="boxes">
			<?php 
				foreach($hotels as $hotel) {
					template_box_hotel_wishlist($hotel);
				}
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if($attraction_cats) : ?>
<section class="wishlist-attractions">
	<div class="section-inner">
		<p class="section-title">אטרקציות <span>שאהבתי</span></p>

		<div class="cols">
			<?php 
				foreach($attraction_cats as $key=>$ids):
				$term = get_term($key);
			?>
				<div class="col">
					<p class="col-title">
						<span><?=$term->name?></span>
					</p>

					<div class="items">
						<?php 
							foreach($ids as $id) {
								template_wishlist_attraction_box($id);
							}
						?>
					</div>
				</div>
			<?php endforeach; ?>
			
		</div>
	</div>
</section>
<?php endif; ?>

<?php if($posts) : ?>
<section class="wishlist-posts">
	<div class="section-inner">
		<p class="section-title">מאמרים <span>שאהבתי</span></p>

		<div class="boxes">
			<?php 
				foreach($posts as $post_id) {
					template_box_post_wishlist($post_id);
				}
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if($bloggers) : ?>
<section class="wishlist-bloggers">
	<div class="section-inner">
		<p class="section-title">בלוגרים <span>שאהבתי</span></p>

		<div class="boxes">
			<?php 
				foreach($bloggers as $post_id) {
					template_box_blogger_wishlist($post_id);
				}
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if($tips) : ?>
<section class="wishlist-tips">
	<div class="section-inner">
		<p class="section-title">טיפים <span>שאהבתי</span></p>
	
		<div class="boxes">
			<?php 
				foreach($tips as $post_id) {
					template_tip_wishlist_box($post_id);
				}
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<script>
	$(document).ready(function ($) {
		
		$(".box .remove-btn").on("click", function(){
			var cont = $(this).closest(".box");
			cont.fadeOut();
		});
	});
</script>

<?php get_footer(); ?>