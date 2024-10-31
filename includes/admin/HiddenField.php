<?php

namespace privacy_policy_genius\admin;

use smartcat\admin\SettingsField;

class HiddenField extends SettingsField {

    public  function render( array $args ) { ?>

        <input type="hidden"
               id="<?php esc_attr_e( $this->id ); ?>"
               name="<?php esc_attr_e( $this->option ); ?>"
               value="<?php esc_attr_e( $this->value ); ?>" />

    <?php }
}
