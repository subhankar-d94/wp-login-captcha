<?php
/**
 * @package wp-login-captcha
 * @version 1.0
 */
/*
Plugin Name: WP Login Captcha
Author: Subhankar Dutta
Description: WP login captcha used for login captcha validation.
Version: 1.0
Author URI: https://github.com/subhophp
*/

defined( 'ABSPATH' ) or die('hey, you can\t access this file, you silly human!');

define( 'LOGIN_CAPTCHA_URL', plugins_url( '', __FILE__ ) );
define( 'LOGIN_CAPTCHA_PATH', plugin_dir_path( __FILE__ ) );
define( 'LOGIN_CAPTCHA_REL_PATH', dirname( plugin_basename( __FILE__ ) ) . '/' );

add_action('login_form','captcha_login_field');
function captcha_login_field(){
?>
<p>
    	<img src="<?php echo LOGIN_CAPTCHA_URL; ?>/captcha.php?rand=<?php echo rand();?>" id='captchaimg'>
    	<br>
        <label for="my_extra_field">
        	Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.<br>
        	Enter the code above here :
        <input type="text" tabindex="20" size="20" value="" class="input" id="captcha_code" name="captcha_code">
        </label>
    </p>
<?php
 } 

add_filter('wp_authenticate_user','wp_validate_login_captcha',10,2);
function wp_validate_login_captcha($user, $password) {
  session_start();
  $return_value = $user;
  if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){
  	$return_value = new WP_Error( 'loginCaptchaError', 'Captcha Error. Please try again.' );
  }

return $return_value;
}
add_action( 'login_enqueue_scripts', 'enqueue_captcha_script' );

function enqueue_captcha_script() {
    wp_enqueue_script( 'captcha-script', LOGIN_CAPTCHA_URL.'/js/captcha.js', null, null, true );
}