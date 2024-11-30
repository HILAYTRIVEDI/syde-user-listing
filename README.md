# Syde User Listing Plugin

The Syde User Listing plugin allows you to fetch and display user data from an external API in WordPress. It offers a dynamic, user-friendly interface for displaying API responses in a table format, with additional features for managing and caching the data.

## Requirements

- WordPress 5.8 or higher
- PHP 8.0 or higher
- Composer (for managing dependencies)
- Access to an API that provides user data

## Folder Structure
```
├── README.md
├── composer.json
├── composer.lock
├── phpcs.xml.dist
├── phpunit.xml
├── src
│   ├── Container
│   │   └── SydeContainer.php
│   ├── Controllers
│   │   ├── AdminController.php
│   │   ├── AjaxController.php
│   │   ├── CacheController.php
│   │   ├── MenuPageController.php
│   │   └── ShortCodeController.php
│   ├── Exceptions
│   │   └── ContainerException.php
│   ├── Factories
│   │   └── ServiceFactory.php
│   ├── Interfaces
│   │   └── APIServiceInterface.php
│   ├── Services
│   │   ├── APIService.php
│   │   ├── CacheService.php
│   │   ├── SydeErrorService.php
│   │   └── SydeSanitizationService.php
│   ├── SydeUserListing.php
│   ├── Views
│   │   ├── admin-page.php
│   │   ├── single-user.php
│   │   └── table-info.php
│   └── assets
│       ├── css
│       │   └── style.css
│       └── js
│           └── script.js
├── syde-user-listing.php
└── tests
    ├── SydeUserListingTest.php
    ├── Unit
    │   ├── Controller
    │   │   ├── AdminControllerTest.php
    │   │   └── AjaxControllerTest.php
    │   └── Services
    │       ├── APIServiceTest.php
    │       └── CacheServiceTest.php
    └── bootstrap.php
```

## Installation

### 1. Install via Composer

1. Clone the repository or download the plugin files.
2. Navigate to the plugin directory and run the following command:

   ```
   composer install
   ```

3. Upload the plugin to your WordPress site by placing it in the `wp-content/plugins` directory.
4. Activate the Syde User Listing plugin from the WordPress admin dashboard.

### 2. Manual Installation

1. Download the plugin ZIP file.
2. Extract the files and upload the plugin folder to `wp-content/plugins/`.
3. Activate the plugin from the WordPress admin panel.

## Configuration ( Optional )

- These steps are not mandatory to make the plugin work but it just add support for the default API endpoint if non is given in the sortcode.

1. Go to Settings → API Endpoint Settings in the WordPress dashboard.
2. Enter the Default API Endpoint URL to the API that provides user data.
3. Add custom fields to the API configuration page using the `additional_api_endpoint_fields` action hook.
4. Once configured, the user data will automatically be fetched and displayed in both the admin panel and the front end.

## Features

- API Data Fetching: Retrieve user data from an external API.
- Caching: Uses WordPress Transients for caching API responses and improving performance.
- Dynamic Table Display: Displays user data in an easily readable table format, allowing for dynamic adjustments.
- Admin Settings Page: A dedicated page for configuring the API endpoint URL and additional settings.

## Usage

### Front-End Display

Once the plugin is configured, here are the steps to display table on the front end:

- The plugin provides a shortcode `syde_user_listing` you can pass the end point as a attribute to the shortcode, if the endpoint is blank it will take teh value from the admin input field. So the whole shortcode will look something like the below:

```
[syde_user_listing endpoint="https://jsonplaceholder.typicode.com/posts"]
```
 
- Data is displayed in a responsive table format.
- Each user's details can be expanded to view additional information, including nested data.


## Non-Obvious Implementation Choices

### 1. Service Factory and Dependency Injection

   The plugin uses a Service Factory pattern to manage the creation of services like the `APIService`, `SydeErrorService`, `SydeSanitizationService`, and `CacheService`. This approach decouples the instantiation of services from the rest of the application, allowing for easier modifications and testing. For example:

   ```php
   public static function createApiService(): APIService
   {
       return new APIService();
   }
   ```

   ```php
   public static function createCacheService(): CacheService
    {
        return new CacheService();
    }
   ```

   ```php
    public static function createSanitizationService(): SydeSanitizationService
    {
        return new SydeSanitizationService();
    }
   ```
   ```php
    public static function createErrorService(): SydeErrorService
    {
        return new SydeErrorService();
    }
   ```

   This approach also makes it easier to swap out service implementations if needed in the future (e.g., changing caching strategies).

### 2. Recursive Rendering of User Details

   To handle deeply nested user data, the plugin recursively renders the details. This ensures that any complex data structure (such as nested arrays) is automatically processed and displayed, reducing the need for hardcoding and making the plugin more flexible:

   ```php
   $renderDetails = static function ($data, $prefix = '') use (&$renderDetails) {
       foreach ($data as $key => $value) {
           if (is_array($value)) {
               $renderDetails($value, $fullKey); // Recursive call
           } else {
               // Render scalar values
           }
       }
   };
   ```

### 3. Caching API Responses

   To optimize performance, the plugin caches API responses using WordPress's transients API. This reduces unnecessary API calls and improves load times by serving cached data for a specified duration. The default expiration time is set to 12 hours:

   ```php
   public function cacheDataWithExpiration(string $cacheKey, mixed $data, int $expiration = 12 * HOUR_IN_SECONDS): void
   {
       set_transient($cacheKey, $data, $expiration);
   }
   ```

   Also in the `scrip.js` file, the id of a user is matched with the previously fetched user id
   if they match , then the js will shot circuit the fetching and will not fetch the user details again.

   ```javascript
    if (data.id === tempDataId)
    {
        return;
    }
   ```

   You can modify the expiration time based on your needs or even disable caching entirely by adjusting the settings.

### 4. Autowiring in the DIC ( Dependency injection Container )r
   `SydeContainer` supports autowiring to automatically resolve and inject dependencies by analyzing class constructors with PHP Reflection. This simplifies dependency management and eliminates the need for extensive manual configurations.
   
   To resolve a class, call the `get` method. Dependencies will be instantiated and injected as needed. For example:
   
   ```php
   $serviceA = $container->get(ServiceA::class);
   ```
   
   You can also manually bind a class or interface with a custom resolver:
   
   ```php
   $container->set(MyInterface::class, fn($c) => new MyImplementation());
   ```
   
   This efficient auto-wiring mechanism ensures reusable, clean, and manageable dependency handling while adhering to PSR-11 standards.
   

## Contributing

I welcome your contributions  to this project! Please fork the repository, create a feature branch, and submit a pull request with your changes. Make sure to follow the coding standards and write tests for any new functionality.

## License
This plugin is licensed under the GNU General Public License v3.0 or later (GPL-3.0-or-later). See the [LICENSE](LICENSE) file for details.