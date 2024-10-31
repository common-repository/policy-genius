<?php

namespace privacy_policy_genius;

use privacy_policy_genius\admin\ArrayFilter;
use privacy_policy_genius\admin\CharLimitFilter;
use privacy_policy_genius\admin\CheckBoxGroup;
use privacy_policy_genius\admin\HiddenField;
use privacy_policy_genius\admin\RadioGroup;
use privacy_policy_genius\admin\SettingsPage;
use privacy_policy_genius\admin\TextAreaField;
use privacy_policy_genius\admin\UrlFilter;
use privacy_policy_genius\descriptor\Options;
use privacy_policy_genius\util\StringUtils;
use smartcat\admin\CheckBoxField;
use smartcat\admin\MatchFilter;
use smartcat\admin\SelectBoxField;
use smartcat\admin\SettingsSection;
use smartcat\admin\TextField;
use smartcat\admin\TextFilter;

$admin = new SettingsPage(
    array(
        'page_title' => __( 'Privacy Policy', PLUGIN_ID ),
        'menu_title' => __( 'Privacy Guru', PLUGIN_ID ),
        'menu_slug'  => 'privacy_guru',
        'tabs'       => array(
            'general'       => __( 'General', PLUGIN_ID ),
            'policy_config' => __( 'Policy Configuration', PLUGIN_ID ),
			'how_to_use' => __( 'How to use', PLUGIN_ID ),
			'about' => __( 'About', PLUGIN_ID ),
			'audit' => __( 'Audit', PLUGIN_ID ),
			'cookies' => __( 'Cookies', PLUGIN_ID ),
			'version' => __( 'Version', PLUGIN_ID ),			
        )
    )
);

$company_info = new SettingsSection( 'company_info', __( 'Company Information', PLUGIN_ID ) );

$company_info->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_name',
        'option'        => Options::COMPANY_NAME,
        'value'         => get_option( Options::COMPANY_NAME, '' ),
        'label'         => __( 'Company Name', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_address',
        'option'        => Options::COMPANY_ADDRESS,
        'value'         => get_option( Options::COMPANY_ADDRESS, '' ),
        'label'         => __( 'Company Address', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_city',
        'option'        => Options::COMPANY_CITY,
        'value'         => get_option( Options::COMPANY_CITY, '' ),
        'label'         => __( 'Company City', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_phone',
        'option'        => Options::PHONE_NUMBER,
        'value'         => get_option( Options::PHONE_NUMBER, '' ),
        'type'          => 'tel',
        'label'         => __( 'Phone Number', PLUGIN_ID ),
        'required'      => false,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_email',
        'option'        => Options::EMAIL_ADDRESS,
        'value'         => get_option( Options::EMAIL_ADDRESS, '' ),
        'type'          => 'email',
        'label'         => __( 'Email Address', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
        array(
            'id'            => 'privacy_policy_company_website',
            'option'        => Options::WEBSITE,
            'value'         => get_option( Options::WEBSITE, home_url() ),
            'type'          => 'url',
            'placeholder'   => 'http://',
            'label'         => __( 'Website', PLUGIN_ID ),
            'required'      => true,
            'validators'    => array( new UrlFilter() )
        )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_officer_name',
        'option'        => Options::PRIVACY_OFFICER,
        'value'         => get_option( Options::PRIVACY_OFFICER, '' ),
        'label'         => __( 'Name of privacy officer', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) );

$policy_config = new SettingsSection( 'policy_config', __( 'Policy Options', PLUGIN_ID ) );

$date = current_time( 'timestamp' );
$strings = StringUtils::get_strings();
$disposal_options = array( 'destroy' => __( 'Destroy', PLUGIN_ID ), 'erase' => __( 'Erase', PLUGIN_ID ) );
$countries = array( '' => __( 'Select a Country', PLUGIN_ID ) ) + PrivacyPolicy::countries();

$policy_config->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_jurisdiction_country',
        'option'        => Options::JURISDICTION_COUNTRY,
        'value'         => get_option( Options::JURISDICTION_COUNTRY, '' ),
        'options'       => $countries,
        'label'         => __( 'Country of Jurisdiction', PLUGIN_ID ),
        'required'      => true,
        'desc'          => __( 'Country where this policy will apply to', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array_keys( $countries ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_storage_country',
        'option'        => Options::STORAGE_LOCATION,
        'value'         => get_option( Options::STORAGE_LOCATION ),
        'options'       => $countries,
        'label'         => __( 'Storage Location', PLUGIN_ID ),
        'required'      => true,
        'desc'          => __( 'Country where personal information is stored', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array_keys( $countries ), '' ) )
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_data_collection',
        'option'        => Options::DATA_COLLECTION,
        'options'       => StringUtils::localize_strings( $strings['admin_checkbox_groups']['data_collection'] ),
        'value'         => CheckBoxGroup::get_option( Options::DATA_COLLECTION ),
        'label'         => __( 'Data Collected', PLUGIN_ID ),
        'validators'    => array( new ArrayFilter( array_keys( $strings['admin_checkbox_groups']['data_collection'] ) ) )
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_information_use',
        'option'        => Options::INFO_USE,
        'options'       => StringUtils::localize_strings( $strings['admin_checkbox_groups']['information_use'] ),
        'value'         => CheckBoxGroup::get_option( Options::INFO_USE, array() ),
        'label'         => __( 'Use of personal information', PLUGIN_ID ),
        'validators'    => array( new ArrayFilter( array_keys( $strings['admin_checkbox_groups']['information_use'] ) ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_info_transfer',
        'option'        => Options::INFO_DISCLOSURE,
        'value'         => get_option( Options::INFO_DISCLOSURE, '' ),
        'label'         => __( 'Third party disclosure', PLUGIN_ID ),
        'desc'          => __( 'Does your website transfer personal information to third parties?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_transfer_purpose',
        'option'        => Options::TRANSFER_PURPOSE,
        'options'       => StringUtils::localize_strings( $strings['admin_checkbox_groups']['information_transfer'] ),
        'value'         => CheckBoxGroup::get_option( Options::TRANSFER_PURPOSE ),
        'label'         => __( 'Purposes of transfer', PLUGIN_ID ),
        'validators'    => array( new ArrayFilter( array_keys( $strings['admin_checkbox_groups']['information_transfer'] ) ) )
    )

) )->add_field( new RadioGroup(
    array(
        'id'            => 'privacy_policy_destroy_information',
        'option'        => Options::INFO_DISPOSAL,
        'value'         => get_option( Options::INFO_DISPOSAL, '' ),
        'break'         => true,
        'required'      => true,
        'label'         => __( 'Information disposal method', PLUGIN_ID ),
        'desc'          => __( 'How do you dispose personal information?', PLUGIN_ID ),
        'options'       => $disposal_options,
        'validators'    => array( new MatchFilter( array_keys( $disposal_options ), '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_age_usage',
        'option'        => Options::CHILD_USAGE,
        'value'         => get_option( Options::CHILD_USAGE, '' ),
        'label'         => __( 'Usage of website by children', PLUGIN_ID ),
        'desc'          => __( 'Is your website used by children under 13 years of age?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_cookies_usage',
        'option'        => Options::COOKIES_USAGE,
        'value'         => get_option( Options::COOKIES_USAGE, '' ),
        'label'         => __( 'Usage of cookies', PLUGIN_ID ),
        'desc'          => __( 'Does your website use cookies?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new HiddenField(
    array(
        'id'            => 'privacy_policy_last_updated',
        'option'        => Options::LAST_CONFIGURED,
        'value'         => $date,
        'validators'    => array( new MatchFilter( array( $date ), $date ) )
    )

) );

$general = new SettingsSection( 'general', __( 'Cookies Usage Notification', PLUGIN_ID ) );
$position = array( 'left' => __( 'Left', PLUGIN_ID ), 'top' => __( 'Top', PLUGIN_ID ), 'bottom' => __( 'Bottom', PLUGIN_ID ), 'right' => __( 'Right', PLUGIN_ID ) );
//$position = array("a","b");
$general->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_display_cookie',
        'option'        => Options::DISPLAY_COOKIE_WARNING,
        'value'         => get_option( Options::DISPLAY_COOKIE_WARNING, Options\Defaults::DISPLAY_COOKIE_WARNING ),
        'label'         => __( 'Display Usage Notification', PLUGIN_ID ),
        'desc'          => __( 'Display cookie warning to visitors of your website', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_cookie_title',
        'option'        => Options::COOKIE_WARN_TITLE,
        'value'         => get_option( Options::COOKIE_WARN_TITLE, Options\Defaults::COOKIE_WARN_TITLE ),
        'label'         => __( 'Notification Title', PLUGIN_ID ),
        'desc'          => __( 'Title to display on notification', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
) )->add_field( new TextAreaField(
    array(
        'id'            => 'privacy_policy_cookie_message',
        'option'        => Options::COOKIE_WARN_MESSAGE,
        'size'          => array( 50, 10 ),
        'max_chars'     => 500,
        'value'         => get_option( Options::COOKIE_WARN_MESSAGE, Options\Defaults::COOKIE_WARN_MESSAGE ),
        'label'         => __( 'Notification Message', PLUGIN_ID ),
        'desc'          => __( 'Message to display on notification (500 characters Max.)', PLUGIN_ID ),
        'validators'    => array( new TextFilter(), new CharLimitFilter( 500, '...' ) )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_cookie_accept_btn_text',
        'option'        => Options::COOKIE_ACCEPT_BTN_TEXT,
        'value'         => get_option( Options::COOKIE_ACCEPT_BTN_TEXT, Options\Defaults::COOKIE_ACCEPT_BTN_TEXT ),
        'label'         => __( 'Accept Button Text', PLUGIN_ID ),
        'desc'          => __( 'Text to display on notification accept button', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_cookie_decline_btn_text',
        'option'        => Options::COOKIE_DECLINE_BTN_TEXT,
        'value'         => get_option( Options::COOKIE_DECLINE_BTN_TEXT, Options\Defaults::COOKIE_DECLINE_BTN_TEXT ),
        'label'         => __( 'Decline  Button Text', PLUGIN_ID ),
        'desc'          => __( 'Text to display on notification decline  button', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_url',
        'type'          => 'url',
        'option'        => Options::POLICY_URL,
        'value'         => get_option( Options::POLICY_URL, '' ),
        'label'         => __( 'Policy Page URL', PLUGIN_ID ),
        'placeholder'   => 'http://',
        'desc'          => __( 'URL of page containing privacy policy', PLUGIN_ID ),
        'validators'    => array( new UrlFilter() )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_url_text',
        'option'        => Options::COOKIE_WARN_URL_TEXT,
        'value'         => get_option( Options::COOKIE_WARN_URL_TEXT, Options\Defaults::COOKIE_WARN_URL_TEXT ),
        'label'         => __( 'Policy URL Text', PLUGIN_ID ),
        'desc'          => __( 'Text to display for link to privacy policy', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
) )->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_popup_position',
        'option'        => Options::DISPLAY_POPUP_POSITION,
        'value'         => get_option( Options::DISPLAY_POPUP_POSITION ),
        'options'       => $position,
        'label'         => __( 'Choose position', PLUGIN_ID ),
        'required'      => true,
        'desc'          => __( 'Select where info-box will be display.', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array_keys( $position ), '' ) )
    )
))->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_background_color',
        'option'        => Options::POLICY_BACKGROUND,
        'value'         => get_option( Options::POLICY_BACKGROUND, Options\Defaults::POLICY_BACKGROUND ),
        'label'         => __( 'Color', PLUGIN_ID ),
        'desc'          => __( 'Info-box backgroud color', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
))->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_font_color',
        'option'        => Options::POLICY_FONT_COLOR,
        'value'         => get_option( Options::POLICY_FONT_COLOR, Options\Defaults::POLICY_FONT_COLOR ),
        'label'         => __( '', PLUGIN_ID ),
        'desc'          => __( 'Info-box font color', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
))->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_accept_button_color',
        'option'        => Options::POLICY_ACCEPT_COLOR,
        'value'         => get_option( Options::POLICY_ACCEPT_COLOR, Options\Defaults::POLICY_ACCEPT_COLOR ),
        'label'         => __( '', PLUGIN_ID ),
        'desc'          => __( 'Info-box font color', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
))->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_button_accept_background_color',
        'option'        => Options::POLICY_ACCEPT_BACKGROUND_COLOR,
        'value'         => get_option( Options::POLICY_ACCEPT_BACKGROUND_COLOR, Options\Defaults::POLICY_ACCEPT_BACKGROUND_COLOR ),
        'label'         => __( '', PLUGIN_ID ),
        'desc'          => __( 'Accept button background color', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
));


$how_to_use = new SettingsSection( 'how_to_use', __( '', PLUGIN_ID ) );

$how_to_use->add_field( new TextAreaField(
    array(
        'id'            => 'privacy_policy_cookie_how_to_use',
        'option'        => Options::COOKIE_WARN_MESSAGE,
        'size'          => array( 50, 10 ),
        'max_chars'     => 500,
        'value'         => "The Policy Genius generates displays a privacy policy using a short code. It also creates Cookie Notice to inform users that your site uses cookies and to comply with the EU cookie law regulations.

During setup you provide: a) You configure your cookie notice b) company info, c) data protection, d) and handling practices

WP Policy Genius generates a privacy policy based on your answers. Where is data stored? What safeguards are in place? This Plugin allows you to create a privacy policy for your users in less than 10 minutes.

Contributors to this plugin are [KI Design] (https://kidesign.io) & [Smartcat Design] (https://smartcatdesign.net/)",
        
    )
) );


$version = new SettingsSection( 'version', __( '', PLUGIN_ID ) );

$version->add_field( new TextAreaField(
    array(
        'id'            => 'privacy_policy_cookie_version',
        'option'        => Options::COOKIE_WARN_MESSAGE,
        'size'          => array( 50, 10 ),
        'max_chars'     => 500,
        'value'         => "Version 1.01",
        'desc'          => __( 'Message to display on notification (500 characters Max.)', PLUGIN_ID ),
        'validators'    => array( new TextFilter(), new CharLimitFilter( 500, '...' ) )
    )
) );

$about = new SettingsSection( 'About', __( '', PLUGIN_ID ) );
$about->add_field( new TextAreaField(
    array(
        'id'            => 'privacy_policy_cookie_about',
        'option'        => Options::COOKIE_WARN_MESSAGE,
        'size'          => array( 50, 10 ),
        'max_chars'     => 500,
        'value'         => "At KI Design, we believe that privacy is a differentiator that builds a better brand, consolidates public trust and improves competitive advantage. Our privacy training and consultation enables organizations to integrate privacy controls into the design of technologies and business processes that handle personal data.",
        'desc'          => __( 'Message to display on notification (500 characters Max.)', PLUGIN_ID ),
        'validators'    => array( new TextFilter(), new CharLimitFilter( 500, '...' ) )
    )
) );

$audit = new SettingsSection( 'Audit', __( '', PLUGIN_ID ) );
$audit->add_field( new TextAreaField(
    array(
        'id'            => 'privacy_policy_cookie_audit',
        'option'        => Options::COOKIE_WARN_MESSAGE,
        'size'          => array( 50, 10 ),
        'max_chars'     => 500,
        'validators'    => array( new TextFilter(), new CharLimitFilter( 500, '...' ) )
    )
) );

$cookies = new SettingsSection( 'Audit', __( '', PLUGIN_ID ) );
$cookies->add_field( new TextAreaField(
    array(
        'id'            => 'privacy_policy_cookies',
        'option'        => Options::COOKIE_WARN_MESSAGE,
        'size'          => array( 50, 10 ),
        'max_chars'     => 500,
        'validators'    => array( new TextFilter(), new CharLimitFilter( 500, '...' ) )
    )
) );
$admin->add_section( $company_info, 'policy_config' );
$admin->add_section( $policy_config, 'policy_config' );
$admin->add_section( $general, 'general' );
$admin->add_section( $how_to_use, 'how_to_use' );
$admin->add_section( $version, 'version' );
$admin->add_section( $about, 'about' );
$admin->add_section( $audit, 'site_audit' );
$admin->add_section( $cookies, 'cookies' );

return $admin;
