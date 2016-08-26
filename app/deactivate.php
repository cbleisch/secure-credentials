<?php

/** @var  \Herbert\Framework\Application $container */
/** @var  \Herbert\Framework\Http $http */
/** @var  \Herbert\Framework\Router $router */
/** @var  \Herbert\Framework\Enqueue $enqueue */
/** @var  \Herbert\Framework\Panel $panel */
/** @var  \Herbert\Framework\Shortcode $shortcode */
/** @var  \Herbert\Framework\Widget $widget */

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->dropIfExists('sc_secure_users');
Capsule::schema()->dropIfExists('sc_secure_credentials');
Capsule::schema()->dropIfExists('sc_secure_credential_users');

wp_clear_scheduled_hook('remove_credentials');