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

    public function user() {
        return $this->belongsTo('SecureCredentials\Models\SercureUser');
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
     * Hash and salt the provided password for encryption
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

    /*
     * Email 
     */
    public function emailCreator($emailOfUser) {
        // Send an HTML styled email
        // add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
        
        // Get important info for headers
        $senderEmail = get_bloginfo('admin_email');
        $siteName = get_bloginfo('name');
        $domain = $_SERVER['HTTP_HOST'];

        // Email parts
        $to = $this->email_to_notify;
        $headers[] = "From: $siteName <$senderEmail>";
        $headers[] = "Reply-to: $siteName <no-reply@$domain>";
        $headers[] = "Content-Type: text/html; charset=UTF-8";
        $subject = $this->title . " was accessed";
        $creator = get_user_by('email', $to);

        $greeting = "Howdy ";
        if(!$creator->user_nicename) {
            $greeting .= "$creator->first_name $creator->last_name,";
        } else {
            $greeting .= "$creator->user_nicename,";
        }

        $message = "<h2>$greeting</h2>
        <p>
        $emailOfUser just accessed $this->title.
        </p>
        <p>
        Thought you &#39;ought to know.
        </p>
        <p>
            <i>&#126; Team $siteName</i>
        </p>
        ";

        // Send the email
        wp_mail( $to, $subject, $message, $headers );
        
        // Avoid conflicts
        // remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
    }
}