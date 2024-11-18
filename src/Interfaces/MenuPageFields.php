<?php

declare(strict_types=1);

namespace Syde\UserListing\Interfaces;

/**
 * Interface MenuPageFields
 * 
 * @since 1.0.0
 * @access public
 */
interface MenuPageFields
{
    /**
     * Register the menu page field.
     * 
     * @return string
     * @since 1.0.0
     * @access public
     */
    public function registerMenuPageField(
        string $menuSlug,
        string $fieldName,
    ): void;
}