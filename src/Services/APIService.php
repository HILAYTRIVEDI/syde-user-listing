<?php

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

    /**
     * Fetch data from an API endpoint.
     *
     * This method sends a GET request to the specified URL with optional headers,
     * and returns the decoded JSON response as an associative array.
     *
     * @param string $url The API endpoint to fetch data from.
     * @param array $headers Optional headers to include in the request.
     * @return array The response data as an associative array.
     *
     * @throws \InvalidArgumentException If the URL is invalid or not accessible.
     */
    public function fetch(string $url, array $headers = []): array
    {
        // Sanitize the URL.
        $this->url = sanitize_url($url);

        // Validate the URL format.
        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            do_action('syde_user_listing_api_service_invalid_url', $url);
            throw new \InvalidArgumentException('Invalid URL provided.');
        }

        // Validate the URL's accessibility.
        $head_response = wp_remote_head($this->url);
        if (is_wp_error($head_response) || wp_remote_retrieve_response_code($head_response) !== 200) {
            throw new \InvalidArgumentException('URL is not accessible.');
        }

        // Allow modifications to the URL and headers via filters.
        $this->url = apply_filters('syde_user_listing_api_service_url', $this->url);
        $headers = apply_filters('syde_user_listing_api_service_headers', $headers, $this->url);

        // Send the GET request and retrieve the response body.
        $response = wp_safe_remote_get($this->url, ['headers' => $headers]);
        if (is_wp_error($response)) {
            throw new \RuntimeException('Error fetching data from the API: ' . $response->get_error_message());
        }

        $response_body = wp_remote_retrieve_body($response);
        $decoded_response = json_decode($response_body, true);

        // Ensure the response is a valid JSON object.
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON response from the API.');
        }

        // Allow modifications to the decoded response via a filter.
        $decoded_response = apply_filters('syde_user_listing_api_service_response', $decoded_response, $this->url);

        return $decoded_response;
    }

    /**
     * Retrieve user details by user ID.
     *
     * Fetches user details from the API for the given user ID, using the base URL or a default URL.
     *
     * @param int $user_id The ID of the user to fetch details for.
     * @return array The user's details as an associative array.
     */
    public function getUserDetails(int $user_id): array
    {
        // Use the base URL or a default URL if not set.
        $base_url = $this->url ?? 'https://jsonplaceholder.typicode.com/users';

        // Construct the user-specific endpoint URL.
        $user_url = trailingslashit($base_url) . $user_id;

        // Allow modifications to the user-specific URL via a filter.
        $user_url = apply_filters('syde_user_listing_api_service_user_url', $user_url, $user_id);

        // Fetch and return the user details.
        return $this->fetch($user_url);
    }
}
