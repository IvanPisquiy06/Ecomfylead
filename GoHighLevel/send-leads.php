<form method='get' action='./send-leads.php'>
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
        <input type="text" id="zip" name="zip"><br>

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

	header('Content-type: application/json');
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Credentials', 'true');
	header('Access-Control-Max-Age', '60');
	header('Access-Control-Allow-Headers', 'AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2');
	header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');


	function clean($string)
	{
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

		return preg_replace('/-+/', '', $string);
	}

	var_dump($_GET);

	function data(){
		$email                   = $_GET['email'];
		$firstName               = $_GET['first_name'];
		$lastName                = $_GET['last_name'];
		$fullAddress             = $_GET['full_address'];
		$phone                   = clean($_GET['phone_home']);
		$postalCode              = $_GET['zip'];
		$provider                = $_GET['provider'];
		$propertyOwnership       = $_GET['property_ownership'];
		$roofShade               = $_GET['roof_shade'];
		$bill                    = $_GET['electric_bill'];
		$tag                     = "powered-by-solar";
		$state                   = $_GET['state'];
		$trust 					 = "https://cert.trustedform.com/d333af53323a73d33385d98c57dede33dc1c05ab";
		$ip 					 = $_GET["ip_address"];

		$apiPayload              = [
			'email'     => $email,
			'firstName' => $firstName,
			'lastName'  => $lastName,
			'phone'     => $phone,
			'state'     => $state,
			'name'      => sprintf('%s %s', $firstName, $lastName),
			'address1'  => $fullAddress,
			'postalCode' => $postalCode,
		];
		$customsFields           = [
			'BIYzW02R8F7OfXvRrNme' => $propertyOwnership,
			'kHeujw6yVJ9xmKX6Bov9' => $provider,
			'yZfzyf9HaFTOuffZZIHW' => $bill,
			'Po8omeMwGVgeXzlX1TFn' => $roofShade,
			'kHsU1RWd5rvihCB8Zicx' => $ip,
			'zG9DxHSmlfJCyFTq0Axz' => $trust,
			'H2CDVQhHPCYihd0EIAva' => "By submitting your info, you authorize us and up to 4 of our PARTNER SOLAR COMPANIES to call you and send sms messages or text messages at your number. Your consent here is not based on a condition of purchase.
			Copyright© 2023 poweredbysolar.energy. All Rights Reserved  PRIVACY POLICY || TERMS AND CONDITIONS",
			'gLS8WLpxJJ7D0xYBZO3d' => "English",
			'rsBmGcNzcek2KEsutPv4' => "poweredby.solar",
			'IBMCVuwv6YAgO7lOtL1l' => "Good",
		];


		$apiPayload['customField'] = $customsFields;

		if ($tag) {
			$apiPayload['tags'] = [$tag];
		}

		print_r($apiPayload);


		$curl = curl_init('https://rest.gohighlevel.com/v1/contacts/');

		curl_setopt($curl,CURLOPT_POST, true);
		curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($apiPayload));
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);

		curl_setopt_array($curl, [
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_HTTPHEADER     => [
				"Authorization: Bearer f9174c37-b1d6-46f3-a329-1fc18438bb7a",
				"Content-Type: application/json",
			],
		]);

		curl_close($curl);
	}

?>
