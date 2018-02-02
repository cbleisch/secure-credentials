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

    /*
     * Show Create Credential Modal with $users via ajax
     */
    public function createModal() {
        $users = SecureUser::all();

        return view('@SecureCredentials/credentials/partials/create.twig', ['users' => $users]);
    }

    /*
     * Show Update Credential Modal with $credential and $users via ajax
     */
    public function updateModal($id) {
        $credential = SecureCredential::find($id);
        $users = SecureUser::all();

        return view('@SecureCredentials/credentials/partials/update.twig', ['credential' => $credential , 'users' => $users ]);
    }

    /*
     * Show Delete Modal with $credential via ajax
     */
    public function deleteModal($id) {
        $credential = SecureCredential::find($id);
        return view('@SecureCredentials/credentials/partials/delete.twig', ['credential' => $credential ]);
    }

    /*
     * Store a credential
     */
    public function store(Http $http) {
        $current_user = wp_get_current_user();
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
        // fill in and save that credential!
        $credential->title = $http->get('title');
        $credential->username = $http->get('username');
        $credential->password = $encrypted;
        $credential->login_url = $http->get('login_url');
        $credential->notes = $http->get('notes');
        $credential->expiration = $expiration->timestamp;

        if(empty($http->get('notify_when_accessed'))) {
            $credential->notify_when_accessed = 0;
        } else {
            $credential->notify_when_accessed = $http->get('notify_when_accessed');
        }
        $credential->email_to_notify = $current_user->user_email;
        $credential->save();
        $credential->users()->sync($http->get('users'));
    }

    /*
     * Delete single credential via ajax
     */
    public function delete(Http $http) {
        $credential = SecureCredential::find($http->get('id'));
        $credential->users()->detach();
        if($credential->delete()) {
            return json_encode(['status' => 'success', 'message' => 'credential deleted']);
        } else {
            return json_encode(['status'=> 'error', 'message'=> 'error deleting']);
        }
    }

    /*
     * Return all $credentials
     */
    public function getCredentials() {
        $credentials = SecureCredential::all();
        return view('@SecureCredentials/credentials/partials/credentials.twig', ['credentials' => $credentials, 'domain' => $_SERVER['HTTP_HOST']]);
    }

    /*
     * Display single $credential on front-end
     */
    public function getSecureCredential($credential_id, $token) {
        // find the first matching credential
        $credential = SecureCredential::where('id', '=', $credential_id)->first(['id', 'token', 'expiration']);
        
        if(!$credential) { // no credential found
            return view('@SecureCredentials/frontend/404.twig');
        } elseif($credential && $token == $credential->token && $credential->expiration) { // a credential was found, and the URL token matches credential's, and the credential expires
            $expiration = Carbon::createFromTimestampUTC($credential->expiration);
            if($expiration->isPast()) { // the credential already expired
                return view('@SecureCredentials/frontend/404.twig');
            } else {
                return view('@SecureCredentials/frontend/app.twig', ['credential' => $credential]); // the credential is valid and hasn't expired
            }
        } elseif($credential && $token == $credential->token) { // a credential was found, and the URL token matches the credential's token, and the credential doesn't expire
            return view('@SecureCredentials/frontend/app.twig', ['credential' => $credential]);
        }
    }

    /*
     * A credential is being accessed
     * Ensure that the user accessing this credential
     * has been granted permission to view the credential
     */
    public function validateEmailAndToken(Http $http) {
        $credential = SecureCredential::find($http->get('id'));
        $email = $http->get('email');
        
        if($credential && $http->get('token') == $credential->token && $credential->hasAccess($email)) {
            if($credential->notify_when_accessed > 0) {
                $credential->emailCreator($email);
            }
            return view('@SecureCredentials/frontend/credential.twig', ['credential' => $credential]);
        } else {
            return view('@SecureCredentials/frontend/404.twig');
        }
    }

}