<?php

declare(strict_types=1);

/**
 * View for the single user page.
 *
 * @package Syde\UserListing
 */

?>

<div class="syde-user-details">
    <ol class="syde-user-listing-details" aria-describedby="user-details-desc">
        <caption id="user-details-desc">
            <?php echo esc_html__('Additional User Details', 'syde-user-listing'); ?>
        </caption>
        <?php
        // Ensure $userDetails is an array and not empty.
        if (is_array($userDetails) && !empty($userDetails)) {
            /**
             * Recursively process and render each key-value pair in the data.
             *
             * @param array  $data   The data to process (keys and values).
             * @param string $prefix A prefix for nested keys.
             */
            $renderDetails = static function ($data, $prefix = '') use (&$renderDetails) {
                foreach ($data as $key => $value) {
                    // Combine keys for nested arrays to ensure uniqueness.
                    $fullKey = $prefix ? $prefix . '_' . $key : $key;

                    // If value is an array, call the function recursively.
                    if (is_array($value)) { ?>
                        <li class="user-<?php echo esc_attr($fullKey); ?>" data-label="<?php echo esc_attr(ucwords(str_replace('_', ' ', $fullKey))); ?>">
                            <span class="key-label"><?php echo esc_html(ucwords(str_replace('_', ' ', $fullKey))); ?>:</span>
                            <ul>
                                <?php $renderDetails($value, $fullKey); // Recursive call 
                                ?>
                            </ul>
                        </li>
                    <?php
                    } else {
                        // Render scalar values directly.
                    ?>
                        <li class="user-<?php echo esc_attr($fullKey); ?>" data-label="<?php echo esc_attr(ucwords(str_replace('_', ' ', $fullKey))); ?>">
                            <span class="key-label"><?php echo esc_html(ucwords(str_replace('_', ' ', $fullKey))); ?>:</span>
                            <span class="value-data"><?php echo esc_html($value); ?></span>
                        </li>
            <?php
                    }
                }
            };

            // Call the rendering function for the top-level $userDetails array.
            $renderDetails($userDetails);
        } else {
            // Handle empty or invalid $userDetails case.
            ?>
            <li class="no-user-data">
                <?php echo esc_html__('No user details available.', 'syde-user-listing'); ?>
            </li>
        <?php
        }
        ?>
    </ol>
</div>