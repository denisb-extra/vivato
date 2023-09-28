<?php 

$curl = curl_init();
$request_data = http_build_query($request_data_raw);

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

echo '<pre style="direction:ltr">';
print_r($response_objec);
echo '</pre>';


?>
