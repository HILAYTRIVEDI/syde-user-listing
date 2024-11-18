<?php
/**
 * Exception for ContainerException
 *
 * @package Syde\UserListing\Exceptions
 */

declare(strict_types=1);

namespace Syde\UserListing\Exceptions;

use Exception;

/**
 * Exception for ContainerException
 *
 * @package Syde\UserListing\Exceptions
 */
class ContainerException extends Exception
{
    /**
     * Exception for ContainerException
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}