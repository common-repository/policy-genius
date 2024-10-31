<?php

namespace privacy_policy_genius;

use privacy_policy_genius\descriptor\Options;
use smartcat\core\AbstractPlugin;
use smartcat\core\HookSubscriber;

class PrivacyPolicy extends AbstractPlugin implements HookSubscriber {
     private static $cookie = array(
		'name'	 => 'cookie_info_accepted',
		'value'	 => 'TRUE'
	);
    public function start() {
        $this->add_api_subscriber( $this );
        $this->add_api_subscriber( include_once $this->dir . '/config/admin_settings.php' );

        if( get_option( Options::LAST_CONFIGURED ) != false ) {
            add_shortcode( 'privacy_policy', function () {
                return include_once $this->dir . '/templates/template.php';
            } );
        }

        if( get_option( 'policy-plugin-options' ) != false ) {
            include_once $this->dir . '/migrate.php';
        }
    }

    public function configuration_notice() {
        if( !get_option( Options::LAST_CONFIGURED ) && get_current_screen()->id != 'settings_page_privacy_guru' ) { ?>

                <div class="notice notice-warning is-dismissible">
                    <p>
                        <span class="dashicons dashicons-warning"></span>
                        <?php _e( 'Privacy policy has not been configured', PLUGIN_ID ); ?>
                        <a style="font-weight: bold; text-decoration: none"
                           href="<?php echo menu_page_url( 'privacy_guru', false ) . '&tab=policy_config'; ?>">
                            <?php _e( 'Configure Privacy Policy', PLUGIN_ID ); ?>
                        </a>
                    </p>
                </div>

        <?php }
    }

    public function add_action_links( $links ) {
        return array( 'settings' => '<a href="' . menu_page_url( 'privacy_guru', false ) . '">' . __( 'Settings', PLUGIN_ID ) . '</a>' ) + $links;
    }

    public function get_string_resources() {
        if( empty( $this->strings ) ) {
            $file = file_get_contents( $this->dir . '/res/strings.json' );
            $this->strings = json_decode( $file, true );
        }

        return $this->strings;
    }

    public function enqueue_scripts() {
        if( get_option( Options::DISPLAY_COOKIE_WARNING ) == 'on' ) {
            wp_enqueue_script( 'privacy_policy_genius_cookie_js', $this->url . '/assets/js/cookie.js', array( 'jquery'), PLUGIN_VERSION );
            wp_enqueue_style( 'privacy_policy_genius_cookie_css', $this->url . '/assets/css/cookie.css', null, PLUGIN_VERSION );
            wp_enqueue_style( 'privacy_policy_genius_style_css', $this->url . '/assets/css/style.css', null, PLUGIN_VERSION );
				wp_localize_script('privacy_policy_genius_cookie_js', 'cnArgs',  array(
					'ajaxurl'				=> admin_url( 'admin-ajax.php' ),
					'cookieName'			=> self::$cookie['name'],
					'cookieValue'			=> self::$cookie['value'],
					'cookieTime'			=> '2592000',
					'cis_page'				=> get_permalink(),
					'website'				=> get_site_url(),
					'ipaddress'				=> $this->cis_get_client_ip(),
					'cookiePath'			=> ( defined( 'COOKIEPATH' ) ? COOKIEPATH : '' ),
					'cookieDomain'			=> ( defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '' )
				)
	);
        }
    wp_enqueue_script( 'jquery-core', get_template_directory_uri().'/public/js/all.min.js', array(), false, true );

    $localize_data = array(
    // ....all the stuff I need in my scripts....
    );
    wp_localize_script( 'jquery-core', 'nona', $localize_data );

    // this for compatibility purpose
    wp_register_script( 'jquery', false, array( 'jquery-core' ), false, true );		
		
    }
	
  	public function cis_get_client_ip() {

  		$ipaddress = '';
  		if (isset($_SERVER['HTTP_CLIENT_IP']))
  			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
  			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  		else if(isset($_SERVER['HTTP_X_FORWARDED']))
  			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
  		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
  			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
  		else if(isset($_SERVER['HTTP_FORWARDED']))
  			$ipaddress = $_SERVER['HTTP_FORWARDED'];
  		else if(isset($_SERVER['REMOTE_ADDR']))
  			$ipaddress = $_SERVER['REMOTE_ADDR'];
  		else
  			$ipaddress = 'UNKNOWN';

  		return $ipaddress;
  	}	

    public function enqueue_admin_scripts() {
        wp_enqueue_script( 'privacy_policy_genius_admin_js', $this->url . '/assets/js/admin.js', array( 'jquery'), PLUGIN_VERSION );
        wp_enqueue_style( 'privacy_policy_genius_admin_css', $this->url . '/assets/css/admin.css', null, PLUGIN_VERSION );
		wp_enqueue_script('privacy_policy_genius_admin', plugins_url( $this->url . '/assets/js/admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		wp_enqueue_style( 'wp-color-picker' );
    }

    public function cookies_notification() {
        if( get_option( Options::DISPLAY_COOKIE_WARNING ) == 'on' ) {

            $url = get_option( Options::POLICY_URL );
            $url_text = get_option( Options::COOKIE_WARN_URL_TEXT, Options\Defaults::COOKIE_WARN_URL_TEXT );
            $position = get_option( Options::DISPLAY_POPUP_POSITION, Options\Defaults::DISPLAY_POPUP_POSITION );
			$content = get_option( Options::COOKIE_WARN_MESSAGE, Options\Defaults::COOKIE_WARN_MESSAGE );
			$title = get_option( Options::COOKIE_WARN_TITLE, Options\Defaults::COOKIE_WARN_TITLE );
			$POLICY_BACKGROUND = get_option( Options::POLICY_BACKGROUND, Options\Defaults::POLICY_BACKGROUND );
			$POLICY_FONT_COLOR = get_option( Options::POLICY_FONT_COLOR, Options\Defaults::POLICY_FONT_COLOR );
			$POLICY_ACCEPT_COLOR = get_option( Options::POLICY_ACCEPT_COLOR, Options\Defaults::POLICY_ACCEPT_COLOR );
			$POLICY_ACCEPT_BACKGROUND_COLOR = get_option( Options::POLICY_ACCEPT_BACKGROUND_COLOR, Options\Defaults::POLICY_ACCEPT_BACKGROUND_COLOR );
			?>
			
			<div role="dialog" id="cookie-notice" class="cookie-notifier <?php if($position == ''){ echo 'bottom';} else { echo $position; }?>" <?php 
			  echo 'style="';
			  if($POLICY_BACKGROUND != '') echo 'background-color:'.$POLICY_BACKGROUND.';';
			  if($POLICY_FONT_COLOR != '') echo 'color:'.$POLICY_FONT_COLOR.';';
			  echo '"';  ?> >
			  <!--<div role="dialog" id="cookie-notice" class="cookie-notifier bottom show" style="display: block;">-->
				<span>
				<?php if($content == ''){ ?>
					This website uses cookies, do you agree to be tracked
				<?php }  else  { ?>
				<?php _e( substr($content, 0, 500 ), PLUGIN_ID ); ?>
				<?php } ?>
					<a href="<?php if($url == ''){echo '#';} echo esc_url( $url );;?>" 
					role="button" target="_blank">Learn more </a>	
					
				</span>
				<div class="cn-agree-buttons"> 
					<a class="cn-no cn-button" data-cookie-set="refuse"><?php _e( get_option( Options::COOKIE_DECLINE_BTN_TEXT, Options\Defaults::COOKIE_DECLINE_BTN_TEXT ) ); ?></a>
					<a class="cn-yes cn-button" data-cookie-set="accept" <?php 
					  echo 'style="';
					  if($POLICY_ACCEPT_BACKGROUND_COLOR != '') echo 'background-color:'.$POLICY_ACCEPT_BACKGROUND_COLOR.';';
					  if($POLICY_ACCEPT_COLOR != '') echo 'color:'.$POLICY_ACCEPT_COLOR.';';
					  echo '"';  ?>>
					<?php _e( get_option( Options::COOKIE_ACCEPT_BTN_TEXT, Options\Defaults::COOKIE_ACCEPT_BTN_TEXT ) ); ?>
					 
					</a>	
				</div>
			</div>			

        <?php }
    }

    public function subscribed_hooks() {
        return array(
            'plugin_action_links_' . plugin_basename( $this->file ) => array( 'add_action_links' ),
            'wp_head' => array( 'cookies_notification' ),
            'admin_enqueue_scripts' => array( 'enqueue_admin_scripts' ),
            'wp_enqueue_scripts' => array( 'enqueue_scripts' ),
            'privacy_policy_genius_strings' => array( 'get_string_resources' ),
            'admin_notices' => array( 'configuration_notice' )
        );
    }

    public static function countries() {
        return array(
            'us'        => __( 'The United States', PLUGIN_ID ),
            'ca'        => __( 'Canada', PLUGIN_ID ),
            'uk'        => __( 'The United Kingdom', PLUGIN_ID ),
            'hk'        => __( 'Hong Kong', PLUGIN_ID ),
            'ru'        => __( 'Russia', PLUGIN_ID ),
            'other'     => __( 'Other', PLUGIN_ID )
        );
    }
}
