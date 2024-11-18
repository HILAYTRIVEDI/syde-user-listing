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
class ContainerException extends Exception implements ContainerExceptionInterface{}