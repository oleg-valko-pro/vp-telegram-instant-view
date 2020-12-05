<?php
$vptiv_page = 'vptiv.php';

add_action( 'admin_menu', 'vptiv_option_menu' );
function vptiv_option_menu(){
	global $vptiv_page;
	add_menu_page(__('Telegram Instant View','vptiv'), __('Telegram Instant View','vptiv'), 'manage_options', $vptiv_page, 'vptiv_option_page', plugins_url( 'logo.png', __FILE__ ), 101); 
}

function vptiv_option_page(){
	global $vptiv_page;
	?><div class="wrap">
		<h2>VP+ Telegram Instant View</h2>
		<h2><?php _e('Step 1', 'vptiv') ?></h2>
		<ul style="list-style-type: disc; margin-left: 17px">
			<li><?php _e('Create a template to instant view your site - <a href="http://instantview.telegram.org/my/" target="_blank">instantview.telegram.org/my</a>', 'vptiv') ?></li>
			<li><?php _e('Enter the addresses of your site and create a template according to the documentation - <a href="http://instantview.telegram.org/docs" target="_blank">instantview.telegram.org/docs</a>', 'vptiv') ?></li>
			<li><?php _e('Or order an individual template creation for your site - <a href="http://mailto:oleg@valko.pro" target="_blank">oleg@valko.pro</a>', 'vptiv') ?></li>
			<li><?php _e('After creating the template o1n the page - <a href="http://instantview.telegram.org/my/" target="_blank">instantview.telegram.org/my</a>, click the button - VIEW IN TELEGRAM and copy the link. At the end of this link will be your RHASH code. You need to paste it into the settings below', 'vptiv') ?></li>
		</ul>
		<h2><?php _e('Step 2', 'vptiv') ?></h2>
		<form method="post" enctype="multipart/form-data" action="options.php">
			<?php 
			settings_fields('vptiv_options'); 
			do_settings_sections($vptiv_page);
			?>
			<p class="submit">  
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
			</p>
		</form>
		<h2><?php _e('Step 3', 'vptiv') ?></h2>
		<?php _e('After saving the settings at the end of each record will be a button with an automatically generated link. You need to copy and paste it into Telegram', 'vptiv') ?>
	</div><?php
}
 

function vptiv_option_settings() {
	global $vptiv_page;
	register_setting( 'vptiv_options', 'vptiv_options', 'vptiv_validate_settings' ); 
 
	// Добавляем секцию
	add_settings_section( 'vptiv_section_1', '', '', $vptiv_page );
 
	// Создадим текстовое поле в первой секции
	$vptiv_field_params = array(
		'type'      => 'text', // тип
		'id'        => 'id_vptiv_rhash_field',
		'desc'      => __('Enter your rhash that you received after creating the template on <a href="http://instantview.telegram.org" target="_blank">instantview.telegram.org</a>'), 
		'label_for' => 'id_vptiv_rhash_field' 
	);
	add_settings_field( 'vptiv_rhash_field', 'RHASH=', 'vptiv_option_display_settings', $vptiv_page, 'vptiv_section_1', $vptiv_field_params );
}
add_action( 'admin_init', 'vptiv_option_settings' );
 
function vptiv_option_display_settings($args) {
	extract( $args );
 
	$option_name = 'vptiv_options';
 
	$o = get_option( $option_name );
 
	switch ( $type ) {
		case 'text':  
			$o[$id] = esc_attr( stripslashes($o[$id]) );
			echo "<input class='regular-text' type='text' id='$id' name='" . $option_name . "[$id]' value='$o[$id]' />";  
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
		break;
	}
}
 
/*
 * Функция проверки правильности вводимых полей
 */
function vptiv_validate_settings($input) {
	foreach($input as $k => $v) {
		$valid_input[$k] = trim($v);
	}
	return $valid_input;
}
