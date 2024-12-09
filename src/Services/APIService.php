<?php

/**
 * This file contains the APIService class for the Syde User Listing plugin
 * that handles API requests and responses with WordPress HTTP functions.
 *
 * @package Syde\UserListing\Services
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing\Services;

use Syde\UserListing\Interfaces\APIServiceInterface;

/**
 * Class APIService
 *
 * Handles API requests and responses with WordPress HTTP functions.
 *
 * @package Syde\UserListing\Services
 */
class APIService implements APIServiceInterface
{
    /**
     * The base URL for API requests.
     *
     */
    private string $url;

    private SydeErrorService $errorService;

    /**
     * Fetch data from an API endpoint.
     *
     * @param string $url The API endpoint to fetch data from.
     * @param array $headers Optional headers to include in the request.
     * @return array|WP_Error The response data as an associative array or a WP_Error object.
     */
    public function fetch(string $url, array $headers = []): array|\WP_Error
    {
        $this->errorService = new SydeErrorService();

        // Sanitize the URL.
        $this->url = sanitize_url($url);

        // Validate the URL format.
        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            do_action('syde_user_listing_api_service_invalid_url', $url);
            return $this->errorService->handleError('invalid_url', 'Invalid URL provided.');
        }

        // Validate the URL's accessibility.
        $headResponse = wp_remote_head($this->url);
        if (is_wp_error($headResponse) || wp_remote_retrieve_response_code($headResponse) !== 200) {
            return $this->errorService->handleError(
                'url_not_accessible',
                "The URL is not accessible or does not exist."
            );
        }

        // Allow modifications to the URL and headers via filters.
        $this->url = apply_filters('syde_user_listing_api_service_url', $this->url);
        $headers = apply_filters('syde_user_listing_api_service_headers', $headers, $this->url);

        // Send the GET request and retrieve the response body.
        $response = wp_safe_remote_get($this->url, ['headers' => $headers]);
        if (is_wp_error($response)) {
            return $this->errorService->handleError(
                'api_request_failed',
                "Error fetching data from the API: " . wp_kses_post($response->get_error_message())
                    . "\nURL: " . $this->url
                    . "\nHeaders: " . wp_kses_post(json_encode($headers))
                    . "\nResponse: " . wp_kses_post(json_encode($response))
            );
        }

        $responseBody = wp_remote_retrieve_body($response);
        $decodedResponse = json_decode($responseBody, true);

        // Ensure the response is a valid JSON object.
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->errorService->handleError(
                'invalid_json',
                'Invalid JSON response from the API.'
            );
        }

        // Allow modifications to the decoded response via a filter.
        $decodedResponse = apply_filters(
            'syde_user_listing_api_service_response',
            $decodedResponse,
            $this->url
        );

        return $decodedResponse;
    }

    /**
     * Retrieve user details by user ID.
     *
     * @param int $userId The ID of the user to fetch details for.
     * @return array|WP_Error The user's details as an associative array or WP_Error object.
     */
    public function userDetails(string $apiEndpoint, int $userId): array | \WP_Error
    {
        // Use the base URL or a default URL if not set.
        $baseUrl = $apiEndpoint;

        // Construct the user-specific endpoint URL.
        $userUrl = trailingslashit($baseUrl) . $userId;

        // Allow modifications to the user-specific URL via a filter.
        $userUrl = apply_filters('syde_user_listing_api_service_user_url', $userUrl, $userId);

        // Fetch and return the user details.
        return $this->fetch($userUrl);
    }
}
