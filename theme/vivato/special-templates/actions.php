<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php if(isset($wp_query->query_vars['action'])) : ?>

<?php if($wp_query->query_vars['action'] == 'update-rates') : ?>
<?php 
	$curl = curl_init();
	$url = "https://boi.org.il/PublicApi/GetExchangeRates?asXml=false";

	curl_setopt_array($curl, [
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => [],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
		return;
	} else {
		$response_object = json_decode($response);
	}

	if($response_object) {
		$post_id = 4127;
		
		$coins = get_field('coins', $post_id );
		$i = -1;
		foreach($coins as $coin) {
			$i++;
			foreach($response_object -> exchangeRates as $item) {
				if($coin['id'] == $item->key){
					update_post_meta( $post_id, 'coins_'.$i.'_rate', $item->currentExchangeRate);
				}
			}
		}
		
	}
	
	
	$message = get_field("updates", $post_id);
	$message .= "\n" . "Updated on " . date("Y-m-d h:i");
	update_post_meta( $post_id, 'updates', $message);
	
	
?>

<?php endif; ?>

<?php endif; ?>
<?php get_footer(); ?>