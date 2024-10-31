<?php

namespace smartcat\admin;

if( !class_exists( '\smartcat\admin\RadioBoxField' ) ) :

    class RadioBoxField extends SettingsField {

        public function render( array $args ) { 
		echo"<pre>"; print_r($this->value); echo"</pre>";
		if(!empty($this->option)) {
			foreach($this->option as $key=>$val){
		?>

            <input type="radio"
                id="<?php esc_attr_e( $this->id ); ?>"
                name="<?php esc_attr_e( $this->id ); ?>"

                <?php checked( $this->value, 'on' ); ?>
                <?php echo $this->required ? 'required="required"' : ''; ?> value ="<?php echo $val; ?>"/>

                        <label for="<?php esc_attr_e( $this->id ); ?>"><?php echo $val; ?></label>

        <?php } ?>
		</br><label for="<?php esc_attr_e( $this->id ); ?>"><?php echo $this->desc; ?></label>
		 <?php }
		}
    }

endif;