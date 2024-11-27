<?php

declare(strict_types=1);

namespace Syde\UserListing\Services;

use WP_Error;

/**
 * Class SydeErrorClass
 * 
 * This is the wrapper class for the error handling in the Syde User Listing plugin.
 * So that the error handling can be handled in a single place.
 * 
 * @package Syde\UserListing\Services
 */
class SydeErrorHandlingService{

    /**
     * Create an error object.
     * 
     * This function will work as a wrapper for the WP_Error so that 
     * the error handling can be handled in a single place.
     * 
     * @param string $message The error message.
     * @param string $code The error code.
     * @param mixed $data The error data.
     * 
     * @return WP_Error The error object.
     */
    public function createError(string $message, string $code = 'error', mixed $data ): WP_Error {
        return new WP_Error($code, $message, $data);
    }

    /**
     * Send a JSON error response.
     *
     * @param string $message The error message to send.
     * @param string $code Optional. The error code.
     * @param mixed $data Optional. Additional data for the response.
     * @return void
     */
    public function sendJsonError(string $message, string $code = '', mixed $data = null): void
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        wp_send_json_error($response);
    }

    /**
     * Format a WP_Error object for JSON response.
     *
     * @param WP_Error $error The WP_Error object to format.
     * @return array An associative array representing the error.
     */
    public function formatErrorForJson(WP_Error $error): array
    {
        return [
            'code' => $error->get_error_code(),
            'message' => $error->get_error_message(),
            'data' => $error->get_error_data(),
        ];
    }

}