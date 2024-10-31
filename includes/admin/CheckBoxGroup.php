<?php

namespace privacy_policy_genius\admin;


use smartcat\admin\SettingsField;

class CheckBoxGroup extends SettingsField {

    protected $options;
    protected $value = array();

    public function __construct( array $args ) {
        parent::__construct( $args );

        $this->options = $args['options'];
    }

    public function render( array $args ) { ?>

        <fieldset>

            <?php foreach( $this->options as $option => $label ) : ?>

                <label>
                    <input
                        type="checkbox"
                        name="<?php esc_attr_e( $this->option ); ?>[]"
                        value="<?php esc_attr_e( $option ); ?>"
                        <?php echo in_array( $option, $this->value ) ? 'checked' : ''; ?> />

                        <?php esc_html_e( $label ); ?>
                </label>
                <br>

            <?php endforeach; ?>

        </fieldset>

    <?php }

    public static function get_option( $key, array $default = array() )  {
        $value = get_option( $key, $default );

        return is_array( $value ) ? $value : $default;
    }

}
