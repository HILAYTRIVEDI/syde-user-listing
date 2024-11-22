<?php

/**
 * Exception for container-related errors.
 *
 * @package Syde\UserListing\Exceptions
 */

declare(strict_types=1);

namespace Syde\UserListing\Exceptions;

use Exception;
use Psr\Container\ContainerExceptionInterface;

/**
 * Custom exception class for container-related errors.
 *
 * Implements PSR-11's ContainerExceptionInterface to indicate errors related to
 * dependency injection or service resolution.
 *
 * @since 1.0.0
 *
 * @package Syde\UserListing\Exceptions
 */
class ContainerException extends Exception implements ContainerExceptionInterface
{
    /**
     * Constructs a new ContainerException.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @param string $message Optional. The error message.
     * @param int $code Optional. The error code. Defaults to 0.
     * @param Exception|null $previous Optional. The previous exception used for exception chaining.
     */
    public function __construct(string $message = '', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
