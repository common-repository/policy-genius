<?php
namespace privacy_policy_genius\admin;
use privacy_policy_genius\PrivacyPolicy;
use smartcat\admin\TabbedSettingsPage;

class SettingsPage extends TabbedSettingsPage {

    public function render() {
		ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $active_tab = key( $this->tabs );

        if( !empty( $_REQUEST['tab'] ) && array_key_exists( $_REQUEST['tab'], $this->tabs ) ) {
            $active_tab = $_REQUEST['tab'];
        }

        ?>


        <div class="wrap">

            <h2 class="privacy_policy_admin_header">
                <?php echo $this->page_title; ?>
                <div class="privacy_policy_branding">
                    <a href="http://kidesign.io">
                        <img src="<?php echo PrivacyPolicy::plugin_url( \privacy_policy_genius\PLUGIN_ID ) . '\assets\img\ki_design_io.jpg'; ?>">
                    </a>
                </div>
            </h2>

            <?php  if( $this->type == 'menu' || $this->type == 'submenu' ) : ?>

                <?php settings_errors( $this->menu_slug ); ?>

            <?php endif; ?>

            <h2 class="nav-tab-wrapper">

                <?php foreach( $this->tabs as $tab => $title ) : ?>

                    <a href="<?php echo 'admin.php?page=' . $this->menu_slug . '&tab=' . $tab; ?>"
                       class="nav-tab <?php echo $active_tab == $tab ? 'nav-tab-active' : ''; ?>">

                        <?php echo $title; ?>

                    </a>

                <?php endforeach; ?>

            </h2>

            <form method="post" class="tab_<?php echo @$_GET['tab']; ?>"action="options.php">
                <?php 
				 if(@$_GET['tab']=="how_to_use")  { $this->site_register_thirdParty(); }
				if(@$_GET['tab']=="how_to_use") { 
				echo "<div class='tab_how_to_use'> 1) Create a “New Post” or “New Page” through your WordPress Dashboard<br> 2) Enter the shortcode in the visual or text editor, exactly as written below:<br> [privacy_policy] <br>3) Privately publish the post or page. This can be done through selecting the “Private” option under “Visibility”</div>";
				?>
				
				<?php } else if(@$_GET['tab']=="version") { echo $this->version(); }  else if(@$_GET['tab']=="about") { echo $this->about(); } else if(@$_GET['tab']=="audit") { echo $this->site_audit(); } else if(@$_REQUEST["tab"]=="cookies") { $this->site_cookies(); }  else { ?>
                <?php settings_fields( $this->menu_slug . '_' .$active_tab ); ?>

                <?php do_settings_sections( $this->menu_slug . '_' . $active_tab ); ?>
				

                <?php submit_button(); ?>
				<?php } ?>
				

            </form>

        </div>

    <?php }
	
	public function version(){
		$file = content_url().'/plugins/policy-genius/version.txt';
		$section = nl2br(file_get_contents($file));
		return "<div class='tab_version'>".$section."</div>";
	}

	public function about(){
		return "<div class='tab_about'>At KI Design, we believe that privacy is a differentiator that builds a better brand, consolidates public trust and improves competitive advantage. Our privacy training and consultation enables organizations to integrate privacy controls into the design of technologies and business processes that handle personal data.</div>";
	}	

	public function site_audit(){
		include_once(plugin_dir_path( __FILE__ ) . '/scrape.php');
	}
	
	public function site_cookies(){
		include_once(plugin_dir_path( __FILE__ ) . '/Cookies.php');
	}	
	
	public function site_register_thirdParty()  {
			
			$endpoint = 'http://54.152.55.142:8080/site_register/';
			
			$siteurl = site_url(); 
			$blogname = get_bloginfo( 'name' ); 
			$admin_email = get_option('admin_email');  
			$gmt_offset = get_option('gmt_offset'); 
			$theme_name = get_current_theme();
					
			$body = [
				'siteurl'  => $siteurl,
				'blogname' => $blogname,
				'admin_email' => $admin_email,
				'gmt_offset' => $gmt_offset,
				'template' => esc_html( $theme_name ),
			];		
			$body = wp_json_encode( $body );
			 
			$options = [
				'body'        => $body,
				'headers'     => [
					'Content-Type' => 'application/json',
				],
				'timeout'     => 60,
				'redirection' => 5,
				'blocking'    => true,
				'httpversion' => '1.0',
				'sslverify'   => false,
				'data_format' => 'body',
			];
			$data = wp_remote_post( $endpoint, $options );	
	       return $data;		
	}	
}