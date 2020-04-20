<?php
/*
Plugin Name: Registration form
Plugin URI: 
Description:Smpale Registration form
Version: 1.1
Author: Masum Sakib
Author URI: 
Text Domain:  sakib-registration
License: GPLv2 or later
*/

/**
 * Login Form logo change 
 * 
 */
 add_action( 'register_form', function() {
        $first_name = $_POST['first_name']?? '';
        $last_name = $_POST['last_name']?? '';
        $phone_numear = $_POST['phone_numear']?? '';
     ?>
       <p>
            <label for="first_name">Frist Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $first_name ) ?>">
       </p>
       <p>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $last_name ) ?>">
       </p>
       <p>
            <label for="phone_numear">Phone Number</label>
            <input type="text" name="phone_numear" id="phone_numear" value="<?php echo esc_attr( $phone_numear ) ?>">
       </p>

     <?php
 } );


 /**
  * Erroe hendaling
  */
  add_filter( 'registration_errors', function($errors, $sanitized_user_login, $user_email ) {

        if(empty( $_POST['first_name'] )){
            $errors->add( 'first_name_blank', __('Frist Name Cannot Be Blank', 'sakib-registration' ));
        }
        if(empty( $_POST['last_name']) ){
            $errors->add( 'last_name_blank', __('Last Name Cannot Be Blank', 'sakib-registration' ));
        }
        if(empty( $_POST['phone_numear']) ){
            $errors->add( 'phone_numear_blank', __('Phone Number Cannot Be Blank', 'sakib-registration' ));
        }
        return $errors;
  }, 10, 3 );


  /**
  * User Input Store
  */
  add_action( 'user_register', function( $user_id ) {
      if(!empty($_POST['first_name'])){
          update_user_meta( $user_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
      }
      if(!empty($_POST['last_name'])){
          update_user_meta( $user_id , 'last_name', sanitize_text_field( $_POST['last_name']) );
      }
      if(!empty($_POST['phone_numear'])){
          update_user_meta( $user_id , 'phone_numear', sanitize_text_field( $_POST['phone_numear']) );
      }
  } );


/**
 * The field on the editing screens.
 *
 * @param $user WP_User user object
 */
function sakib_registration_user_phone_number( $user )
{
    ?>
    <h3><?php echo esc_html('Phone Number', 'sakib-registration') ?></h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="phone_numear"><?php echo esc_html('Phone Number', 'sakib-registration') ?></label>
            </th>
            <td>
                <input type="number"
                       class="regular-text ltr"
                       id="phone_numear"
                       name="phone_numear"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'phone_numear', true ) ) ?>"
                       title="Phone Number">
                <p class="description">
                    Please enter your Phone Number
                </p>
            </td>
        </tr>
    </table>
    <?php
};

 /**
  * User Input Update And Save
  */
add_action(
    'show_user_profile',
    'sakib_registration_user_phone_number'
);

add_action(
    'edit_user_profile',
    'sakib_registration_user_phone_number'
);

function sakib_registration_user_phone_number_update( $user_id )
{
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
  
    return update_user_meta(
        $user_id,
        'phone_numear',
        sanitize_text_field( $_POST['phone_numear'] )
    );
}

add_action(
    'personal_options_update',
    'sakib_registration_user_phone_number_update'
);
  
add_action(
    'edit_user_profile_update',
    'sakib_registration_user_phone_number_update'
);
    