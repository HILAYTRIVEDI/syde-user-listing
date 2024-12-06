<?php

/**
 * This file contains the ErrorService class for the Syde User Listing plugin
 * that handles errors and exceptions.
 *
 * @package Syde\UserListing\Services
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing\Services;

use WP_Error;

/**
 * Class ErrorService
 *
 * This class is the helper class for error handling in the plugin. This class
 * is used to handle errors and exceptions that occur during the execution of
 * the plugin.
 *
 * @package Syde\UserListing\Services
 *
 * @since 1.0.0
 */
class SydeErrorService
{
    /**
     * Handle error.
     *
     * This method is used to handle errors and exceptions that occur during the
     * execution of the plugin. It logs the error message and returns the WP_Error
     * object.
     *
     * @param string $errorCode The error code to be logged.
     * @param string $errorMessage The error message to be logged.
     * @param mixed $errorData The error data to be logged.
     *
     * @return WP_Error The WP_Error object.
     *
     * @since 1.0.0
     */
    public function handleError(string $errorCode, string $errorMessage, mixed $errorData = null): WP_Error
    {

        $error = new WP_Error($errorCode, $errorMessage, $errorData);
        return $error;
    }
}
