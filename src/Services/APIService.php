<?php

declare(strict_types=1);

namespace Syde\UserListing\Services;

use Syde\UserListing\Interfaces\APIServiceInterface;
use Syde\UserListing\Services\SydeErrorHandlingService;

class APIService implements APIServiceInterface
{
    /**
     * The base URL for API requests.
     */
    private string $url;


    /**
     * Constructor.
     *
     * @param SydeErrorHandlingService $errorService The error handling service.
     */
    public function __construct(private SydeErrorHandlingService $errorService)
    {
        $this->errorService = $errorService;
    }

    /**
     * Fetch data from an API endpoint.
     *
     * @param string $url The API endpoint to fetch data from.
     * @param array $headers Optional headers to include in the request.
     * @return array|WP_Error The response data as an associative array or a WP_Error object.
     */
    public function fetch(string $url, array $headers = []): array|\WP_Error
    {
        // Sanitize the URL.
        $this->url = sanitize_url($url);

        // Validate the URL format.
        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            do_action('syde_user_listing_api_service_invalid_url', $url);
            return $this->errorService->createError(
                'Invalid URL provided.',
                'invalid_url',
                $url
            );
        }

        // Validate the URL's accessibility.
        $headResponse = wp_remote_head($this->url);
        if (is_wp_error($headResponse) || wp_remote_retrieve_response_code($headResponse) !== 200) {
            return $this->errorService->createError(
                'The URL is not accessible or does not exist.',
                'url_not_accessible',
                $this->url
            );
        }

        // Allow modifications to the URL and headers via filters.
        $this->url = apply_filters('syde_user_listing_api_service_url', $this->url);
        $headers = apply_filters('syde_user_listing_api_service_headers', $headers, $this->url);

        // Send the GET request and retrieve the response body.
        $response = wp_safe_remote_get($this->url, ['headers' => $headers]);
        if (is_wp_error($response)) {
            return $this->errorService->createError(
                'Error fetching data from the API.',
                'api_request_failed',
                $response->get_error_message()
            );
        }

        $responseBody = wp_remote_retrieve_body($response);
        $decodedResponse = json_decode($responseBody, true);

        // Ensure the response is a valid JSON object.
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->errorService->createError(
                'Invalid JSON response from the API.',
                'invalid_json',
                json_last_error_msg()
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
