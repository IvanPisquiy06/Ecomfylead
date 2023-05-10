<?php

namespace Ahorrosolars\db;

use Exception;
use mysqli;

class DB {
	private $connection;

	public function __construct( $host, $uname, $pass, $dbname ) {
		$mysqli = new mysqli( $host, $uname, $pass, $dbname );

		// Check connection
		if ( $mysqli->connect_errno ) {
			echo "Failed to connect to MySQL: " . $mysqli->connect_error;
			file_put_contents('./log_'.date("j.n.Y").'.log', $mysqli->connect_error, FILE_APPEND);

			exit();
		}

		$this->connection = $mysqli;
	}

	/**
	 * @throws Exception
	 */
	public function store( $table, $data ) {
		try {
			$query = "Insert into $table (email,first_name,last_name,phone,full_name,address,postal_code,owner,provider,bill,roof_shade,tag,state,created_at,oid,affid) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			// prepare and bind
			$stmt = $this->connection()->prepare( $query );

			$stmt->bind_param( "ssssssssssssssss",
				$email,
				$firstName,
				$lastName,
				$phone,
				$fullName,
				$address,
				$postalCode,
				$owner,
				$provider,
				$bill,
				$roofShade,
				$tag,
				$state,
				$now,
				$oid,
				$affid );


// set parameters and execute
			$email     = $data['email'];
			$firstName = $data['firstName'];
			$lastName  = $data['lastName'];
			$phone     = $data['phone'];
//	'country'   => $country;
			$fullName = sprintf( ' % s % s',
				$data['firstName'],
				$data['lastName'] );
			$address  = $data['address'];

			$postalCode = $data['postalCode'];
			$owner      = $data['propertyOwnerShip'];
			$provider   = $data['provider'];
			$bill       = $data['bill'];
			$roofShade  = $data['roofShade'];
			$state      = $data['state'];
			$tag        = $data['tags'];
			$now        = date( 'Y-m-d H:i:s' );
			$oid        = $data['oid'];
			$affid      = $data['affid'];
			$stmt->execute();
		} catch ( Exception $exception ) {
			throw new Exception( $exception->getMessage() );
		}


	}

	public function connection() {
		return $this->connection;
	}


}

