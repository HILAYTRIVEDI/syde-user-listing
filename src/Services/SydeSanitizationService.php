<?php

declare(strict_types=1);

namespace Syde\UserListing\Services;

/**
 * Class SanitizationService
 * 
 * This class is the helper class for sanitization data for the plugin. This class
 * is used to sanitize data before it is stored in the database or sent to the
 * frontend.
 * 
 * @package Syde\UserListing\Services
 * 
 * @since 1.0.0
 */
class SydeSanitizationService{

    /**
     * Sanitize text field.
     * 
     * This method is used to sanitize text fields before storing them in the
     * database or sending them to the frontend.
     * 
     * @param string $text The text to be sanitized.
     * 
     * @return string The sanitized text.
     * 
     * @since 1.0.0
     */
    public function sanitizeTextField( string $text ): string {
        return sanitize_text_field( $text );
    }

    /**
     * Sanitize integer.
     * 
     * This method is used to sanitize integers before storing them in the
     * database or sending them to the frontend. It ensures that the integer is
     * a positive integer and returns the absolute value of the integer.
     * 
     * @param int $int The integer to be sanitized.
     * 
     * @return int The sanitized integer.
     * 
     * @since 1.0.0
     * 
     */
    public function sanitizeInt( mixed $int ): int {
        return absint( $int );
    }

    /**
     * Sanitize URL.
     * 
     * This method is used to sanitize URLs before storing them in the database or
     * sending them to the frontend. It ensures that the URL is a valid URL and
     * returns the sanitized URL.
     * 
     * @param string $url The URL to be sanitized.
     * 
     * @return string The sanitized URL.
     * 
     * @since 1.0.0
     */
    public function sanitizeUrl( string $url, bool $do_unslash = true ): string {
        if ( $do_unslash ) {
            $url = wp_unslash( $url );
        }
        return sanitize_url( $url );
    }

    /**
     * Sanitize email.
     * 
     * This method is used to sanitize email addresses before storing them in the
     * database or sending them to the frontend. It ensures that the email is a
     * valid email address and returns the sanitized email.
     * 
     * @param string $email The email address to be sanitized.
     * 
     * @return string The sanitized email address.
     * 
     * @since 1.0.0
     */
    public function sanitizeEmail( string $email ): string {
        return sanitize_email( $email );
    }


    /**
     *  Sanitize array.
     * 
     * This method is used to sanitize arrays before storing them in the database or
     * sending them to the frontend. It ensures that the array contains only
     * strings, integers, and arrays and returns the sanitized array.
     * 
     * @param array $array The array to be sanitized.
     * 
     * @return array The sanitized array.
     * 
     * @since 1.0.0
     */
    public function sanitizeArray( array $array ): array {
        return array_map(
            function( $value ) {
                // Check the data type of the value and sanitize it accordingly
                switch ( gettype( $value ) ) {
                    case 'string':
                        return $this->sanitizeTextField( $value );
                    case 'integer':
                        return $this->sanitizeInt( $value );
                    case 'array':
                        return $this->sanitizeArray( $value );
                    default:
                        return $value;
                }
            },
            $array
        );
    }

}