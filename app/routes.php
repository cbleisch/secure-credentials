<?php namespace SecureCredentials;

/** @var \Herbert\Framework\Router $router */

/*
 * User Routes
 */
$router->get([
    'as'   => 'getUserCreate',
    'uri'  => '/SecureCredentials/userCreate/get',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@createModal'
]);

$router->post([
    'as'   => 'postUser',
    'uri'  => '/SecureCredentials/userCreate/post',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@store'
]);

$router->get([
    'as'   => 'getUsers',
    'uri'  => '/SecureCredentials/users/get',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@getUsers'
]);

$router->get([
    'as'   => 'getUserDelete',
    'uri'  => '/SecureCredentials/userDelete/{id}/get',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@deleteModal'
]);

$router->post([
    'as'   => 'postUserDelete',
    'uri'  => '/SecureCredentials/userDelete/post',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@delete'
]);

$router->get([
    'as'   => 'getUserEdit',
    'uri'  => '/SecureCredentials/userEdit/{id}/get',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@updateModal'
]);

$router->post([
    'as'   => 'postUserUpdate',
    'uri'  => '/SecureCredentials/userUpdate/post',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@store'
]);

$router->get([
    'as'   => 'getUserCredentials',
    'uri'  => '/SecureCredentials/userCredentials/{id}/get',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@credentialsModal'
]);

/*
 * END User Routes
 */

/*
 * Credential Routes
 */
$router->get([
    'as'   => 'getCredentialCreate',
    'uri'  => '/SecureCredentials/credentialCreate/get',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@createModal'
]);


$router->post([
    'as'   => 'postCredential',
    'uri'  => '/SecureCredentials/credentialCreate/post',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@store'
]);

$router->get([
    'as'   => 'getCredentials',
    'uri'  => '/SecureCredentials/credentials/get',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@getCredentials'
]);

$router->get([
    'as'   => 'secureURL',
    'uri'  => '/SecureCredentials/{credential_id}/{token}',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@getSecureCredential'
]);

$router->post([
    'as'   => 'validateEmailAndToken',
    'uri'  => '/SecureCredentials/validate',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@validateEmailAndToken'
]);

$router->post([
    'as'   => 'validateAuthCode',
    'uri'  => '/SecureCredentials/auth',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@validateAuthCode'
]);

$router->get([
    'as'   => 'getCredentialDelete',
    'uri'  => '/SecureCredentials/credentialDelete/{id}/get',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@deleteModal'
]);

$router->post([
    'as'   => 'postCredentialDelete',
    'uri'  => '/SecureCredentials/credentialDelete/post',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@delete'
]);

$router->get([
    'as'   => 'getCredentialEdit',
    'uri'  => '/SecureCredentials/credentialEdit/{id}/get',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@updateModal'
]);

$router->post([
    'as'   => 'postCredentialUpdate',
    'uri'  => '/SecureCredentials/credentialUpdate/post',
    'uses' => __NAMESPACE__ . '\Controllers\CredentialController@store'
]);

$router->post([
    'as'   => 'postRevokeCredentialAccess',
    'uri'  => '/SecureCredentials/revokeAccess/{user_id}/{credential_id}/post',
    'uses' => __NAMESPACE__ . '\Controllers\UserController@revokeCredentialAccess'
]);

/*
 * END Credential Routes
 */