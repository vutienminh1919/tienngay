<?php

namespace App\Service\Auth;

use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;

class Authorization
{

	public static function generateToken($data)
	{
		$key = env('JWT_KEY');
		$algorithm = env('JWT_ALGORITHM');
		return JWT::encode($data, $key);
	}

	public static function validateToken($token)
	{
		$key = env('JWT_KEY');
		$algorithm = env('JWT_ALGORITHM');
		try {
			$decoded = JWT::decode($token, $key, array($algorithm));
			return $decoded;
		} catch (Exception $e){
			return false;
		}
	}

}
