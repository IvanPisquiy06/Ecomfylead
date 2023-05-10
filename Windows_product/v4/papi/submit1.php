<?php

use Ahorrosolars\db\DB;

require '../vendor/autoload.php';

header('Content-type: application/json');

function clean($string)
{
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

	return preg_replace('/-+/', '', $string);
}

$email                   = $_POST['email_address'];
$firstName               = $_POST['first_name'];
$lastName                = $_POST['last_name'];
$fullAddress             = $_POST['full_address'];
$phone                   = clean($_POST['phone_home']);
$interestedInElectric    = $_POST['interested_in_solar_electric'];
$interestedInHotWater    = $_POST['interested_in_solar_hot_water'];
$interestedInPoolHeating = $_POST['interested_in_solar_pool_heating'];
$street                  = $_POST['street_number'];
$country                 = $_POST['country'];
$postalCode              = $_POST['postal_code'];
$provider                = $_POST['utility_provider'];
$propertyOwnership       = $_POST['property_ownership'];
$roofShade               = $_POST['roof_shade'];
$bill                    = $_POST['electric_bill'];
$tag                     = "powered-by-solar";
$state                   = $_POST['statec'];
$affid                   = $_POST['affid'];
$oid                     = $_POST['oid'];
$apiPayload              = [
	'email'     => $email,
	'firstName' => $firstName,
	'lastName'  => $lastName,
	'phone'     => $phone,
	//	'country'   => $country,
	'state'     => $state,
	'name'      => sprintf('%s %s', $firstName, $lastName),
	'address1'  => $fullAddress,

	'postalCode' => $postalCode,
];
$customsFields           = [
	'B3GKqU2XFgdhb8siAteJ' => $propertyOwnership,
	'kHeujw6yVJ9xmKX6Bov9' => $provider,
	'O2IUfZPmaPtmlHBGlKQO' => $bill,
	'tMePGVaTrWbFjYLYFJ3z' => $roofShade,
	'Bji84fMEnv49A5cdIK7j' => $affid,
	'QVkyPJzdOMdrNk39tljT' => $oid,

];


$apiPayload['customField'] = $customsFields;

if ($tag) {
	$apiPayload['tags'] = [$tag];
}
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

if ($err) {
	echo "cURL Error #:" . $err;
	file_put_contents('./log_' . date("j.n.Y") . '.log', $err, FILE_APPEND);
	die();
}
$uname = 'xjdeabwvxb';
$pass  = '9KSNnab2CA';
$host  = 'localhost';
$db    = 'xjdeabwvxb';
$db    = new DB($host, $uname, $pass, $db);

$apiPayload['propertyOwnerShip'] = $propertyOwnership;
$apiPayload['provider']          = $provider;
$apiPayload['bill']              = $bill;
$apiPayload['roofShade']         = $roofShade;
$apiPayload['affid']             = $affid;
$apiPayload['oid']               = $oid;

$msg = null;
try {
	$db->store('leads', $apiPayload);
} catch (Exception $e) {
	$msg = $e->getMessage();
	file_put_contents('./log_' . date("j.n.Y") . '.log', $msg, FILE_APPEND);
}

echo json_encode(['code' => 200, 'body' => $response, 'tag' => $tag, 'msg' => $msg]);
die();
