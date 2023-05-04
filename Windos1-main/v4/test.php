<form method='get' action='./test.php'>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>

        <label for="first_name">First name:</label>
        <input type="text" id="first_name" name="first_name"><br>

        <label for="last_name">Last name:</label>
        <input type="text" id="last_name" name="last_name"><br>

        <label for="full_address">Full Address:</label>
        <input type="text" id="full_address" name="full_address"><br>

        <label for="phone_home">Phone:</label>
        <input type="tel" id="phone_home" name="phone_home"><br>

        <label for="zip">Zip code:</label>
        <input type="text" id="zip" name="zip_code"><br>

        <label for="provider">Provider:</label>
        <input type="text" id="provider" name="provider"><br>

        <label for="property_ownership">Do you own a house?:</label>
        <input type="text" id="property_ownership" name="property_ownership"><br>

        <label for="roof_shade">Roof shade:</label>
        <input type="text" id="roof_shade" name="roof_shade"><br>

        <label for="electric_bill">Monthly Electric Bill:</label>
        <input type="text" id="electric_bill" name="electric_bill"><br>

        <label for="state">State:</label>
        <input type="text" id="state" name="state"><br>

        <label for="state">IP address:</label>
        <input type="text" id="ip_address" name="ip_address"><br>

        <input type="submit" value="Enviar" name="enviar">
</form>

<?php
    // API endpoint URL
    $urlPing = 'https://leads-inst338-client.phonexa.com/ping/';

    $provider = $_GET['provider'];
    $ownHome = $_GET['property_ownership'];
    $address = $_GET['full_address'];
    $zip = $_GET['zip_code'];
    $monthlyBill = $_GET['electric_bill'];
    $roofShade = $_GET['roof_shade'];

    // Data to send to the API
    $data = array(
        'apiId' => '2104CDAB524B4FF0AD65526E286DA5DC',
        'apiPassword' => 'd27589572',
        'productId' => '177',
        'trustedForm' => 'https://cert.trustedform.com/f886071...',
        'jornayaLeadId' => '12345678-1234-1234-1234-123456789012',
        'tcpa' => $ownHome,
        'tcpaLanguage' => "I agree to Terms, Privacy, and consent to solar/home servicers to send marketing prerecorded messages and autodialed calls/texts to my phone number above even if it's on any do not call list. Consent is not a condition of purchase. You can opt-out at any time (see Terms). Message/data rates may apply.",
        'webSiteUrl' => 'https://gogreenandsave.net/',
        'urlConsent' => 'https://gogreenandsave.net/',
        'address' => $address,
        'zip' => $zip,
        'city' => '',
        'state' => '',
        'ownHome' => $ownHome,
        'bestCallTime' => 'Any Time',
        'utilityProvider' => $provider,
        'monthlyBill' => $monthlyBill,
        'propertyType' => 'OTHER',
        'roofType' => 'UNSURE_OTHER',
        'roofShade' => $roofShade,
        'creditRating' => 'FAIR',
        'purchaseTimeFrame' => 'OTHER',
        'userIp' => '64.60.147.1',
        'projectType' => 'NEW',
        'solarSystemType' => 'ELECTRICITY',
    );

    $dataJson = json_encode($data);

    echo $dataJson;

    // Initialize cURL
    $curl = curl_init();

    // Set cURL options
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_URL, $urlPing);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json"
	));

    curl_setopt_array($curl, [
		CURLOPT_ENCODING       => "",
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_TIMEOUT        => 60,
		CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1
	]);

    // Send the request
    $response = curl_exec($curl);

    if (curl_errno($curl)) {
		echo 'Curl error: ' . curl_error($curl);
	} else {
		// Get the HTTP response code
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	
		// Check for API errors
		if ($httpCode >= 400) {
			echo 'API error: ' . $response;
		} else {
			// Print the response
			echo $response;
		}
	}

    // Close cURL
    curl_close($curl);

    $urlPost = 'https://leads-inst338-client.phonexa.com/post/';

    $jsonPromise = json_decode($response);
    $promise = $jsonPromise->promise;
    $firstName = $_GET['first_name'];
    $lastName = $_GET['last_name'];
    $email = $_GET['email'];
    $phone = $_GET['phone_home'];
    
    // Data to send to the API
    $data = array(
        'promise' => $promise,
        'apiId' => '2104CDAB524B4FF0AD65526E286DA5DC',
        'apiPassword' => 'd27589572',
        'productId' => '177',
        'trustedForm' => 'https://cert.trustedform.com/f886071...',
        'jornayaLeadId' => '12345678-1234-1234-1234-123456789012',
        'tcpa' => $ownHome,
        'tcpaLanguage' => "I agree to Terms, Privacy, and consent to solar/home servicers to send marketing prerecorded messages and autodialed calls/texts to my phone number above even if it's on any do not call list. Consent is not a condition of purchase. You can opt-out at any time (see Terms). Message/data rates may apply.",
        'webSiteUrl' => 'https://gogreenandsave.net/',
        'urlConsent' => 'https://gogreenandsave.net/',
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'homePhone' => '',
        'mobilePhone' => $phone,
        'address' => $address,
        'zip' => $zip,
        'city' => '',
        'state' => '',
        'ownHome' => $ownHome,
        'bestCallTime' => 'Any Time',
        'utilityProvider' => $provider,
        'monthlyBill' => $monthlyBill,
        'propertyType' => 'OTHER',
        'roofType' => 'UNSURE_OTHER',
        'roofShade' => $roofShade,
        'creditRating' => 'FAIR',
        'purchaseTimeFrame' => 'OTHER',
        'userIp' => '64.60.147.1',
        'projectType' => 'NEW',
        'solarSystemType' => 'ELECTRICITY',
    );

    $dataJsonPost = json_encode($data);

    echo $dataJsonPost;

    // Initialize cURL
    $curlPost = curl_init();

    // Set cURL options
    curl_setopt($curlPost, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curlPost, CURLOPT_URL, $urlPost);
    curl_setopt($curlPost, CURLOPT_POST, true);
    curl_setopt($curlPost, CURLOPT_POSTFIELDS, $dataJsonPost);
    curl_setopt($curlPost, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlPost, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json"
    ));

    curl_setopt_array($curlPost, [
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1
    ]);

    // Send the request
    $responsePost = curl_exec($curlPost);

    if (curl_errno($curlPost)) {
        echo 'Curl error: ' . curl_error($curlPost);
    } else {
        // Get the HTTP response code
        $httpCode = curl_getinfo($curlPost, CURLINFO_HTTP_CODE);
    
        // Check for API errors
        if ($httpCode >= 400) {
            echo 'API error: ' . $responsePost;
        } else {
            // Print the response
            echo $responsePost;
        }
    }

    // Close cURL
    curl_close($curlPost);

?>