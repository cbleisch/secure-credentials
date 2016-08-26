<?php namespace SecureCredentials\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SecureCredential extends Eloquent {
    protected $fillable = ['title'];
    public $timestamps = false;

    protected $table = 'sc_secure_credentials';

    /*
     * The users with access to credentials
     */
    public function users() {
        return $this->belongsToMany('SecureCredentials\Models\SecureUser', 'sc_secure_credential_users', 'secure_credential_id', 'secure_user_id');
    }

    /*
     * The users with access to credentials
     */
    public function hasAccess($email) {
        $users = $this->users->toArray();
        $hasAccess = false;
        foreach ($users as $user) {
        	if(in_array($email, $user)) {
                $hasAccess = true;
            }
        }
        return $hasAccess;
    }
    
    /*
     * hash and salt the provided password for encryption
     */
    public function getSensitive() {
        $getSalty = wp_salt('secure_auth');
        $data = base64_decode($this->password);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $getSalty, true),
                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );
        return $decrypted;
    }
}