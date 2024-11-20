<?php


namespace Syde\UserListing\Services;

use Syde\UserListing\Interfaces\APIServiceInterface;

/**
 * Class ApiService
 * 
 * @package Syde\UserListing\Services
 */
class APIService implements APIServiceInterface{

    private string $url;

    public function fetch( string $url, array $headers = [] ) : array
    {

        // Sanitize the URL.
        $this->url = sanitize_url( $url );

        // Check if the URL is valid.
        if ( ! filter_var( $this->url, FILTER_VALIDATE_URL ) ) {
            do_action('syde_user_listing_api_service_invalid_url', $url);
            throw new \InvalidArgumentException( 'Invalid URL provided.' );
        }

        // Check if the URL is approachable or not.
        if ( ! wp_remote_head( $this->url ) ) {
            throw new \InvalidArgumentException( 'URL is not approachable.' );
        }


        // Allow modification of the URL via a filter.
        $this->url = apply_filters( 'syde_user_listing_api_service_url', $this->url );

        // Allow modification of headers via a filter.
        $headers = apply_filters( 'syde_user_listing_api_service_headers', $headers, $this->url );

        // Retrive the id, name, username and email only.
        $response = wp_remote_retrieve_body(wp_safe_remote_get( $this->url ) );

        $response = json_decode( $response, true );

        // Allow modification of the response data via a filter.
        $response = apply_filters('syde_user_listing_api_service_response', $response, $this->url);

        return $response;
    }

    public function getUserDetails( int $user_id ) : array
    {

        // Default URL or previously set URL.
        $base_url = $this->url ?? 'https://jsonplaceholder.typicode.com/users';

        // Construct the user details URL.
        $user_url = trailingslashit($base_url) . $user_id;

        // Allow modification of the user-specific URL via a filter.
        $user_url = apply_filters('syde_user_listing_api_service_user_url', $user_url, $user_id);

        return $this->fetch($user_url);
    }

}