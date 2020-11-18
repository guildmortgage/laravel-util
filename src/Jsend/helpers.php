<?php

if (!function_exists("jsend_error")) {
    /**
     * Returns an error response.
     *
     * @param string $message
     *   The error message.
     * @param int $status_code
     *   The HTTP status code.
     * @param null $error_code
     *   The API-specific error code, if applicable.
     * @param mixed $data
     *   The data, if applicable.
     * @param array $headers
     *   Any headers to include in the response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function jsend_error($message = '', $status_code = Response::HTTP_INTERNAL_SERVER_ERROR, $error_code = null, $data = null, $headers = [])
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($error_code) {
            $response['code'] = $error_code;
        }

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $status_code, $headers);
    }
}

if (!function_exists("jsend_fail")) {
    /**
     * Returns a failure response.
     *
     * @param mixed $data
     *   The data.
     * @param int $status_code
     *   The HTTP status code.
     * @param array $headers
     *   Any headers to include in the response.
     * @param null $error_code
     *   The API-specific error code, if applicable.
     * @return \Illuminate\Http\JsonResponse
     */
    function jsend_fail($data = null, $status_code = Response::HTTP_BAD_REQUEST, $headers = [], $error_code = null)
    {
        $response = [
            'status' => 'fail',
            'data' => $data
        ];

        if ($error_code) {
            $response['code'] = $error_code;
        }

        return response()->json($response, $status_code, $headers);
    }
}

if (!function_exists("jsend_success")) {
    /**
     * Returns a success response.
     *
     * @param mixed $data
     *   The data.
     * @param int $status_code
     *   The HTTP status code.
     * @param array $headers
     *   The headers to include in the response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function jsend_success($data = null, $status_code = Response::HTTP_OK, $headers = [])
    {
        $response = [
            "status" => "success",
            "data" => $data
        ];

        return response()->json($response, $status, $extraHeaders);
    }
}