<?php namespace SecureCredentials\Controllers;

use Herbert\Framework\Router;
use Herbert\Framework\Http;
use Herbert\Framework\Notifier;
use SecureCredentials\Helper;
use SecureCredentials\Models\SecureUser;

class UserController {

    /**
     * return: Users page
     */
    public function index()
    {
    	$users = SecureUser::all();
        $loading_url = Helper::get("loading_url");
        return view('@SecureCredentials/users/index.twig', ['users' => $users, 'loading_url' => $loading_url]);
    }

    /*
     * Return content for create modal via ajax
     */
    public function createModal() {
        return view('@SecureCredentials/users/partials/create.twig');
    }

    /*
     * Return content for delete modal via ajax
     */
    public function deleteModal($id) {
        $user = SecureUser::find($id);
        return view('@SecureCredentials/users/partials/delete.twig', ['user' => $user ]);
    }

    /*
     * Return content for update modal via ajax
     */
    public function updateModal($id) {
        $user = SecureUser::find($id);
        return view('@SecureCredentials/users/partials/update.twig', ['user' => $user ]);
    }

    /*
     * Post user data modal via ajax
     */
    public function store(Http $http) {
        $dup = SecureUser::where('email', $http->get('email'))->first();
        // are we updating a user
        if(!empty($http->get('update'))) {
            $user = SecureUser::find($http->get('update'));
        }
        // this is supposed to be a new user, but there's a duplicate email
        elseif(empty($http->get('update')) && $dup) {
            $user = $dup;
        }
        // it's a brand new user
        else {
            $user = new SecureUser;
        }
        // fill in and save that user!
        $user->fill($http->all());
        $user->save();
    }

    /*
     * Delete a single user via ajax
     */
    public function delete(Http $http) {
        $user = SecureUser::find($http->get('id'));
        $user->credentials()->detach();
        if($user->delete()) {
            return json_encode(['status' => 'success', 'message' => 'user deleted']);
        } else {
            return json_encode(['status'=> 'error', 'message'=> 'error deleting']);
        }
    }

    /*
     * Return all $users
     */
    public function getUsers() {
        $users = SecureUser::all();
        return view('@SecureCredentials/users/partials/users.twig', ['users' => $users]);
    }

    /*
     * Display modal with all $credentials a $user has access to via ajax
     */
    public function credentialsModal($id) {
        $user = SecureUser::find($id);
        $credentials = $user->credentials()->get();
        return view('@SecureCredentials/users/partials/credentials.twig', ['user' => $user, 'credentials' => $credentials, 'domain' => $_SERVER['HTTP_HOST']]);
    }

    /*
     * Remove a $users access to a $credential
     */
    public function revokeCredentialAccess($user_id, $credential_id) {
        $user = SecureUser::find($user_id);
        $user->credentials()->detach($credential_id);
        return view('@SecureCredentials/users/partials/credentials.twig', ['user' => $user, 'credentials' => $credentials]);
    }
}