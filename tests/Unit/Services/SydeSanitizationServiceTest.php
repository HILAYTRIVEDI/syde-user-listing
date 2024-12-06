<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Services;

use Syde\UserListing\Services\SydeSanitizationService;
use Syde\UserListing\Tests\SydeUserListingTest;

class SydeSanitizationServiceTest extends SydeUserListingTest
{

    public function createSydeSanitizationService(): SydeSanitizationService
    {
        return new SydeSanitizationService();
    }

    /**
     * Test the sanitization of text fields by ensuring that 
     * potentially harmful characters are converted to HTML entities.
     */
    public function testSanitizeTextField(): void
    {
        $sydeSanitizationService = $this->createSydeSanitizationService();

        $input = '<script>alert("test")</script>';
        $sanitized = $sydeSanitizationService->sanitizeTextField($input);

        // The expected sanitized output includes HTML-encoded characters.
        $this->assertEquals('&lt;script&gt;alert(&quot;test&quot;)&lt;/script&gt;', $sanitized);
    }

    /**
     * Test the sanitization of URLs, ensuring that a valid URL is 
     * correctly sanitized and has a trailing slash if needed.
     */
    public function testSanitizeUrl(): void
    {
        $sydeSanitizationService = $this->createSydeSanitizationService();

        $input = 'https://example.com';
        $sanitized = $sydeSanitizationService->sanitizeUrl($input);

        // The expected sanitized URL should not include the trailing slash.
        $this->assertEquals('https://example.com', $sanitized);
    }

    /**
     * Test the sanitization of an array, ensuring that each element 
     * within the array is properly sanitized.
     */
    public function testSanitizeArray(): void
    {
        $sydeSanitizationService = $this->createSydeSanitizationService();

        $input = ['alert', 123, 'https://example.com'];
        $sanitized = $sydeSanitizationService->sanitizeArray($input);

        // The expected output array should have sanitized strings, but integer remains unchanged.
        $this->assertEquals([
            'alert',
            123,
            'https://example.com'
        ], $sanitized);
    }

}