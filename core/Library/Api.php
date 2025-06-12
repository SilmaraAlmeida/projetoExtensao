<?php

namespace Core\Library;

use Core\Library\Response;
use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Api extends ControllerMain
{
    private static $encrypt_type = 'HS256';
    private static $token_expiration = 180; // segundos

    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarconstruct();
    }

    /**
     * generateToken
     *
     * @return void
     */
    public static function generateToken()
    {
        $headers    = getallheaders();
        $email      = $headers['email'] ?? '';
        $key        = str_replace("Bearer ", "", $headers['authorization'] ?? '');

        if (empty($key)) {
            $key        = str_replace("Bearer ", "", $headers['Authorization'] ?? '');
        }

        if ($key !== $_ENV['API_KEY']) {
            return Response::json([
                'status' => 401,
                'message' => "Key inválido ou ausente.",
            ]);
        } 

        $payload = [
            'iat' => time(),
            'exp' => time() + (self::$token_expiration * 60),
            "sub" => $key,
            "email" => $email
        ];

        return Response::json([
            'status' => 201,
            'message' => "Token gerado com sucesso.",
            'data' => [
                'token' => JWT::encode($payload, $_ENV['API_SECRET_KEY'], self::$encrypt_type),
                "expires_in" => (3 * 60),
                "token_type" => "Bearer",
                "issued_at" => $payload['iat'],
                "expires_at" => $payload['exp'],
            ],
        ]);
    }

    /**
     * validateToken
     *
     * @return json
     */
    public static function validateToken()
    {
        $headers    = getallheaders();
        $token      = $headers['Authorization'] ?? '';
        $token      = str_replace("Bearer ", "", $headers['authorization'] ?? '');

        if (empty($token)) {
            $token        = str_replace("Bearer ", "", $headers['Authorization'] ?? '');
        }
        
        try {
            return JWT::decode($token, new Key($_ENV['API_SECRET_KEY'], self::$encrypt_type));
        } catch (Exception $e) {

            return Response::json([
                'status' => 401,
                'message' => "Token inválido ou ausente.",
            ]);
        }
    }

    /**
     * getMessageValidationRules
     *
     * @return string
     */
    protected function getMessageValidationRules()
    {
        $msgError = "";

        foreach(Session::getDestroy("errors") as $key => $value) {
            $msgError = ($msgError != "" ? substr($msgError, 0 , strlen($msgError) - 1) . ', ' : "") .  strip_tags($value);
        }

        return $msgError;
    }
}
