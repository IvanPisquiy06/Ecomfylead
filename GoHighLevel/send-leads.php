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

$email                   = $_POST['email'];
$firstName               = $_POST['first_name'];
$lastName                = $_POST['last_name'];
$fullAddress             = $_POST['full_address'];
$phone                   = clean($_POST['phone_home']);
$postalCode              = $_POST['zip'];
$provider                = $_POST['provider'];
$propertyOwnership       = $_POST['property_ownership'];
$roofShade               = $_POST['roof_shade'];
$bill                    = $_POST['electric_bill'];
$tag                     = "powered-by-solar";
$state                   = $_POST['state'];
$trust = $_POST['xxTrustedFormCertUrl'];
$ip = $_POST["ip_address"];

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

echo $apiPayload;


$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL            => "https://rest.gohighlevel.com/v1/contacts/",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING       => "",
	CURLOPT_MAXREDIRS      => 10,
	CURLOPT_TIMEOUT        => 30,
	CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST  => "POST",
	CURLOPT_POSTFIELDS     => json_encode($apiPayload),
	CURLOPT_HTTPHEADER     => [
		"Authorization: Bearer f9174c37-b1d6-46f3-a329-1fc18438bb7a",
		"Content-Type: application/json",
	],
]);

$response = curl_exec($curl);
$err      = curl_error($curl);

curl_close($curl);