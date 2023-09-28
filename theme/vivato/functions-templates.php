<?php

function template_cat_box($id, $class = "") {
	$term = get_term($id);
	$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true ); 
	$image = wp_get_attachment_image_src( $thumbnail_id, 'full')[0];
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['url'];
?>	

<a class="box" href="<?=get_term_link($term);?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image ?>" alt="<?=$term->name;?>" title="<?=$term->name;?>">
		</div>
		<div class="text">
			<span><?=$term->name;?></span>
		</div>
	</div>
</a>

<?php
}

function template_post_box($id, $tag = "p") {
	$item = get_post($id);
	$size = 'thumb-post';
	if(wp_is_mobile()) $size = 'thumb-post-mobile';
	$image = get_the_post_thumbnail_url($item, $size);
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes'][$size];
?>

<a class="box box-article" href="<?=get_permalink($item)?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="text">
			<<?=$tag ?> class="title"><?=$item -> post_title?></<?=$tag ?>>
		</div>
	</div>
</a>
<?php 
}


function template_post_sidebar_box($id) {
	$item = get_post($id);
	$image = get_the_post_thumbnail_url($item, 'thumb-attraction-location');
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-attraction-location'];
?>

<a class="box box-post-sidebar" href="<?=get_permalink($item)?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="info">
			<p class="title"><?=$item -> post_title?></p>
		</div>
	</div>
</a>
<?php 
}



function template_box_post_wishlist($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);
	$image = get_the_post_thumbnail_url($item, 'thumb-post');
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-post'];
?>
<div class="box-post-wishlist box">
	<div class="inner">
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
			<div class="remove-btn cont-like">
				<img src="<?=$td?>/images/icons/trash.svg">
				<?= do_shortcode("[wp_ulike id='$id']"); ?>
			</div>
		</div>
		<a class="text" href="<?=get_permalink($item)?>">
			<p class="title"><?=$item -> post_title?></p>
		</a>
	</div>
</div>
<?php 
}


function template_post_index_box($id) {
	$item = get_post($id);
	$image = get_the_post_thumbnail_url($item, 'thumb-articles-index');
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-articles-index'];
?>
<a class="box-article-index" href="<?=get_permalink($item)?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="text">
			<p class="title"><?=$item -> post_title?></p>
		</div>
	</div>
</a>
<?php 
}

function template_location_box($id, $class = "") {
	$term = get_term($id);
	$image = get_field('image-main', $term);
	if(!$image) $image = get_field("general", 'options')['image-placeholder'];
?>	

<div class="box box-location">
	<div class="inner">
		<div class="image">
			<img src="<?=$image['sizes']['thumb-location']?>" alt="<?=$term->name;?>" title="<?=$term->name;?>">
		</div>
		<div class="text">
			<a class="title" href="<?=get_term_link($term);?>"><h2><?=$term->name;?></h2></a>
			<div class="list">
				<?php $link = "/בתי-מלון/" . $term->slug . "/"; ?>
				<a href="<?=$link;?>" class="item"><h3>בתי מלון ב<?=$term->name;?></h3></a>
				<?php $link = "/אטרקציות/" . $term->slug . "/"; ?>
				<a href="<?=$link?>" class="item"><h3>אטרקציות ב<?=$term->name;?></h3></a>
				<?php $link = "/מדריכים/" . $term->slug . "/"; ?>
				<a href="<?=$link;?>" class="item"><h3>מדריכים על <?=$term->name;?></h3></a>
				<?php $link = get_permalink(12) . "forum/" . $term->slug . "/"?>
				<a href="<?=$link;?>" class="item"><h3>פורום <?=$term->name;?></h3></a>
				<?php $link = "/טיפים/" . $term->slug . "/"; ?>
				<a href="<?=$link;?>" class="item"><h3>טיפים על <?=$term->name;?></h3></a>
			</div>
			<a href="<?=get_term_link($term);?>" class="button" href="<?=get_term_link($term);?>"> לכל המידע על <?=$term->name;?></a>
		</div>
	</div>
</div>
<?php
}

function template_location_attractions_box($id, $class = "") {
	$term = get_term($id);
	$image = get_field('image-main', $term);
	if(!$image) $image = get_field("general", 'options')['image-placeholder'];
	
	
	$sub_terms = get_terms( array(
		'taxonomy'   => 'attraction_category',
		'hide_empty' => false,
		'parent' => 0
	));
?>	

<div class="box box-location">
	<div class="inner">
		<div class="image">
			<img src="<?=$image['sizes']['thumb-location']?>" alt="<?=$term->name;?>" title="<?=$term->name;?>">
		</div>
		<div class="text">
			<?php $link_all = "/אטרקציות/" . $term->slug . "/"?>
			<a class="title" href="<?=$link_all;?>"><h2><?=$term->name;?></h2></a>
			<?php if($sub_terms) : ?>
			<div class="list">
				<?php foreach($sub_terms as $sub_term): ?>
				<?php $link = "/אטרקציות/" . $term->slug . "/" . $sub_term->slug . "/";?>
					<a href="<?=$link?>" class="item"><h3><?=$sub_term->name;?></h3></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<a href="<?=$link_all;?>" class="button" href="<?=get_term_link($term);?>">לכל האטרקציות ב<?=$term->name;?></a>
		</div>
	</div>
</div>
<?php
}

function template_attraction_box($id, $show_atts = false) {
	$item = get_post($id);
	
	$size = 'thumb-attraction';
	if(wp_is_mobile()) $size = 'thumb-post-mobile';
	
	$image = get_the_post_thumbnail_url($item, $size);
	
	$attraction_category_terms = get_the_terms($item, "attraction_category");
	if($attraction_category_terms) $attraction_category_term = $attraction_category_terms[0];
	if($attraction_category_term && !$image) $image = get_field('image-main', $attraction_category_term)['sizes'][$size] ?: "";
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes'][$size];
	
	if($show_atts) {
		$tax_list = Array('attraction_category');
		$atts = "";
		foreach($tax_list as $tax) {
			$terms = get_the_terms(get_post($id), $tax);
			if($terms) {
				$terms_ids = [];
				foreach($terms as $term) {
					$terms_ids[] = $term->term_id;
				}
				$tn = $tax;
				$str = $tn . "='" . implode(",",$terms_ids) . "' ";
				$atts .= $str;
			}
		}
	}
?>
<a class="box box-attraction" href="<?=get_permalink($item)?>" <?php if($show_atts) echo $atts;?>>
	<div class="inner">
		 <div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		 </div>
		 <div class="text">
			<p class="title"><?=$item -> post_title?></p>
			<p class="subtitle"><?=$item -> post_excerpt?></p>
		 </div>
	</div>
</a>
<?php 
}

function template_attraction_location_box($id, $tag='p') {
	$item = get_post($id);
	$image = get_the_post_thumbnail_url($item, 'thumb-attraction');
	
	
	$attraction_category_terms = get_the_terms($item, "attraction_category");
	if($attraction_category_terms) $attraction_category_term = $attraction_category_terms[0];
	if($attraction_category_term && !$image) $image = get_field('image-main', $attraction_category_term)['sizes']['thumb-attraction'] ?: "";
	
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-attraction'];
?>
<a class="box box-attraction-location" href="<?=get_permalink($item)?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="text">
			<<?=$tag?> class="title"><?=$item -> post_title?></<?=$tag?>>
			<div class="content">
				<p><?=make_short($item->post_content, 20)?></p>
			</div>
		</div>
	</div>
</a>
<?php 
}

function template_attraction_slide_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);
	$size = 'thumb-attraction-slide';
	if(wp_is_mobile()) $size = 'thumb-attraction-mobile';
	$image = get_the_post_thumbnail_url($item, $size);
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes'][$size];
	
	$location_terms = get_the_terms($item, "location");
	if($location_terms) $location_term = $location_terms[0];
?>

<a class="box-attraction-slide" href="<?=get_permalink($item)?>">
	<div class="image">
		<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
	</div>

	<div class="caption open">
		<div class="part-info">
			<?php if($location_term) : ?>
			<p class="pre-title"><?=$location_term->name?></p>
			<?php endif; ?>
			<p class="title"><?=$item -> post_title?></p>
			<div class="text">
				<p><?=make_short($item->post_content, 20)?></p>
			</div>
			<div class="button-arrow">גלה עוד</div>
		</div>
		<?php if($location_term && false) : ?>
		<div class="part-map">
			<?php $f = get_field("map", $location_term); ?> 
			<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
		</div>
		<?php endif; ?>
	</div>

	<div class="caption closed">
		<?php if($location_term) : ?>
		<p class="pre-title"><?=$location_term->name?></p>
		<?php endif; ?>
		<p class="title"><?=$item -> post_title?></p>
	</div>
</a>
<?php 
}



function template_box_hotel_index($hotel_id) {
	$td = get_template_directory_uri();
	
	$hotel_post_id = get_hotel_post_id($hotel_id);
	$hotel_post = get_post($hotel_post_id);
	
	$size = 'thumb-attraction-mobile';
	if(wp_is_mobile()) $size = 'thumb-hotel-mobile';
	
	$image_url = get_the_post_thumbnail_url($hotel_post, $size);
	$name = $hotel_post->post_title;
	$location = get_post_meta($hotel_post_id, 'location', true);
	$stars_num = get_post_meta($hotel_post_id, 'stars', true);
	$review_nr = get_post_meta($hotel_post_id, 'feedback-num', true);
	$url = get_permalink($hotel_post_id);
	$hotel_description = $hotel_post -> post_content;
?>
<a class="box-hotel-index" href="<?=$url?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image_url?>" alt="<?=$name?>" title="<?=$name?>">
		</div>
		<div class="text">
			<p class="pre-title"><?=$location?></p>
			<p class="title"><?=$name?></p>
			<div class="rating">
				<div class="stars">
					<?php 
						for($i=0; $i<$stars_num; $i++):
					?>
						<img src="<?=$td?>/images/icons/box-hotel/star.svg">
					<?php endfor; ?>
				</div>
				<p class="feedback"><?=$review_nr?> חוות דעת</p>
			</div>
			<div class="content">
				<p><?=make_short($hotel_description, 30);?></p>
			</div>
		</div>
	</div>
</a>
<?php 
}


function template_box_hotel_location($hotel_id, $post_id=null, $tag="p") {
	$td = get_template_directory_uri();
	if($post_id) $hotel_post_id = $post_id;
	else $hotel_post_id = get_hotel_post_id($hotel_id);
	$hotel_post = get_post($hotel_post_id);
	
	$size = 'thumb-hotel-rec';
	if(wp_is_mobile()) $size = 'thumb-articles-index';
	
	$image_url = get_the_post_thumbnail_url($hotel_post, $size);
	$name = $hotel_post->post_title;
	$location = get_post_meta($hotel_post_id, 'location', true);
	$stars_num = get_post_meta($hotel_post_id, 'stars', true);
	$review_nr = get_post_meta($hotel_post_id, 'feedback-num', true);
	$url = $url = get_permalink($hotel_post_id);
	$hotel_description = $hotel_post -> post_content;
?>

<a class="box box-hotel-location" href="<?=$url?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image_url?>" alt="<?=$name?>" title="<?=$name?>">
		</div>
		<div class="text">
			<div class="part-top">
				<<?=$tag?> class="title"><?=$name?></<?=$tag?>>
				<?php if($stars_num) : ?>
				<div class="stars">
					<img src="<?=$td?>/images/icons/box-hotel/star.svg">
					<span><?=$stars_num?></span>
				</div>
				<?php endif; ?>
			</div>
			<div class="content">
				<p><?=make_short($hotel_description, 30);?></p>
			</div>
		</div>
	</div>
</a>
<?php 
}


function template_box_hotel_wishlist($hotel_post_id) {
	$td = get_template_directory_uri();
	$hotel_post = get_post($hotel_post_id);
	
	$image_url = get_the_post_thumbnail_url($hotel_post, 'full');
	$name = $hotel_post->post_title;
	$location = get_post_meta($hotel_post_id, 'location', true);
	$stars_num = get_post_meta($hotel_post_id, 'stars', true);
	$review_nr = get_post_meta($hotel_post_id, 'feedback-num', true);
	$rating = get_post_meta($hotel_post_id, 'rating', true);
	$url = $url = get_permalink($hotel_post_id);
	$hotel_description = $hotel_post -> post_content;
?>

<div class="box box-hotel-wishlist">
	<div class="inner">
		<div class="image">
			<img src="<?=$image_url?>">
			<div class="remove-btn cont-like">
				<img src="<?=$td?>/images/icons/trash.svg">
				<?= do_shortcode("[wp_ulike id='$hotel_post_id']"); ?>
			</div>
		</div>
		<a class="text" href="<?=$url?>">
			<p class="title"><?=$name?></p>
			<div class="rating">
				<div class="stars">
					<?php 
						for($i=0; $i<$stars_num; $i++):
					?>
						<img src="<?=$td?>/images/icons/box-hotel/star.svg">
					<?php endfor; ?>
				</div>
				<p class="rating-num"><?=$rating?></p>
			</div>
			<p class="location"><?=$location?></p>
		</a>
	</div>
</div>
<?php 
}

function template_blogger_story_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);
	if(!$item) return;
	$image = get_the_post_thumbnail_url($item, 'thumb-blogger-story');
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-blogger-story'];
	
	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	
	$meta = get_user_meta($author_id);
	$avatar_id = $meta['user_avatar'][0];
	$avatar_url = wp_get_attachment_image_src( $avatar_id, 'thumb-cube' )[0];
	
	$date = get_the_date(get_option( 'date_format' ), $id);
	
	$location_terms = get_the_terms($item, "location");
	if($location_terms) $location_term = $location_terms[0];
?>

<div class="box box-article-blogger">
	<div class="inner">
		<?php if(isset($location_term)) : ?>
		<div class="caption-location"><?=$location_term->name?></div>
		<?php endif; ?>
		<?php if(false) : ?>
		<div class="reward">
			<img src="<?=$td?>/images/icons/reward.svg">
		</div>
		<?php endif; ?>
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="text">
			<div class="author">
				<div class="photo">
					<img src="<?=$avatar_url?>">
				</div>
				<div class="info">
					<p class="name"><?=$author_display_name?></p>
					<p class="date"><?=$date?></p>
				</div>
				
			</div>
			<p class="title"><?=$item -> post_title?></p>
			<?php 
				if($item->post_excerpt) $ex = $item->post_excerpt;
				else $ex = make_short($item->post_content, 20)
			?>
			<p class="subtitle"><?=$ex?></p>
			
			<a href="<?=get_permalink($item)?>" class="button-arrow dark">קראו עוד</a>
		</div>
	</div>
</div>
<?php 
}


function template_blogger_story_blogger_page_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);
	$image = get_the_post_thumbnail_url($item, 'thumb-blogger-story');
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-blogger-story'];
	
	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	$avatar_url = get_avatar_url($author_id);
	
	$views = pvc_get_post_views($id);
	$likes = (int)wp_ulike_get_post_likes($id);	
	$date = get_the_date(get_option( 'date_format' ), $id);
	
	$location_terms = get_the_terms($item, "location");
	if($location_terms) $location_term = $location_terms[0];
?>

<div class="box box-article-blogger">
	<div class="inner">
		<?php if(isset($location_term)) : ?>
		<div class="caption-location"><?=$location_term->name?></div>
		<?php endif; ?>
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="text">
			<div class="panel-top">
				<p class="date"><?=$date?></p>
				<div class="item">
					<img src="<?=$td?>/images/icons/eye.svg">
					<span><?=$views?></span>
				</div>
				<div class="item">
					<img src="<?=$td?>/images/icons/like.svg">
					<span><?=$likes?></span>
				</div>
			</div>

			<p class="title"><?=$item -> post_title?></p>
			<?php 
				if($item->post_excerpt) $ex = $item->post_excerpt;
				else $ex = make_short($item->post_content, 20)
			?>
			<p class="subtitle"><?=$ex?></p>
			<a href="<?=get_permalink($item)?>" class="button-arrow dark">קראו עוד</a>
		</div>
	</div>
</div>
<?php 
}


function template_blogger_story_profile_page_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);
	$image = get_the_post_thumbnail_url($item, 'thumb-blogger-story');
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-blogger-story'];
	
	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	$avatar_url = get_avatar_url($author_id);
	
	$views = pvc_get_post_views($id);
	$likes = (int)wp_ulike_get_post_likes($id);	
	$date = get_the_date(get_option( 'date_format' ), $id);
	
	$location_terms = get_the_terms($item, "location");
	if($location_terms) $location_term = $location_terms[0];
?>

<div class="box box-article-blogger">
	<div class="inner">
		<?php if(isset($location_term)) : ?>
		<div class="caption-location"><?=$location_term->name?></div>
		<?php endif; ?>
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="text">
			<div class="panel-top">
				<p class="date"><?=$date?></p>
				<div class="item">
					<img src="<?=$td?>/images/icons/eye.svg">
					<span><?=$views?></span>
				</div>
				<div class="item">
					<img src="<?=$td?>/images/icons/like.svg">
					<span><?=$likes?></span>
				</div>
			</div>

			<p class="title"><?=$item -> post_title?></p>
			<?php 
				if($item->post_excerpt) $ex = $item->post_excerpt;
				else $ex = make_short($item->post_content, 20)
			?>
			<p class="subtitle"><?=$ex?></p>
			
			<div class="buttons">
				<a class="buttton" href="<?=get_permalink($item)?>">צפיה</a>
				<a class="buttton" href="<?=get_edit_post_link($item)?>">עריכה</a>
			</div>
		</div>
		
		
	</div>
</div>
<?php 
}


function template_blogger_story_story_page_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);
	$image = get_the_post_thumbnail_url($item, 'thumb-attraction');
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-attraction'];
	
	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	$avatar_url = get_avatar_url($author_id);
	
	$views = pvc_get_post_views($id);
	$likes = (int)wp_ulike_get_post_likes($id);	
	$date = get_the_date(get_option( 'date_format' ), $id);
	
	$location_terms = get_the_terms($item, "location");
	if($location_terms) $location_term = $location_terms[0];
?>
<a class="box box-blogger-story-story-page" href="<?=get_permalink($item)?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="info">
			<div class="panel-top">
				<?php if(isset($location_term)) : ?>
				<p class="location"><?=$location_term->name?></p>
				<?php endif; ?>
				<p class="date"><?=$date?></p>
				<div class="item">
					<img src="<?=$td?>/images/icons/eye.svg">
					<span><?=$views?></span>
				</div>
				<div class="item">
					<img src="<?=$td?>/images/icons/like.svg">
					<span><?=$likes?></span>
				</div>
			</div>
			<p class="title"><?=$item -> post_title?></p>
		</div>
	</div>
</a>

<?php 
}



function template_tip_tip_page_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);

	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	$avatar_url = get_avatar_url($author_id);
	
	$views = pvc_get_post_views($id);
	$likes = (int)wp_ulike_get_post_likes($id);	
	$date = get_the_date(get_option( 'date_format' ), $id);
	
	$location_terms = get_the_terms($item, "location");
	if($location_terms) $location_term = $location_terms[0];
?>
<a class="box box-tip-tip-page" href="<?=get_permalink($item)?>">
	<div class="inner">
		<div class="info">
			<div class="panel-top">
				<?php if(isset($location_term)) : ?>
				<p class="location"><?=$location_term->name?></p>
				<?php endif; ?>
				<p class="date"><?=$date?></p>
				<div class="item">
					<img src="<?=$td?>/images/icons/eye.svg">
					<span><?=$views?></span>
				</div>
				<div class="item">
					<img src="<?=$td?>/images/icons/like.svg">
					<span><?=$likes?></span>
				</div>
			</div>
			<p class="title"><?=$item -> post_title?></p>
		</div>
	</div>
</a>

<?php 
}

function template_tip_index_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);

	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	
	
	$meta = get_user_meta($author_id);
	if(isset($meta['user_avatar'])) {
		$avatar_id = $meta['user_avatar'][0];
		$avatar_url = wp_get_attachment_image_src( $avatar_id, 'thumb-cube' )[0];
	}
	else {
		$avatar_url = get_field("general", 'options')['image-placeholder']['sizes']['thumb-cube'];
	}
	
	$rating = get_post_meta($id, 'tip-rating', true);
	$stars_num = (int)$rating;
?>

<a class="box box-tip-index" href="<?=get_permalink($item)?>">
	<div class="inner">
		<p class="title"><?=$item -> post_title?></p> 
		<div class="content">
			<p><?=make_short($item -> post_content, 20)?></p>
		</div>

		<div class="author">
			<div class="photo">
				<img src="<?=$avatar_url?>">
			</div>
			<div class="info">
				<p class="name"><?=$author_display_name?></p>
				<div class="stars">
					<?php 
						for($i=0; $i<$stars_num; $i++):
					?>
						<img src="<?=$td?>/images/icons/box-hotel/star.svg">
					<?php endfor; ?>
					<span class="date"><?=get_the_date(get_option( 'date_format' ), $item);?></span>
				</div>
			</div>
		</div>
	</div>
</a>

<?php 
}

function template_tip_inner_box($id, $tag='h3') {
	$td = get_template_directory_uri();
	$item = get_post($id);

	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	
	$meta = get_user_meta($author_id);
	if(isset($meta['user_avatar'])) {
		$avatar_id = $meta['user_avatar'][0];
		$avatar_url = wp_get_attachment_image_src( $avatar_id, 'thumb-cube' )[0];
	}
	else {
		$avatar_url = get_field("general", 'options')['image-placeholder']['sizes']['thumb-cube'];
	}
	

	
	$rating = get_post_meta($id, 'tip-rating', true);
	$stars_num = (int)$rating;
	$likes = (int)wp_ulike_get_post_likes($id);	
	
	$sublect_terms = get_the_terms($item, "tip_subject");
	if($sublect_terms) $sublect_term = $sublect_terms[0];
	
?>
<a class="box box-tip-inner" href="<?=get_permalink($item)?>" <?php if($sublect_term) echo "subject-id='".$sublect_term->term_id."'" ?>>
	<div class="inner">
		<div class="author">
			<div class="photo">
				<img src="<?=$avatar_url?>">
			</div>
			<div class="info">
				<p class="name"><?=$author_display_name?></p>
				<div class="panel-stats">
					<div class="stars">
						<?php 
							for($i=0; $i<$stars_num; $i++):
						?>
							<img src="<?=$td?>/images/icons/box-hotel/star.svg">
						<?php endfor; ?>
					</div>
					<span class="date"><?=get_the_date(get_option( 'date_format' ), $item);?></span> 
					<div class="likes">
						<img src="<?=$td?>/images/icons/like.svg">
						<span><?=$likes?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="text">
			<<?=$tag?> class="title"><?=$item -> post_title?></<?=$tag?>>
			<div class="content">
				<p><?=make_short($item -> post_content, 20)?></p>
			</div>
		</div>
	</div>
</a>
<?php 
}


function template_tip_inner_profile_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);

	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	
	$meta = get_user_meta($author_id);
	if(isset($meta['user_avatar'])) {
		$avatar_id = $meta['user_avatar'][0];
		$avatar_url = wp_get_attachment_image_src( $avatar_id, 'thumb-cube' )[0];
	}
	else {
		$avatar_url = get_field("general", 'options')['image-placeholder']['sizes']['thumb-cube'];
	}
	

	
	$rating = get_post_meta($id, 'tip-rating', true);
	$stars_num = (int)$rating;
	$likes = (int)wp_ulike_get_post_likes($id);	
	
	$sublect_terms = get_the_terms($item, "tip_subject");
	if($sublect_terms) $sublect_term = $sublect_terms[0];
	
?>
<div class="box box-tip-inner"  <?php if($sublect_term) echo "subject-id='".$sublect_term->term_id."'" ?>>
	<div class="inner">
		<div class="author">
			<div class="photo">
				<img src="<?=$avatar_url?>">
			</div>
			<div class="info">
				<p class="name"><?=$author_display_name?></p>
				<div class="panel-stats">
					<div class="stars">
						<?php 
							for($i=0; $i<$stars_num; $i++):
						?>
							<img src="<?=$td?>/images/icons/box-hotel/star.svg">
						<?php endfor; ?>
					</div>
					<span class="date"><?=get_the_date(get_option( 'date_format' ), $item);?></span> 
					<div class="likes">
						<img src="<?=$td?>/images/icons/like.svg">
						<span><?=$likes?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="text">
			<p class="title"><?=$item -> post_title?></p>
			<div class="content">
				<p><?=make_short($item -> post_content, 20)?></p>
			</div>
		</div>
		
		<div class="buttons">
			<a class="buttton" href="<?=get_permalink($item)?>">צפיה</a>
			<a class="buttton" href="<?=get_edit_post_link($item)?>">עריכה</a>
		</div>
	</div>
</div>
<?php 
}




function template_tip_wishlist_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);

	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	$avatar_url = get_avatar_url($author_id);
?>
<div class="box box-tip-wishlist">
	<div class="inner">
		<div class="remove-btn cont-like">
			<img src="<?=$td?>/images/icons/trash.svg">
			<?= do_shortcode("[wp_ulike id='$id']"); ?>
		</div>
		<div class="author">
			<div class="image">
				<img src="<?=$avatar_url?>">
			</div>
			<div class="text">
				<p class="name"><?=$author_display_name?></p>
				<p class="date"><?=get_the_date(get_option( 'date_format' ), $item);?></p>
			</div>
		</div>
		<a href="<?=get_permalink($item)?>" class="title"><?=$item -> post_title?></a>
	</div>
</div>
<?php 
}

function template_tip_location_box($id, $tag='p') {
	$td = get_template_directory_uri();
	$item = get_post($id);

	$author_id = $item->post_author;
	$author_display_name = get_the_author_meta('display_name', $author_id);
	$avatar_url = get_avatar_url($author_id);
	
	$rating = get_post_meta($id, 'tip-rating', true);
	$stars_num = (int)$rating;
?>
<a class="box box-location-tip" href="<?=get_permalink($item)?>">
	<div class="inner">
		<div class="author">
			<div class="image">
				<img src="<?=$avatar_url?>">
			</div>
			<span><?=$author_display_name?></span>
		</div>
		<div class="text">
			<<?=$tag?> class="title"><?=$item -> post_title?></<?=$tag?>>

			<div class="content">
				<p><?=make_short($item -> post_content, 20)?></p>
			</div>
		</div>
	</div>
</a>

<?php 
}
function template_forum_box($topic) {
	$u_data = get_user_by( 'id', $topic->author_id );
	$author_display_name = get_the_author_meta('display_name', $topic->author_id);
	$avatar_url = get_avatar_url($topic->author_id);
	$topic_url = get_permalink(12) . "topic/" . $topic->slug . "/";
?>
<a class="box box-forum" href="<?=$topic_url?>">
	<div class="inner">
		<div class="author">
			<div class="image">
				<img src="<?=$avatar_url?>">
			</div>
			<span><?=$author_display_name?></span>
		</div>
		<div class="text">
			<p class="title"><?=$topic->name?></p>
		</div>
	</div>
</a>
<?php 
}



function template_blogger_box($author_id) {
	$td = get_template_directory_uri();

	$author_display_name = get_the_author_meta('display_name', $author_id);
	
	$meta = get_user_meta($author_id);
	if(isset($meta['user_avatar'])) {
		$avatar_id = $meta['user_avatar'][0];
		$avatar_url = wp_get_attachment_image_src( $avatar_id, 'thumb-cube' )[0];
	}
	else {
		$avatar_url = get_field("general", 'options')['image-placeholder']['sizes']['thumb-cube'];
	}
	
	$text_about = get_user_meta($author_id, "about", true);
	$text_about = make_short($text_about, 25);
	$profession = get_user_meta($author_id, "profession", true);
	$count = get_posts_views_likes_number_of_author($author_id);
	
	$author_posts_url = get_author_posts_url($author_id);
	$author_posts_url_ar = explode("/", $author_posts_url);
	$author_slug = $author_posts_url_ar[count($author_posts_url_ar)-2];
	
	
	$blogger_url = get_home_url() . "/בלוגר/" . $author_slug . "/";
	
	
	if(!$count['posts']) return;
?>
<div class="box box-blogger" qwerty>
	<div class="inner">
		<div class="part-top">
			<div class="image">
				<img src="<?=$avatar_url?>" alt="<?=$author_display_name?>" title="<?=$author_display_name?>">
			</div>
			<div class="name">
				<p><?=$author_display_name?></p>
				<?php if(false) : ?>
				<img src="<?=$td?>/images/icons/reward.svg">
				<?php endif; ?>
			</div>
			<p class="profession"><?=$profession?></p>

			<div class="about">
				<?=$text_about?>
			</div>

			<div class="panel">
				<div class="item">
					<p class="number"><?=$count['views'];?></p>
					<p class="text">צפיות</p>
				</div>
				<div class="item">
					<p class="number"><?=$count['posts']?></p>
					<p class="text">פוסטים</p>
				</div>
				<div class="item">
					<p class="number"><?=get_followers_number_of_author($author_id);?></p>
					<p class="text">עוקבים</p>
				</div>
			</div>
		</div>

		<a href="<?=$blogger_url?>" class="button">
			<span>מעבר לבלוג</span>
		</a>
	</div>
</div>

<?php 
}


function template_box_blogger_wishlist($post_id) {
	$td = get_template_directory_uri();
	$author_id = get_field("user-id", $post_id);
	$author_display_name = get_the_author_meta('display_name', $author_id);
	$avatar_url = get_avatar_url($author_id);
	$blogger_url = add_query_arg('user_id', $author_id, get_permalink(583));
?>
<div class="box box-blogger-wishlist">
	<div class="inner">
		<div class="remove-btn cont-like">
			<img src="<?=$td?>/images/icons/trash.svg">
			<?= do_shortcode("[wp_ulike id='$post_id']"); ?>
		</div>
		<div class="image">
			<img src="<?=$avatar_url?>">
		</div>
		<a class="text" href="<?=$blogger_url?>">
			<p class="name"><?=$author_display_name?></p>
		</a>
	</div>
</div>
<?php 
}


function template_wishlist_attraction_box($id) {
	$td = get_template_directory_uri();
	$item = get_post($id);
?>
<div class="item box-wishlist-attraction box">
	<div class="remove-btn cont-like">
		<img src="<?=$td?>/images/icons/trash.svg">
		<?= do_shortcode("[wp_ulike id='$id']"); ?>
	</div>
	<a class="inner " href="<?=get_permalink($item)?>">
		
		<p class="title"><?=$item -> post_title?></p>
		<p class="subtitle"><?=$item -> post_excerpt?></p>
	</a>
</div>
<?php 
}



function template_hotel_search_box($item, $cur_location_term_id, $currency=null, $tag='p') {
	$td = get_template_directory_uri();
	
	/*
	$hpi = get_hotel_post_id($item->hotel_id, true, $cur_location_term_id);
	$city_id = get_post_meta( $hpi, 'city_id', true );
	city_id_to_term($city_id, $cur_location_term_id);
	*/
	
	
	$image_url = $item -> max_photo_url;
	$image_url = str_replace("max1280x900", "max340", $image_url);
	
	$stars = "";
	if(isset($item -> booking_home -> quality_class)) $stars = $item -> booking_home -> quality_class;
	elseif(isset($item -> class)) $stars = $item -> class;
	
	$url = "";
	$hotel_post_id = get_hotel_post_id($item->hotel_id, false);
	if($hotel_post_id) $url = get_permalink($hotel_post_id);
	elseif(isset($item->hotel_id)) $url = add_query_arg ('hotel_id', $item->hotel_id, get_permalink(279)) ;
	
	$location_ex = "";
	if(isset($item -> city)) $location_ex .= $item -> city;
	if(isset($item -> address)) {
		if($location_ex) $location_ex .= ", ";
		$location_ex .= $item -> address;
	}
	
	$price = $item -> price_breakdown -> gross_price;
	if($currency) $price = (float)$price * $currency['rate'];

	$cur = $item -> price_breakdown -> currency;
	if($currency) $cur = $currency['cur'];
	
?>
<a class="box box-hotel" href="<?=$url;?>">
	<div class="inner">
		<div class="image">
			<div class="wrapper-image">
				<img src="<?=$image_url?>" alt="<?=$item -> hotel_name_trans;?>" title="<?=$item -> hotel_name_trans;?>">
			</div>
		</div>
		<div class="text">
			<div class="part-top">
				<div class="info">
					<<?=$tag?> class="title"><?=$item -> hotel_name_trans;?></<?=$tag?>>
					<p class="location">
						<?php if(isset($item -> distance_to_cc)) : ?>
							<?=$item -> distance_to_cc;?> ק״מ ממרכז העיר
						<?php endif; ?>,
						<?=$location_ex ?>
					</p>
				</div>
				<div class="rating"> 
					<div class="box-stars">
						<?php 
							if($stars) : 
							$stars_num = (int)$stars;
						?>
						<div class="stars">
							<?php 
								for($i=0; $i<$stars_num; $i++):
							?>
								<img src="<?=$td?>/images/icons/box-hotel/star.svg">
							<?php endfor; ?>
						</div>
						<?php endif; ?>
						<?php if(isset($item -> review_nr)) : ?>
							<p class="feedback"><?=$item -> review_nr;?> חוות דעת</p>
						<?php endif; ?>
					</div>
					<?php if(isset($item -> review_score)) : ?>
						<div class="box-number">
							<p><?=$item -> review_score;?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="description">
				<p><?=$item -> unit_configuration_label;?></p>
			</div>
			<?php if(isset($item -> price_breakdown)) : ?>
			<div class="wrapper-price">
				<p class="price">
					<span class="cur">מחיר ב Booking</span>
					<Br>
					<?php if($price) : ?>
					<span class="num"><?=$price?></span>
					<?php endif; ?>
					<?php if(isset($cur)) : ?>
					<span class="cur"><?=$cur?></span>
					<?php endif; ?>
				</p>
			</div>
			<?php endif; ?>
			<?php if(isset($item -> urgency_message)) : ?>
				<p class="urgency_message"><?=$item -> urgency_message;?></p>
			<?php endif; ?>
			<?php if(isset($item -> ribbon_text)) : ?>
				<p class="ribbon_text"><?=$item -> ribbon_text;?></p>
			<?php endif; ?>
		</div>
	</div>
</a>
<?php 
}



function template_search_box($id) {
	$item = get_post($id);
	$image = get_the_post_thumbnail_url($item, 'thumb-attraction-location');
	if(!$image) $image = get_field("general", 'options')['image-placeholder']['sizes']['thumb-attraction-location'];
	if($item->post_excerpt) $short = $item->post_excerpt;
	else $short = make_short($item->post_content, 20);
	
	$post_type = get_post_type($item->ID);
	$post_type_data = get_post_type_object( $post_type );
	$post_type_text = $post_type_data->labels->singular_name;
?>

<a class="box box-search-result" href="<?=get_permalink($item)?>">
	<div class="inner">
		<div class="image">
			<img src="<?=$image?>" alt="<?=$item -> post_title?>" title="<?=$item -> post_title?>">
		</div>
		<div class="text">
			<p class="title"><?=$item -> post_title?> <span class="type">[<?=$post_type_text?>]</span></p>
			<p class="description"><?=$short?></p>
		</div>
	</div>
</a>
<?php 
}