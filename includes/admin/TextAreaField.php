<?php

namespace privacy_policy_genius\admin;

use smartcat\admin\SettingsField;

class TextAreaField extends SettingsField {

    protected $size;
    protected $max_chars;

    public function __construct( array $args ) {
        parent::__construct( $args );

        if( isset( $args['size'] ) && is_array( $args['size'] ) ) {
            $this->size = $args['size'];
        }

        if( isset( $args['max_chars'] ) ) {
            $this->max_chars = $args['max_chars'];
        }
    }

    public  function render( array $args ) { ?>

        <textarea
            id="<?php esc_attr_e( $this->id ); ?>"
            name="<?php esc_attr_e( $this->option ); ?>"

            <?php if( !empty( $this->size ) ) {
                echo 'cols="' . $this->size[0] . '"';
                echo 'rows="' . $this->size[1] . '"';
            } ?>

            <?php if( !empty( $this->max_chars ) ) {
                echo 'maxlength="' . $this->max_chars . '"';
            } ?>

            <?php echo $this->required ? 'required="required"' : ''; ?>

            ><?php esc_attr_e( $this->value ); ?></textarea>

        <?php if( !empty( $this->desc ) ) : ?>

            <p class="description"><?php echo $this->desc; ?></p>

        <?php endif; ?>

   <?php }
}