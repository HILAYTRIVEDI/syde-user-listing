<?php

/**
 * View for displaying user data in a table format.
 *
 * @package Syde\UserListing\Views
 *
 * @since 1.0.0
 */

declare(strict_types=1);

use PHP_CodeSniffer\Generators\HTML;

// Ensure the variables are defined before using.
$data = $data ?? [];
$apiEndpoint = $apiEndpoint ?? '';

?>

<div class="table-responsive">
    <table class="syde-user-listing-table" aria-describedby="user-table-desc">
        <caption id="user-table-desc">
            A list of data that comes from the API.
        </caption>
        <thead>
            <?php

            $keys = array_slice(array_keys($data[0]), 0, 4); // Get the first 4 keys.
            // Prepare column headers dynamically from the response keys.
            foreach ($keys as $key) { ?>
                <th 
                    scope="col" 
                    data-label="<?php echo esc_attr(ucwords($key)); ?>">
                    <?php echo esc_html(ucwords($key)); ?>
                </th>
                <?php
            }
            ?>
        </thead>
        <tbody>
            <?php
            // Ensure data is an array before proceeding.
            if (is_array($data) && !empty($data)) {
                foreach ($data as $singleData) {
                    // Validate that $singleData is an array.
                    if (is_array($singleData)) {
                        // Use the first key for the data-id of the anchor tag.
                        $firstKey = $keys[0]; // Get the first key from the keys list.
                        ?>
                        <tr class="user-row">
                            <?php
                            // Loop over the first 4 keys only.
                            foreach ($keys as $key) {
                                if (isset($singleData[$key]) && !is_array($singleData[$key])) {
                                    ?>
                                    <td 
                                        class="user-<?php echo esc_attr($key); ?>" 
                                        data-label="<?php echo esc_attr(ucwords($key)); ?>">
                                        <a 
                                            href="#" 
                                            class="user-link" 
                                            data-id="<?php echo esc_attr($singleData[$firstKey]); ?>">
                                            <?php echo esc_html($singleData[$key]); ?>
                                        </a>
                                    </td>
                                <?php } elseif (is_array($singleData[$key])) {
                                    array_walk_recursive(
                                        $singleData[$key],
                                        static function (
                                            array $value,
                                            int $key
                                        ) use (
                                            $singleData,
                                            $firstKey
                                        ): void { ?>
                                        <td 
                                            class="user-<?php echo esc_attr($key); ?>" 
                                            data-label="<?php echo esc_attr(ucwords($key)); ?>">
                                            <a 
                                                href="#" 
                                                class="user-link" 
                                                data-id="<?php echo esc_attr($singleData[$firstKey]); ?>">
                                                <?php echo esc_html($value); ?>
                                            </a>
                                        </td>
                                            <?php
                                        }
                                    );
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                }
            }
            ?>

        </tbody>
    </table>

    <div id="user-additional-data" data-api-url="<?php echo esc_url($apiEndpoint); ?>"></div>
</div>