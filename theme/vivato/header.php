<?php $td = get_template_directory_uri(); ?>
<!DOCTYPE html>
<html lang="he-IL">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='shortcut icon' type='image/x-icon' href='<?=$td?>/images/favicon.ico' />
	
	
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-PSXWSGJ');</script>
	<!-- End Google Tag Manager -->
	<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '675013311171856'); 
fbq('track', 'PageView');
</script>
<noscript>
<img height="1" width="1" 
src="https://www.facebook.com/tr?id=675013311171856&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
	<meta name="facebook-domain-verification" content="y9l62kfa5njih2bntwgx9495l61eoe" />
	<?php wp_head(); ?> 
</head>

<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PSXWSGJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<main>
<header class="<?php if(is_front_page()) echo "home" ?>">
	<div class="header-inner">

		<a class="logo" href="<?=get_home_url();?>/">
			<?php 
				$f = get_field('header', 'options')['logo-home'];
				$f2 = get_field('header', 'options')['logo'];
				if(is_front_page() && !wp_is_mobile()) :
			?> 
				<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>" class="white">
				<img src="<?=$f2["url"]?>" alt="<?=$f2["alt"]?>" title="<?=$f2["title"]?>" class="main">
			<?php else : ?>
			<img src="<?=$f2["url"]?>" alt="<?=$f2["alt"]?>" title="<?=$f2["title"]?>">
			<?php endif; ?>
		</a>

		<?php 
			$args = array(
				'theme_location'  => 'top-menu',
				'container_class' => 'menu-cont',
				'menu_class'      => 'main-menu',
			);
			wp_nav_menu( $args );
		?>
		

		<div class="part-left">
			<div class="links">
				<?php 
					$items = get_field('header', 'options')['links'];
					foreach($items as $item):
				?>
					<a href="<?=$item["url"];?>" class="link">
						<div class="icon">
							<?php $f = $item['icon']; ?> 
							<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
						</div>
						<p class="text"><?=$item["text"];?></p>
					</a>
				<?php endforeach; ?>
					<?php 
						$user = wp_get_current_user();
		
						$profile_text = "";
						$profile_url = "";
						
						if(isset($user->data->ID)) {
							$profile_url = get_permalink(44);
							$profile_text = $user->data->user_nicename;
						}
						else {
							$profile_url = get_permalink(462);
							$profile_text = "התחבר";
						}
					?>
					
				<div class="link search">
					<div class="button">
						<div class="icon">
							<img src="<?=$td?>/images/icons/header/search.svg" alt="Search" title="Search">
						</div>
						<p class="text">חיפוש</p>
					</div>
					<div class="search-box">
						<?=do_shortcode('[ivory-search id="1811" title="Custom Search Form"]');?>
					</div>
				</div>
					
				<a href="<?=$profile_url;?>" class="link">
					<div class="icon">
						<img src="<?=$td?>/images/icons/header/profile.svg" alt="Profile" title="Profile">
					</div>
					<p class="text"><?=$profile_text;?></p>
				</a>
			</div>
		</div>
		<div class="ham-button">
		</div>
		<?php 
			$args = array(
				'theme_location'  => 'mobile-menu',
				'container_class' => 'mobile-menu-cont',
				'menu_class'      => 'mobile_menu',
			);
			wp_nav_menu( $args );
		?>
		
	</div>
</header>
