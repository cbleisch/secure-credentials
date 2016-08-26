<?php namespace SecureCredentials\Controllers;

use Carbon\Carbon;
use Herbert\Framework\Router;
use Herbert\Framework\Http;
use Herbert\Framework\Notifier;
use SecureCredentials\Helper;
use SecureCredentials\Models\SecureUser;
use SecureCredentials\Models\SecureGUID;
use SecureCredentials\Models\SecureCredential;

class CredentialController {

    /**
     * return: Admin settings page
     */
    public function index()
    {
        $credentials = SecureCredential::all();
    	$users = SecureUser::get()->toArray();
        $loading_url = Helper::get("loading_url");
        return view('@SecureCredentials/credentials/index.twig', ['credentials' => $credentials, 'users' => $users, 'domain' => $_SERVER['HTTP_HOST'], 'loading_url' => $loading_url]);
    }

    public function createModal() {
        $users = SecureUser::all();

        return view('@SecureCredentials/credentials/partials/create.twig', ['users' => $users]);
    }

    public function updateModal($id) {
        $credential = SecureCredential::find($id);
        $users = SecureUser::all();

        return view('@SecureCredentials/credentials/partials/update.twig', ['credential' => $credential , 'users' => $users ]);
    }

    public function deleteModal($id) {
        $credential = SecureCredential::find($id);
        return view('@SecureCredentials/credentials/partials/delete.twig', ['credential' => $credential ]);
    }

    public function store(Http $http) {
    	$expiration = Carbon::now()->addHours($http->get('expiration'));
        $guid = new SecureGUID;
        $getSalty = wp_salt('secure_auth');

        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
            MCRYPT_DEV_URANDOM
        );

        $encrypted = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $getSalty, true),
                $http->get('password'),
                MCRYPT_MODE_CBC,
                $iv
            )
        );

        // are we updating a credential?
        if(!empty($http->get('update'))) {
            $credential = SecureCredential::find($http->get('update'));
        }
        // it's a brand new credential
        else {
            $credential = new SecureCredential;
            $credential->token = $guid->getGUID();
        }
        // fill in and save that user!
        $credential->title = $http->get('title');
        $credential->username = $http->get('username');
        $credential->password = $encrypted;
        $credential->expiration = $expiration->timestamp;
        $credential->save();
        $credential->users()->sync($http->get('users'));
    }

    public function delete(Http $http) {
        $credential = SecureCredential::find($http->get('id'));
        $credential->users()->detach();
        if($credential->delete()) {
            return json_encode(['status' => 'success', 'message' => 'credential deleted']);
        } else {
            return json_encode(['status'=> 'error', 'message'=> 'error deleting']);
        }
    }

    public function getCredentials() {
        $credentials = SecureCredential::all();
        return view('@SecureCredentials/credentials/partials/credentials.twig', ['credentials' => $credentials, 'domain' => $_SERVER['HTTP_HOST']]);
    }

    public function getSecureCredential($credential_id, $token) {
        $credential = SecureCredential::where('id', '=', $credential_id)->first(['id', 'token', 'expiration']);
        if(!$credential) {
            return view('@SecureCredentials/frontend/404.twig');
        } elseif($credential && $token == $credential->token && $credential->expiration) {
            $expiration = Carbon::createFromTimestampUTC($credential->expiration);
            if($expiration->isPast()) {
                return view('@SecureCredentials/frontend/404.twig');
            } else {
                return view('@SecureCredentials/frontend/app.twig', ['credential' => $credential]);
            }
        } elseif($credential && $token == $credential->token) {
            return view('@SecureCredentials/frontend/app.twig', ['credential' => $credential]);
        }
    }

    public function validateEmailAndToken(Http $http) {
        $credential = SecureCredential::find($http->get('id'));
        $email = $http->get('email');
        
        if($credential && $http->get('token') == $credential->token && $credential->hasAccess($email)) {
            return view('@SecureCredentials/frontend/credential.twig', ['credential' => $credential]);
        } else {
            return view('@SecureCredentials/frontend/404.twig');
        }
    }

}