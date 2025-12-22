# Visual ACF Modules Documentation

## Overview

The Visual ACF Modules system is a comprehensive WordPress plugin that enhances the Advanced Custom Fields (ACF) Flexible Content experience by providing a visual interface for selecting modules and heros. It replaces the default ACF dropdown selection with an intuitive modal interface featuring preview images, search functionality, and detailed module information.

## Purpose

This system addresses several key challenges in content management:

1. **Visual Selection**: Provides preview images for modules instead of text-only lists
2. **Enhanced UX**: Offers a modern, searchable modal interface for content creators
3. **Documentation Integration**: Shows module usage across the site and provides descriptions
4. **Customization**: Allows branding customization with logos and color schemes
5. **Content Management**: Enables administrators to manage module descriptions and preview images

## System Architecture

### Core Components

#### 1. Main Controller (`init.php`)
- **Purpose**: Central initialization and asset management
- **Key Features**:
  - Loads all endpoints and admin pages
  - Manages asset enqueuing with file-based versioning
  - Handles conditional loading based on admin pages
  - Provides dynamic path resolution for flexible deployment

#### 2. Admin Interface
Located in `/admin/` directory:

##### Module Descriptions (`module-descriptions.php`)
- **Purpose**: Manage descriptions and preview images for ACF modules
- **Features**:
  - Auto-discovery of ACF flexible content layouts
  - Differentiation between modules and heros based on field names
  - CRUD operations for module descriptions
  - Preview image management
  - Template-based rendering system

##### Modal Customization (`modal-customization.php`)
- **Purpose**: Customize modal appearance and branding
- **Features**:
  - Logo upload and management (PNG, JPG, SVG, WebP support)
  - Background color customization with live preview
  - File validation and security measures
  - Automatic cleanup of old assets

#### 3. Frontend Assets
Located in `/assets/` directory:

##### JavaScript Components
- **`acf-flexible-modal.js`**: Main modal functionality
  - Intercepts ACF "Add Layout" button clicks
  - Manages modal lifecycle (show/hide/search)
  - Handles layout selection and usage information display
  - Implements keyboard navigation and accessibility features

- **`api-service.js`**: Centralized API communication
  - Provides consistent interface for all AJAX requests
  - Handles both standard POST requests and file uploads
  - Implements error handling and response validation
  - Uses modern Fetch API with XMLHttpRequest fallback for uploads

- **`module-descriptions-admin.js`**: Admin interface functionality
- **`modal-customization-admin.js`**: Customization interface functionality

##### CSS Stylesheets
- **`acf-flexible-modal.css`**: Main modal styling
- **`usage-modal.css`**: Usage information modal styling
- **`module-descriptions-admin.css`**: Admin interface styling
- **`modal-customization-admin.css`**: Customization interface styling
- **`module-descriptions-responsive.css`**: Responsive design rules

#### 4. API Endpoints
Located in `/endpoints/` directory:

All endpoints follow WordPress AJAX conventions and return JSON responses:

- **`get-preview-images.php`**: Returns available preview images
- **`get-module-usage.php`**: Provides module usage statistics across the site
- **`get-modal-templates.php`**: Serves modal HTML templates
- **`get-module-description.php`**: Returns module descriptions
- **`upload-module-preview.php`**: Handles preview image uploads
- **`get-admin-templates.php`**: Serves admin interface templates
- **`get-branding-logo.php`**: Returns current branding logo URL
- **`get-modal-background.php`**: Returns modal background color settings

#### 5. Templates
Located in `/templates/` directory:

- **`modal.php`**: Main module selection modal
- **`usage-modal.php`**: Module usage information display
- **`loading.php`**: Loading state template
- **`error.php`**: Error state template

Admin templates in `/admin/templates/`:
- **`modules-table.php`**: Module management table
- **`edit-form.php`**: Module editing interface
- **`current-preview.php`**: Preview image display
- **`image-upload-section.php`**: Image upload interface
- **`status-message.php`**: Status notifications

## Key Features

### 1. Visual Module Selection
- **Modal Interface**: Clean, modern modal replaces ACF's default dropdown
- **Preview Images**: Visual thumbnails for each module/hero
- **Search Functionality**: Real-time filtering by module name or label
- **Responsive Design**: Works across desktop and mobile devices

### 2. Module Usage Tracking
- **Site-wide Analysis**: Shows where each module is currently used
- **Page Type Filtering**: Filter usage by page types (pages, posts, etc.)
- **Direct Links**: Quick access to edit pages using specific modules
- **Usage Statistics**: Count of total implementations per module

### 3. Content Management
- **Description System**: Rich text descriptions for each module
- **Preview Management**: Upload and manage preview images
- **Bulk Operations**: Efficient management of multiple modules
- **Auto-discovery**: Automatically detects new ACF layouts

### 4. Customization Options
- **Branding**: Upload company logos for modal headers
- **Color Schemes**: Customize modal background colors
- **Responsive Images**: Support for multiple image formats and sizes
- **Live Preview**: Real-time preview of customization changes

### 5. Developer Features
- **Modular Architecture**: Clean separation of concerns
- **API-driven**: RESTful approach to data management
- **Extensible**: Easy to add new features and endpoints
- **Performance Optimized**: Efficient asset loading and caching

## Technical Implementation

### Data Flow

1. **Initialization**: System loads and registers all components
2. **User Interaction**: User clicks "Add Layout" button in ACF
3. **Interception**: JavaScript intercepts the click and prevents default behavior
4. **Data Fetching**: System fetches available layouts, preview images, and branding
5. **Modal Display**: Custom modal is rendered with visual options
6. **Selection**: User selects a module or views usage information
7. **Integration**: Selected layout is added to ACF field

### Security Measures

- **Nonce Verification**: All AJAX requests include WordPress nonces
- **File Validation**: Strict file type and size validation for uploads
- **Sanitization**: All user inputs are sanitized and validated
- **Permission Checks**: Admin-only access to management interfaces
- **Path Security**: Dynamic path resolution prevents directory traversal

### Performance Optimizations

- **Asset Versioning**: File modification time-based cache busting
- **Conditional Loading**: Assets loaded only when needed
- **Lazy Loading**: Preview images loaded on demand
- **Efficient Queries**: Optimized database queries for module discovery
- **Caching**: Strategic use of WordPress options for frequently accessed data

## Installation and Setup

### Requirements
- WordPress 5.0+
- Advanced Custom Fields Pro plugin
- PHP 7.4+
- Modern browser with JavaScript enabled

### Integration
The system is designed to be included in WordPress themes. It automatically:
1. Detects ACF flexible content fields
2. Registers admin menu items
3. Enqueues necessary assets
4. Sets up AJAX endpoints

### Configuration
No additional configuration required - the system works out of the box with any ACF flexible content setup.

## Usage Guide

### For Content Creators
1. **Adding Modules**: Click "Add Layout" button to open visual selector
2. **Searching**: Use search bar to find specific modules
3. **Preview**: View module thumbnails before selection
4. **Information**: Click info button to see module usage and description

### For Administrators
1. **Access**: Navigate to "Module Docs" in WordPress admin
2. **Manage Descriptions**: Add/edit descriptions for modules
3. **Upload Previews**: Add preview images for visual selection
4. **Customize Appearance**: Use "Customize Modal" to brand the interface

## File Structure

```
visual-acf-modules/
├── init.php                          # Main initialization file
├── admin/                            # Admin interface components
│   ├── modal-customization.php       # Branding and appearance settings
│   ├── module-descriptions.php       # Module management interface
│   └── templates/                    # Admin template files
├── assets/                           # Frontend assets
│   ├── css/                         # Stylesheets
│   ├── js/                          # JavaScript files
│   ├── branding/                    # Uploaded branding assets
│   └── previews/                    # Module preview images
├── endpoints/                        # API endpoints
│   ├── get-preview-images.php       # Preview image API
│   ├── get-module-usage.php         # Usage tracking API
│   └── [other endpoints]            # Additional API endpoints
└── templates/                        # Frontend templates
    ├── modal.php                    # Main selection modal
    ├── usage-modal.php              # Usage information modal
    └── [other templates]            # Additional templates
```

## API Reference

### JavaScript API (ACFApiService)

#### Core Methods
- `post(action, params)`: Make AJAX POST request
- `upload(action, formData, onProgress)`: Upload files with progress tracking
- `getPreviewImages()`: Fetch all preview images
- `getBrandingLogo()`: Get current branding logo
- `getModalBackground()`: Get modal background color

#### Template Methods
- `getModalTemplate(template, data)`: Get modal templates
- `getUsageModalTemplate(params)`: Get usage modal template

#### Module Methods
- `getModuleUsage(moduleName, fieldType)`: Get module usage data
- `getModuleDescription(moduleName)`: Get module description
- `uploadModulePreview(moduleSlug, file, onProgress)`: Upload preview image

### PHP Hooks and Filters

The system uses standard WordPress hooks:
- `admin_menu`: Register admin pages
- `admin_enqueue_scripts`: Load assets
- `wp_ajax_*`: AJAX endpoint registration

## Troubleshooting

### Common Issues

1. **Modal Not Appearing**
   - Check if ACF Pro is installed and active
   - Verify JavaScript console for errors
   - Ensure flexible content fields are properly configured

2. **Preview Images Not Loading**
   - Check file permissions on `/assets/previews/` directory
   - Verify image file formats (PNG, JPG, SVG, WebP supported)
   - Check browser network tab for failed requests

3. **Admin Interface Issues**
   - Verify user has `manage_options` capability
   - Check for plugin conflicts
   - Review PHP error logs

### Debug Mode
Enable WordPress debug mode to see detailed error information:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

### Extension Points
The system is designed for extensibility:
- Custom endpoints can be added to `/endpoints/`
- Additional templates can be created in `/templates/`
- CSS can be customized through WordPress theme integration
- JavaScript events allow for custom functionality integration

## Conclusion

The Visual ACF Modules system significantly enhances the content creation experience in WordPress by providing a modern, visual interface for ACF flexible content. Its modular architecture, comprehensive feature set, and focus on user experience make it an essential tool for content-heavy WordPress sites using ACF.

The system successfully bridges the gap between developer-friendly ACF configurations and user-friendly content creation interfaces, resulting in improved productivity and reduced training requirements for content creators.
