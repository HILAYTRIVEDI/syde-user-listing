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
            throw new \InvalidArgumentException( 'Invalid URL provided.' );
        }

        // Check if the URL is approachable or not.
        if ( ! wp_remote_head( $this->url ) ) {
            throw new \InvalidArgumentException( 'URL is not approachable.' );
        }

        // Retrive the id, name, username and email only.
        $response = wp_remote_retrieve_body(wp_safe_remote_get( $this->url ) );

        $response = json_decode( $response, true );

        return $response;
    }

    public function getUserDetails( int $user_id ) : array
    {

        return $this->fetch( ($this->url ?? 'https://jsonplaceholder.typicode.com/users').'/'.$user_id );
    }

}