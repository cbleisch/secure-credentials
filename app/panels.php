<?php namespace SecureCredentials;

/** @var \SecureCredentials\Framework\Panel $panel */

$panel->add([
    'type'   => 'panel',
    'as'     => 'secureCredentialsInfo',
    'title'  => 'Secure Credentials',
    'slug'   => 'secure-credentials-info',
    'uses'   => __NAMESPACE__ . '\Controllers\AdminController@index'
]);

$panel->add([
    'type'   => 'sub-panel',
    'parent' => 'secureCredentialsInfo',
    'as'     => 'secureUsers',
    'title'  => 'Users',
    'slug'   => 'secure-users',
    'uses'   => __NAMESPACE__ . '\Controllers\UserController@index'
]);

$panel->add([
    'type'   => 'sub-panel',
    'parent' => 'secureCredentialsInfo',
    'as'     => 'secureUsers',
    'title'  => 'Credentials',
    'slug'   => 'secure-credentials',
    'uses'   => __NAMESPACE__ . '\Controllers\CredentialController@index'
]);