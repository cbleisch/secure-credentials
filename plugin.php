<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Secure Credentials
 * Plugin URI:        http://plugin-name.com/
 * Description:       Securely share login credentials with others.
 * Version:           1.0.0
 * Author:            Charles Bleisch
 * Author URI:        http://author.com/
 * License:           MIT
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';

// herbert('Twig_Environment')->addExtension(new SecureCredentials\TwigExtension\WordpressTemplateExtension());