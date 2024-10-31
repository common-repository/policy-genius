<?php

namespace privacy_policy_genius;

use privacy_policy_genius\admin\CheckBoxGroup;
use privacy_policy_genius\descriptor\Options;
use privacy_policy_genius\util\StringUtils;

$countries = PrivacyPolicy::countries();
$strings = StringUtils::get_strings();

$info_disposal = get_option( Options::INFO_DISPOSAL, '' );
$contact_email = get_option( Options::EMAIL_ADDRESS, '' );
$company = get_option( Options::COMPANY_NAME, '' );
$website = esc_url( get_option( Options::WEBSITE, '' ) );
$country = get_option( Options::JURISDICTION_COUNTRY, '' );
$storage = get_option( Options::STORAGE_LOCATION, '' );
$transfer_purposes = CheckBoxGroup::get_option( Options::TRANSFER_PURPOSE );
$data_collection = CheckBoxGroup::get_option( Options::DATA_COLLECTION );
$information_use = CheckBoxGroup::get_option( Options::INFO_USE );

$date = date_i18n( get_option( 'date_format' ), get_option( Options::LAST_CONFIGURED, '' ) );

ob_start();

?>

<div id="privacy_policy">
    <h3><?php _e( " {$company} Website Privacy Policy", PLUGIN_ID ); ?></h3>
    <p>
        <?php _e( "Last updated {$date}", PLUGIN_ID ); ?>
    </p>
    <p>
        <?php _e( "{$company} (\"us\", \"we\", or \"our\") operates " , PLUGIN_ID ); ?><a href="<?php echo esc_url( $website ); ?>"><?php echo esc_url( $website ); ?></a><?php _e( " the \"Site\", and we are committed to protecting the privacy and security of our users’ and visitors’ personal information. This Privacy Policy (“Policy”) informs you of our policies regarding the collection, use and disclosure of Personal Information we receive from users of the Site. Our privacy procedures have been implemented to comply with " . ( $country == 'other' ? 'National privacy legislation.' : "the privacy legislation of {$countries[ $country ]}." ) , PLUGIN_ID ); ?>
    </p>
    <h3><?php _e( 'Notice and Collection', PLUGIN_ID ); ?></h3>
    <p>
        <?php _e( "While using our Site, we may ask you to provide us with certain information that can be used to contact or identify you. “Personal Information” is any information that is identifiable with you, as an individual.", PLUGIN_ID ); ?>
    </p>

    <?php if( !empty( $data_collection ) ) : ?>

        <p>
            <?php _e( " Personal information we collect may include:", PLUGIN_ID ); ?>
        </p>
        <div>
            <ul>

                <?php foreach( $data_collection as $data ) : ?>

                    <?php if( array_key_exists( $data, $strings['policies']['data_collection'] ) ) : ?>

                        <li><?php _e( $strings['policies']['data_collection'][ $data ], PLUGIN_ID ); ?></li>

                    <?php endif; ?>

                <?php endforeach; ?>

            </ul>
        </div>

    <?php endif; ?>

    <p>
        <?php _e( "Personal Information, however, does not include your name, business title or business address or business telephone number in your capacity as an employee of an organization. {$company} will only collect personal information by fair and lawful means. The provision of personal information is voluntary.", PLUGIN_ID ); ?>
    </p>

    <?php if( !empty( $information_use ) ) : ?>

        <p>
            <?php _e( "{$company} collects personal information for the following purposes:", PLUGIN_ID ); ?>
        </p>
        <div>
            <ul>

                <?php foreach( $information_use as $use ) : ?>

                    <?php if( array_key_exists( $use, $strings['policies']['information_use'] ) ) : ?>

                        <li><?php _e( $strings['policies']['information_use'][ $use ], PLUGIN_ID ); ?></li>

                    <?php endif; ?>

                <?php endforeach; ?>

            </ul>
        </div>

    <?php endif; ?> 
    <?php include_once $this->dir. '/includes/admin/scrape.php'; ?>
    <p>
        <?php _e( "Unless required or permitted by law, we shall not use or disclose your personal information for a new purpose not identified here.", PLUGIN_ID ); ?>
    </p>

    <?php if( get_option( Options::CHILD_USAGE ) == 'on' ) : ?>

        <p>
            <?php _e( "{$company} understands the importance of protecting children’s privacy, especially in an online environment. The Site covered by this Policy does not knowingly collect or maintain information about anyone under the age of 13.", PLUGIN_ID ); ?>
        </p>

    <?php else : ?>

        <p>
            <?php _e( "In certain circumstances, the {$company} Site may collect information from individuals under the age of 13. As required by law, we will give parents direct notice prior to collecting information and receive the parent’s verifiable consent.", PLUGIN_ID ); ?>
        </p>
        <div>
            <ul>
                <li>
                    <?php _e( "{$company}  will not require a child to disclose more information than is reasonably necessary to participate in an activity;", PLUGIN_ID ); ?>
                </li>
                <li>
                    <?php _e( "Parents can review their child’s personal information, direct us to delete it, and refuse to allow any further collection or use of the child’s information;", PLUGIN_ID ); ?>
                </li>
                <li>
                    <?php _e( "Parents can agree to the collection and use of their child’s information, but still not allow disclosure to third parties unless that’s part of the service (for example, social networking);", PLUGIN_ID ); ?>
                </li>
                <li>
                    <?php _e( "To learn more about our privacy procedures, you may contact us at: ", PLUGIN_ID ); ?>
                </li>
            </ul>
        </div>

    <?php endif; ?>

    <h3><?php _e( 'Choice and Consent', PLUGIN_ID ); ?></h3>
    <p>
        <?php _e( "Prior to obtaining your consent, {$company} will describe the choices available to you and obtain implicit or explicit consent with respect to the collection, use, and disclosure of your personal information, except in certain situations otherwise permitted by the law. Where it is reasonable to do so, we may rely on your implied consent. Otherwise, we will rely on explicit consent received directly from you to collect or use your personal information, for example, the collection of your personal information if you subscribe to a newsletter on the Site.", PLUGIN_ID ); ?>
    </p>
    <p>
        <?php _e( "You may withdraw or modify your consent at any time through contacting " . StringUtils::_s( $company, false ) . " Privacy Officer at: ", PLUGIN_ID ); ?><a href="mailto:<?php esc_attr_e( $contact_email ); ?>"><?php echo $contact_email; ?></a>
    </p>
    <h3><?php _e( 'Use and Retention' ); ?></h3>
    <p>
        <?php _e( "{$company} limits the use of personal information to the purposes identified in this Policy and for which the individual has provided implicit or explicit consent. We retain personal information for only as long as it is necessary to fulfill the stated purposes, except with the consent of the individual or as required by law.", PLUGIN_ID ); ?>
    </p>
    <p>
        <?php _e( "Personal information provided to us by users is primarily stored on servers " . ( $storage == 'other' ? 'Internationally' : "in {$countries[ $storage ]}." ), PLUGIN_ID ); ?>
    </p>
    <p>
        <?php _e( "{$company} will {$info_disposal} personal information that is no longer needed.", PLUGIN_ID ); ?>
    </p>
    <h3><?php _e( 'Disclosure to Third Parties', PLUGIN_ID ); ?></h3>

    <?php if( get_option( Options::INFO_DISCLOSURE ) == 'on' && !empty( $transfer_purposes ) ) : ?>

        <p>
            <?php _e( "{$company} transfers personal information to third parties or service providers. We transfer information for the purposes of:", PLUGIN_ID ); ?>
        </p>
        <div>
            <ul>

                <?php foreach( $transfer_purposes as $purpose ) : ?>

                    <?php if( array_key_exists( $purpose, $strings['policies']['information_transfer'] ) ) : ?>

                        <li><?php _e( $strings['policies']['information_transfer'][ $purpose ], PLUGIN_ID );?></li>

                    <?php endif; ?>

                <?php endforeach; ?>

            </ul>
        </div>
        <p>
            <?php _e( "Such information may be transferred across state or national borders, in which case the information would become subject to the legislation of that jurisdiction. {$company} ensures there is a data protection agreement in place with the third party to protect the personal information that is transferred. The third parties are prohibited from using your personal information for purposes other than that stated in our Policy.", PLUGIN_ID ); ?>
        </p>

    <?php else : ?>

        <p>
            <?php _e( "{$company}  does not transfer personal information to third parties or service providers.", PLUGIN_ID ); ?>
        </p>

    <?php endif; ?>

    <h3><?php _e( 'Access', PLUGIN_ID ); ?></h3>
    <p>
        <?php _e( "{$company}  provides individuals with access to their personal information for review or update. If you wish to access your personal information to challenge accuracy or update it to ensure completeness, you may email us at ", PLUGIN_ID ); ?><a href="mailto:<?php esc_attr_e( $contact_email ); ?>"><?php echo $contact_email; ?></a><?php _e( ". We will provide a response within 30 days of receiving an access request. If under certain circumstances we are unable to fully separate your personal information from that of another individual, we will not be able to provide you with access to your information.", PLUGIN_ID ); ?>
    </p>
    <h3><?php _e( 'Quality', PLUGIN_ID ); ?></h3>
    <p>
        <?php _e( "{$company} will strive to maintain an accurate and complete record of your personal information for the purposes identified in this Policy. If you believe your personal information may be inaccurate, you may contact us to access your personal information and take steps to verify, update, and correct it.", PLUGIN_ID ); ?>
    </p>
    <h3><?php _e( 'Cookies', PLUGIN_ID ); ?></h3>

    <?php if( get_option( Options::COOKIES_USAGE ) == 'on' ) : ?>

        <p>
            <?php _e( "Cookies are files with small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer's hard drive. Like many sites, we use \"cookies\" to collect information. You can instruct your browser to refuse or disable all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Site. By using this website, you accept the use of cookies.", PLUGIN_ID ); ?>
        </p>

    <?php else: ?>

        <p>
            <?php _e( "This website does not use cookies.", PLUGIN_ID ); ?>
        </p>

    <?php endif; ?>

    <h3><?php _e( 'Security for Privacy', PLUGIN_ID ); ?></h3>
    <p>
        <?php _e( "The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage, is 100% secure. While we strive to use commercially acceptable means to protect your Personal Information, we cannot guarantee its absolute security. {$company} protects personal information against unauthorized access in accordance with established policies and procedures. Information is protected by security safeguards appropriate to the sensitivity of the information.", PLUGIN_ID ); ?>
    </p>
    <h3><?php _e( "Monitoring and Enforcement", PLUGIN_ID ); ?></h3>
    <p>
        <?php _e( "{$company} monitors compliance with its privacy policies and procedures. Users may file privacy complaints and disputes by contacting " . StringUtils::_s( $company, false ) . " Privacy Officer at ", PLUGIN_ID ); ?><a href="mailto:<?php esc_attr_e( $contact_email ); ?>"><?php echo $contact_email; ?></a><?php _e( " who is accountable for our privacy compliance. Every privacy-related complaint will be acknowledged, documented, and investigated, with the results being provided to the complainant. If the complaint is found to be justified, appropriate measures will be taken as a result.", PLUGIN_ID ); ?>
    </p>
    <h3><?php _e( 'Changes to This Privacy Policy', PLUGIN_ID ); ?></h3>
    <p>
        <?php _e( "This Privacy Policy is effective as of {$date} and will remain in effect except with respect to any changes in its provisions in the future, which will be in effect immediately after being posted on this page.", PLUGIN_ID ); ?>
    </p>
    <p>
        <?php _e( "We reserve the right to update or change our Privacy Policy at any time and you should check this Privacy Policy periodically. Your continued use of the website after we post any modifications to the Privacy Policy on this page will constitute your acknowledgment of the modifications and your consent to abide and be bound by the modified Privacy Policy.", PLUGIN_ID ); ?>
    </p>
    <p>
        <?php _e( "If we make any material changes to this Privacy Policy, we will notify you either through the email address you have provided us, or by placing a prominent notice on our website.", PLUGIN_ID ); ?>
    </p>
    <h3><?php _e( 'Contact Us', PLUGIN_ID ); ?></h3>
    <div>
        <?php _e( "If you have any further policy about this Privacy Policy, please contact us at: ", PLUGIN_ID ); ?>
        <p>
            <?php _e( $company, PLUGIN_ID ); ?><br>
            <?php _e( get_option( Options::COMPANY_ADDRESS, '' ), PLUGIN_ID ); ?><br>
            <?php _e( get_option( Options::COMPANY_CITY, '' ), PLUGIN_ID ); ?><br>
            <?php _e( get_option( Options::PHONE_NUMBER, '' ), PLUGIN_ID ); ?><br>
            <a href="mailto:<?php esc_attr_e( $contact_email ); ?>"><?php echo $contact_email; ?></a>
        </p>
    </div>
</div>

<?php return ob_get_clean(); ?>
