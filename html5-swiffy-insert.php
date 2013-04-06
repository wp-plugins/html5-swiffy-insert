<?php  
/* 
Plugin Name: HTML5 Swiffy Insert 
Plugin URI: http://www.unniks.com/ublog/html5-swiffy-insert/
Description: <strong>HTML5 Swiffy Insert</strong> is a simple plugin that lets you to use a shortcode to insert HTML5 animations generated with Google Swiffy. Swiffy converts Flash SWF files to HTML5, allowing you to reuse Flash content on devices without a Flash player (such as iPhones and iPads).
Version: 1.2
Author: Yuanga 
Author URI: http://www.unniks.com 
*/  
?>
<?php
function my_scripts_html5_swiffy_insert() {
	wp_deregister_script( 'html5_swiffy_insert_script' );
	wp_register_script( 'html5_swiffy_insert_script', 'https://www.gstatic.com/swiffy/v5.0/runtime.js');
	wp_enqueue_script( 'html5_swiffy_insert_script' );
}  
add_action('wp_enqueue_scripts', 'my_scripts_html5_swiffy_insert');
add_action('wp_head','html5_swiffy_insert');
function html5_swiffy_insert() {
	global $post;
	$detenir_bucle = 0;
	$contador = 1;
	do{
		$swiffy_variable = 'swiffy_'.$contador;
		if(get_post_meta($post->ID, $swiffy_variable, true)){
			echo '<script>swiffyobject_'.$contador.' = '.get_post_meta($post->ID, $swiffy_variable, true).'</script>';
			$contador++;
		}else{
			$detenir_bucle = 1;
		}
	}while($detenir_bucle == 0);
}
add_action('wp_footer','html5_swiffy_insert_post');
function html5_swiffy_insert_post() {
	global $post;
	$detenir_bucle = 0;
	$contador = 1;
	do{
		$swiffy_variable = 'swiffy_'.$contador;
		$swiffy_container = 'swiffycontainer_'.$contador;
		$swiffy_object = 'swiffyobject_'.$contador;
		if(get_post_meta($post->ID, $swiffy_variable, true)){
			?>
			<script>
				var stage = new swiffy.Stage(document.getElementById('<? echo $swiffy_container; ?>'), <? echo $swiffy_object; ?>);
				stage.start();
			</script>
			<?
			$contador++;
		}else{
			$detenir_bucle = 1;
		}
	}while($detenir_bucle == 0);
}
//SHORTCODE
function shortcode_html5_swiffy_insert($atts) {
	extract(shortcode_atts(array(
		  'n' => '1',
	      'w' => '450',
	      'h' => '300',
     ), $atts));
	return "<div id='swiffycontainer_{$n}' style='width: {$w}px; height: {$h}px;'></div>";
}
add_shortcode('swiffy', 'shortcode_html5_swiffy_insert');
/*
Menu
*/
function  menu_plugin_ayudawordpress(){
   add_plugins_page("Ayuda HTML5 Swiffy Insert", "HTML5 Swiffy Insert", 10, "plugin_ayuda_wordpress", "pagina_html5_swiffy_insert");
   /*
   1.el título del menú del plugin, 
   2.el título de la página del plugin,
   3.el número que define el permiso de acceso,
   4.el nombre de la página del plugin,
   5.la función a la que se llama para mostrar la página HTML del plugin.
   */
}
function pagina_html5_swiffy_insert(){
	include("howto.php");
}
add_action("admin_menu","menu_plugin_ayudawordpress");
?>