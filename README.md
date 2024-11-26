# Syde User Listing Plugin

The Syde User Listing plugin allows you to fetch and display user data from an external API in WordPress. It offers a dynamic, user-friendly interface for displaying API responses in a table format, with additional features for managing and caching the data.

## Requirements

- WordPress 5.8 or higher
- PHP 8.0 or higher
- Composer (for managing dependencies)
- Access to an API that provides user data

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

## Configuration

1. Go to Settings → API Endpoint Settings in the WordPress dashboard.
2. Enter the Default API Endpoint URL to the API that provides user data.
3. You can add additional custom fields to the API configuration page using the `additional_api_endpoint_fields` action hook.
4. Once configured, the user data will automatically be fetched and displayed in both the admin panel and the front-end.

## Features

- API Data Fetching: Retrieve user data from an external API.
- Caching: Uses WordPress Transients for caching API responses and improving performance.
- Dynamic Table Display: Displays user data in an easily readable table format, allowing for dynamic adjustments.
- Admin Settings Page: A dedicated page for configuring the API endpoint URL and additional settings.

## Usage

### Front-End Display

Once the plugin is configured, the user data will be shown on the front-end:

- Data is displayed in a responsive table format.
- Each user's details can be expanded to view additional information, including nested data.

### Admin Page

- The plugin adds an API Endpoint Settings page where administrators can configure the API endpoint URL.
- Custom fields can be added to this settings page using the `additional_api_endpoint_fields` hook.

## Non-Obvious Implementation Choices

### 1. Service Factory and Dependency Injection

   The plugin uses a Service Factory pattern to manage the creation of services like the `APIService` and `CacheService`. This approach decouples the instantiation of services from the rest of the application, allowing for easier modifications and testing. For example:

   ```
   public static function createApiService(): APIService
   {
       return new APIService();
   }
   ```

   This approach also makes it easier to swap out service implementations if needed in the future (e.g., changing caching strategies).

### 2. Recursive Rendering of User Details

   To handle deeply nested user data, the plugin recursively renders the details. This ensures that any complex data structure (such as nested arrays) is automatically processed and displayed, reducing the need for hardcoding and making the plugin more flexible:

   ```
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

   ```
   public function cacheDataWithExpiration(string $cacheKey, mixed $data, int $expiration = 12 * HOUR_IN_SECONDS): void
   {
       set_transient($cacheKey, $data, $expiration);
   }
   ```

   You can modify the expiration time based on your needs or even disable caching entirely by adjusting the settings.

### 4. Error Handling

   The plugin gracefully handles various errors, such as invalid URLs or failed API requests. Using `WP_Error` ensures that errors are integrated with WordPress’s error handling system and can be easily debugged:

   ```
   if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
       return new \WP_Error('invalid_url', 'Invalid URL provided.');
   }
   ```

   This provides clear feedback to the user if something goes wrong, improving the overall user experience.

## Contributing

We welcome contributions to this project! Please fork the repository, create a feature branch, and submit a pull request with your changes. Make sure to follow the coding standards and write tests for any new functionality.

## License

This plugin is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
```