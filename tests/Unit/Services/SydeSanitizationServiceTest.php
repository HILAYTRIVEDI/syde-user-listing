<?php

declare(strict_types=1);

namespace Syde\UserListing\Tests\Unit\Services;

use Syde\UserListing\Services\SydeSanitizationService;
use Syde\UserListing\Tests\SydeUserListingTest;

class SydeSanitizationServiceTest extends SydeUserListingTest{
    

    public function createSydeSanitizationService(): SydeSanitizationService
    {
        return new SydeSanitizationService();
    }

    /**
     * Test the sanitizeTextField method of the SydeSanitizationService.
     * 
     * @return void
     */
    public function testSanitizeTextField(): void{

        $sydeSanitizationService = $this->createSydeSanitizationService();

        // Check if the sanitizeTextField function returns the expected data
        $this->assertIsCallable([$sydeSanitizationService, 'sanitizeTextField']);
    
    }

    /**
     * Test the sanitizeInt method of the SydeSanitizationService.
     * 
     * @return void
     */                            
    public function testSanitizeInt(): void{

        $sydeSanitizationService = $this->createSydeSanitizationService();

        // Check if the sanitizeInt function returns the expected data
        $this->assertIsCallable([$sydeSanitizationService, 'sanitizeInt']);
    }

    /**
     * Test the sanitizeUrl method of the SydeSanitizationService.
     * 
     * @return void
     */
    public function testSanitizeUrl(): void{
        
        $sydeSanitizationService = $this->createSydeSanitizationService();

        // Check if the sanitizeUrl function returns the expected data
        $this->assertIsCallable([$sydeSanitizationService, 'sanitizeUrl']);
    }

    /**
     * Test the sanitizeEmail method of the SydeSanitizationService.
     *
     * @return void
     */
    public function testSanitizeEmail(): void{
        
        $sydeSanitizationService = $this->createSydeSanitizationService();

        // Check if the sanitizeEmail function returns the expected data
        $this->assertIsCallable([$sydeSanitizationService, 'sanitizeEmail']);
    }

    /**
     * Test the sanitizeArray method of the SydeSanitizationService.
     * 
     * @return void
     */
    public function testSanitizeArray (): void{
        
        $sydeSanitizationService = $this->createSydeSanitizationService();

        // Check if the sanitizeArray function returns the expected data
        $this->assertIsCallable([$sydeSanitizationService, 'sanitizeArray']);
    }

}       