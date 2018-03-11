<?php
add_action( 'admin_menu', 'vp_plus_menu_general_item' );
function vp_plus_menu_general_item() {
	add_menu_page( 'VP+ Console', 'VP+ Console', 'manage_options', 'vp-plus-console', 'vp_console_page', plugins_url( 'logo.png', __FILE__ ), 81 );
}

function vp_console_page() {
	?>
    <div class="wrap">
        <h2 style="">VP+ Console</h2>
        <div class="vp-general-menu">
            Support:
            <a href="mailto:oleg@valko.pro">oleg@valko.pro</a>
            <a href="//vp-plus.top">vp-plus.top</a>
        </div>
    </div>
    <style>
        .vp-general-menu {
            background: #000;
            color: #fff;
            padding: 10px;
        }

        .vp-general-menu a {
            color: #fff;
        }
    </style>
	<?php
}
