<?php
    namespace App\Helpers;

    class APIFormatter {
        protected static $response = [
            'metadata' => [
                'code' => null,
                'status' => null,
                'message' => null,
            ],
            'data' => null,
        ];
    
        public static function createAPI($code = null, $status = null, $message = null, $data = null) {
            self::$response['metadata']['code'] = $code;
            self::$response['metadata']['status'] = $status;
            self::$response['metadata']['message'] = $message;
            self::$response['data'] = $data;
    
            return response()->json(self::$response, $code);
        }
    }
    