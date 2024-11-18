<?php

declare(strict_types=1);

namespace Syde\UserListing\Controllers;

use Syde\UserListing\Interfaces\MenuPageFields;

/**
 * Class MenuPageController
 * 
 * @since 1.0.0
 * @access public
 */
class MenuPageController implements MenuPageFields
{

    /**
     * MenuPageController constructor.
     * 
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
        add_action('admin_init', [$this, 'registerMenuPageField']);
    }

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
    ): void
    {
        // register_setting();
    }
}