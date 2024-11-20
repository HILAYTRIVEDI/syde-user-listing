<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

/**
 * Class MenuPageController
 * 
 * @since 1.0.0
 * @access public
 */
class MenuPageController
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
        string | callable $sanitizer
    ): void
    {
        // Register settings with sanitization
        register_setting( $menuSlug , $fieldName, $sanitizer );
    }
}