<?php
/**
 * Exception for ContainerException
 *
 * @package Syde\UserListing\Exceptions
 */

declare(strict_types=1);

namespace Syde\UserListing\Exceptions;

use Exception;
use Psr\Container\ContainerExceptionInterface;

/**
 * Exception for ContainerException
 *
 * @package Syde\UserListing\Exceptions
 */
class ContainerException extends Exception implements ContainerExceptionInterface{

    /**
     * ContainerException constructor.
     * 
     * @since 1.0.0
     * 
     * @access public
     * 
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     * @return void
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}