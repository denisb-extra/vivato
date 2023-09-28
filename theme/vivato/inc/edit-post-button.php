<?php if(current_user_can( 'edit_post', $post->ID )) : ?>
<br>
<a href="<?=get_edit_post_link($post)?>" class="button-icon">
	<div class="inner">
		<img src="<?=$td?>/images/icons/attraction/pencil.svg">
		<span>עריכה</span>
	</div>
</a>
<?php endif; ?>