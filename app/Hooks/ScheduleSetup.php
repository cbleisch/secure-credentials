<?php

use Carbon\Carbon;
use SecureCredentials\Helper;
use SecureCredentials\Models\SecureCredential;

/*
 * Create a new scheduled event
 * Runs hourly
 */
if (! wp_next_scheduled ( 'remove_credentials' )) {
    wp_schedule_event(time(), 'hourly', 'remove_credentials');
}
/*
 * Link hourly event with remove_expired_credentials funciton
 */
add_action('remove_credentials', 'remove_expired_credentials');

/*
 * Find and delete expired credentials
 */
function remove_expired_credentials() {
    $credentials = SecureCredential::all();

    foreach($credentials as $credential) {
        $expiration = Carbon::createFromTimestampUTC($credential->expiration);

        if($expiration->isPast()) {
            $credential->delete();
        }
    }
}