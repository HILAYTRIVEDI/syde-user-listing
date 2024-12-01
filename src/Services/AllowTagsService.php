<?php

declare(strict_types=1);

namespace Syde\UserListing\Services;

/**
 * Class AllowTagsService
 *
 * This class is responsible for providing the array of allowed tags along with their attributes.
 *
 * @since 1.0.0
 * @package Syde\UserListing\Services
 */
class AllowTagsService
{
    /**
     * Get the array of allowed tags and their attributes.
     *
     * @param array $allowedTags The array of allowed tags.
     * @return array The array of allowed tags and their attributes.
     *
     * @since 1.0.0
     */
    public function getAllowedTagsAtributes(array $allowedTags): array
    {

        // Define default attributes for each HTML tag
        $defaultAttributes = [
            'table' => ['class' => []],
            'tr' => ['class' => []],
            'th' => ['scope' => [], 'class' => []],
            'td' => ['class' => []],
            'input' => ['id' => [], 'type' => [], 'name' => [], 'value' => [], 'class' => []],
            'h1' => ['class' => []],
            'form' => ['method' => [], 'action' => [], 'class' => []],
            'button' => ['id' => [], 'type' => [], 'class' => []],
        ];

        // Filter and return only the requested tags with their attributes
        return array_intersect_key($defaultAttributes, array_flip($allowedTags));

    }
}