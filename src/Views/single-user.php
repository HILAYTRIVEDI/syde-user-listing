<?php

/**
 * View for the single user page.
 *
 * @package Syde\UserListing
 * @since 1.0.0
 */

declare(strict_types=1);

$userDetails = $userDetails ?? [];

?>

<div class="syde-user-details">
    <ol class="syde-user-listing-details" aria-describedby="user-details-desc">
        <caption id="user-details-desc">
            <?php echo esc_html__('Additional User Details', 'syde-user-listing'); ?>
        </caption>
        <?php
        if (!(is_array($userDetails) && !empty($userDetails))) :
            ?>
            <li class="no-user-data">
                <?php echo esc_html__('No user details available.', 'syde-user-listing'); ?>
            </li>
            <?php
            return;
        endif;

        /**
         * Recursively process and render each key-value pair in the data.
         *
         * @param array  $data   The data to process (keys and values).
         * @param string $prefix A prefix for nested keys.
         */
        $renderDetails =
            static function (
                array $data,
                string $prefix = ''
            ) use (&$renderDetails): void {
                foreach ($data as $key => $value) :
                    $fullKey = $prefix ? $prefix . '_' . $key : $key;

                    if (is_array($value)) :
                        ?>
                    <li class="user-<?php echo esc_attr($fullKey); ?>" 
                        data-label="
                            <?php
                                echo esc_attr(ucwords(str_replace('_', ' ', $fullKey)));
                            ?>"
                    >
                        <span class="key-label">
                            <?php echo esc_html(ucwords(str_replace('_', ' ', $fullKey))); ?>:
                        </span>
                        <ul>
                            <?php $renderDetails($value, $fullKey); ?>
                        </ul>
                    </li>
                        <?php
                        continue;
                    endif;
                    ?>
                <li 
                    class="user-<?php echo esc_attr($fullKey); ?>" 
                    data-label="
                        <?php
                            echo esc_attr(ucwords(str_replace('_', ' ', $fullKey)));
                        ?>"
                >
                    <span class="key-label">
                        <?php echo esc_html(ucwords(str_replace('_', ' ', $fullKey))); ?>:
                    </span>
                    <span class="value-data"><?php echo esc_html($value); ?></span>
                </li>
                <?php endforeach;
            };

        $renderDetails($userDetails);
        ?>
    </ol>
</div>
