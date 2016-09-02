<?php

/** @var  \Herbert\Framework\Application $container */
/** @var  \Herbert\Framework\Http $http */
/** @var  \Herbert\Framework\Router $router */
/** @var  \Herbert\Framework\Enqueue $enqueue */
/** @var  \Herbert\Framework\Panel $panel */
/** @var  \Herbert\Framework\Shortcode $shortcode */
/** @var  \Herbert\Framework\Widget $widget */

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use SecureCredentials\Helper;
use SecureCredentials\Models\SecureCredential;

Capsule::schema()->create('sc_secure_credentials', function($table)
{
    $table->increments('id');
    $table->string('title');
    $table->string('username');
    $table->string('password');
    $table->bigInteger('expiration');
    $table->string('token');
    $table->boolean('notify_when_accessed');
    $table->string('email_to_notify');
});

Capsule::schema()->create('sc_secure_users', function($table)
{
    $table->increments('id');
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email');
});

Capsule::schema()->create('sc_secure_credential_users', function($table)
{
    $table->increments('id');
    $table->integer('secure_credential_id');
    $table->integer('secure_user_id');
});