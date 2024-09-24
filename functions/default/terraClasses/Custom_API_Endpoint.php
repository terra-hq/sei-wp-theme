<?php

/**
 * Class Custom_API_Endpoint
 * 
 * This class is used to create custom API endpoints in WordPress using the REST API. It allows
 * the dynamic definition of namespace, route, and the callback function for handling the API request. 
 *  @example
 * new Custom_API_Endpoint((object) array(
 *      'namespace' => 'wp/v2/tf_api/',
 *     'route' => '/another-endpoint',
 *      'method' => 'GET',
 *     'callback_function' => 'another_callback_function',
 * ));
 */
class Custom_API_Endpoint {

    // Properties for the namespace, route, and callback function
    private $namespace;
    private $route;
    private $callback_function;
    private $method;

    /**
     * Constructor to define the namespace, route, and callback function.
     * 
     * @param string $namespace         The namespace for the API route.
     * @param string $route             The specific route or endpoint.
     * @param string $callback_function The function to handle the request.
     */
    public function __construct($config) {
        $this->namespace = $config->namespace;
        $this->route = $config->route;
        $this->callback_function = $config->callback_function;
        $this->method = $config->method;

        // Hook to register the API routes
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    /**
     * Registers the API endpoint with the specified namespace, route, and callback.
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace, // Namespace for the API
            $this->route, // Specific route
            array(
                'methods'  => $this->method, // HTTP method (GET in this case)
                'callback' => $this->callback_function, // Dynamic callback function
                'permission_callback' => '__return_true', // Permissions (allows all requests)
            )
        );
    }
}



?>
