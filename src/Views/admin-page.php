<?php

declare(strict_types=1);

/**
 * View for the admin page.
 *
 * @package SydeUserListing
 */

?>
<div class="wrap">
    <h1><?php echo esc_html__('API Endpoint Settings', 'syde-user-listing'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('api_endpoint_settings');
        do_settings_sections('api_endpoint_settings');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Default API Endpoint URL', 'syde-user-listing'); ?></th>
                <td>
                    <input type="url" name="api_endpoint_url" value="<?php echo esc_attr(get_option('api_endpoint_url')); ?>" class="regular-text">
                </td>
            </tr>
            <?php
                // additional_api_endpoint_fields hook to add additional fields.
                do_action('additional_api_endpoint_fields');
            ?>
        </table>
        <?php submit_button(); ?>
    </form>
</div>