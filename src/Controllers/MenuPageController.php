<?php

/**
 * This file contains the MenuPageController class for the Syde User Listing plugin
 * that handles the registration of settings and menu page fields.
 *
 * @package Syde\UserListing\Controllers
 *
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

/**
 * Class MenuPageController
 *
 * Handles the registration of settings and menu page fields within the admin panel.
 *
 * @package Syde\UserListing\Controllers
 * @since 1.0.0
 */
class MenuPageController
{
    /**
     * Registers a settings field for a specific menu page.
     * This method links a setting field to a menu page, enabling to save user inputs
     * and sanitize them using a given sanitizer function or callback.
     *
     * @param string $menuSlug The unique slug of the menu page.
     * @param string $fieldName The name of the setting field.
     * @param string|callable $sanitizer The sanitizer function or callable for sanitizing input.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function registerMenuPageField(
        string $menuSlug,
        string $fieldName,
        string|callable $sanitizer
    ): void {
        // Register the setting and specify the sanitization callback
        register_setting($menuSlug, $fieldName, $sanitizer);
    }
}
