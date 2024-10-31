<?php

namespace privacy_policy_genius\admin;


use smartcat\admin\SettingsField;

class RadioGroup extends SettingsField {
    protected $options;
    protected $break = false;

    public function __construct( array $args ) {
        parent::__construct( $args );

        $this->break = $args['break'];
        $this->options = $args['options'];
    }

    public function render( array $args ) { ?>

        <fieldset>

            <?php foreach( $this->options as $option => $title ) : ?>

                <label>
                    <input type="radio"
                           name="<?php esc_attr_e( $this->option ); ?>"
                           value="<?php esc_attr_e( $option ); ?>"
                           <?php echo checked( $option, $this->value ); ?>
                           <?php echo $this->required ? 'required="required"' : ''; ?> />

                    <?php esc_html_e( $title ); ?>

                </label>

                <?php if( $this->break ) : ?><br><?php endif; ?>

            <?php endforeach; ?>

        </fieldset>

    <?php }
}
