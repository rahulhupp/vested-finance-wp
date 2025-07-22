<?php 

function us_stocks_get_token() {
	// error_log("Store Token API Call");
	try {
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://vested-api-staging.vestedfinance.com/get-partner-token',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'partner-id: 7bcc5a97-3a00-45f0-bb7d-2df254a467c4',
				'partner-key: 4b766258-6495-40ed-8fa0-83182eda63c9',
				'lead-token-access: true'
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		return $response;
	} catch (\Throwable $th) {
		throw $th;
	}
}
