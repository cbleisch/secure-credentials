<?php namespace SecureCredentials\Controllers;

use Herbert\Framework\Router;
use Herbert\Framework\Http;
use Herbert\Framework\Notifier;
// use SecureCredentials\Models\Settings;

class AdminController {

    /**
     * return: Admin settings page
     */
    public function index()
    {
        return view('@SecureCredentials/admin/info.twig');
        // return view('@NFM/admin/settings.twig', ['settings' => $settings, 'adminUsers' => $adminUsers]);
    }
}