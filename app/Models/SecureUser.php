<?php namespace SecureCredentials\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SecureUser extends Eloquent {
    protected $fillable = ['first_name', 'last_name', 'email'];
    public $timestamps = false;

    protected $table = 'sc_secure_users';

    /*
     * A user can have access to many credentials
     */
    public function credentials() {
        return $this->belongsToMany('SecureCredentials\Models\SecureCredential', 'sc_secure_credential_users', 'secure_user_id', 'secure_credential_id');
    }
}