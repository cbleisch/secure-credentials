<?php


return [

    /**
     * The Herbert version constraint.
     */
    'constraint' => '~0.9.9',

    /**
     * Auto-load all required files.
     */
    'requires' => [
        __DIR__ . '/app/customPostTypes.php',
        __DIR__ . '/app/twigExtension.php',
        __DIR__ . '/app/Hooks/ScheduleSetup.php'
    ],
    
    /**
     * The tables to manage.
     */
    'tables' => [
        'sc_secure_credentials',
        'sc_secure_users'
    ],


    /**
     * Activate
     */
    'activators' => [
        __DIR__ . '/app/activate.php'
    ],

    /**
     * Deactivate
     */
    'deactivators' => [
        __DIR__ . '/app/deactivate.php'
    ],

    /**
     * The shortcodes to auto-load.
     */
    'shortcodes' => [
        __DIR__ . '/app/shortcodes.php'
    ],

    /**
     * The widgets to auto-load.
     */
    'widgets' => [
        __DIR__ . '/app/widgets.php'
    ],

    /**
     * The styles and SecureCredentialsripts to auto-load.
     */
    'enqueue' => [
        __DIR__ . '/app/enqueue.php'
    ],

    /**
     * The routes to auto-load.
     */
    'routes' => [
        'SecureCredentials' => __DIR__ . '/app/routes.php'
    ],

    /**
     * The panels to auto-load.
     */
    'panels' => [
        'SecureCredentials' => __DIR__ . '/app/panels.php'
    ],

    /**
     * The APIs to auto-load.
     */
    'apis' => [
        'SecureCredentials' => __DIR__ . '/app/api.php'
    ],

    /**
     * The view paths to register.
     *
     * E.G: 'SecureCredentials' => __DIR__ . '/views'
     * can be referenced via @SecureCredentials/
     * when rendering a view in twig.
     */
    'views' => [
        'SecureCredentials' => __DIR__ . '/resources/views'
    ],

    /**
     * The view globals.
     */
    'viewGlobals' => [

    ],

    /**
     * The asset path.
     */
    'assets' => '/resources/assets/',
    'loading_url' => plugin_dir_url(__FILE__) . 'resources/assets/img/preloader.gif'
];

