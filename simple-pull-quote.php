<?php
/**
 * @package Simple Pull Quote
 * @author Toby Cryns
 * @version 1.4
 */
/*
Plugin Name: Simple Pull Quote
Plugin URI: http://www.themightymo.com/simple-pull-quote
Description: Easily add pull quotes to blog posts using shortcode.
Author: Toby Cryns
Version: 1.4
Author URI: http://www.themightymo.com/updates
*/

/*  Copyright 2009  Toby Cryns  (email : toby at themightymo dot com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Load the TinyMCE Stuff
require_once (dirname(__FILE__) . '/simple-pull-quote_tinymce.php');

function my_css() {
        echo '<link type="text/css" rel="stylesheet" href="' . plugins_url( 'css/simple-pull-quote.css', __FILE__ ) . '" />' . "\n";
}

function getSimplePullQuote( $atts, $content = null ) {
        /* Add CSS classes to the pull quote (a.k.a. Style the thing!) */
		$content = wpautop(trim($content));
        return '<div class="simplePullQuote"><div class="quotation_mark">“</div>'. do_shortcode($content) .'</div>';
}

// Allow us to add the pull quote using Wordpress shortcode, "[pullquote][/pullquote]" 
add_shortcode('pullquote', 'getSimplePullQuote');

// Add the CSS file to the header when the page loads
add_action('wp_head', 'my_css');

/* Call the javascript file that loads the html editor button */
//add_action('admin_print_scripts', 'simplePullQuotes');
function simplePullQuotes() {
	wp_enqueue_script(
		'simple-pull-quotes',
		plugin_dir_url(__FILE__) . 'simple-pull-quote.js',
		array('quicktags')
	);
}

// Load the custom TinyMCE plugin
function simple_pull_quotes_plugin( $plugins ) {
	$plugins['simplepullquotes'] = plugins_url('/simple-pull-quote/tinymce3/editor_plugin.js');
	return $plugins;
}

function specific_enqueue($hook_suffix) {
   if( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
     add_action('admin_print_scripts', 'simplePullQuotes');
  }
}
add_action( 'admin_enqueue_scripts', 'specific_enqueue' );








/* BEGIN OPTIONS PAGE */
// add the admin options page - via http://ottopress.com/2009/wordpress-settings-api-tutorial/
add_action('admin_menu', 'simple_pull_quote_admin_add_page');
function simple_pull_quote_admin_add_page() {
	add_options_page('Simple Pull Quote Options Page', 'Simple Pull Quote Options', 'manage_options', 'simple-pull-quote', 'simple_pull_quote_options_page');
}
// display the admin options page
function simple_pull_quote_options_page() {
?>
<div>
	<h2>Simple Pull Quote Options</h2>
	How do you want your pull quotes to look?
	<form action="options.php" method="post">
		<?php settings_fields('simple_pull_quote'); ?>
		<?php do_settings_sections('simple_pull_quote'); ?>
		<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
</div>
 
<?php
}
// add the admin settings and such
add_action('admin_init', 'simple_pull_quote_admin_init');
function simple_pull_quote_admin_init(){
	register_setting( 'simple_pull_quote', 'simple_pull_quote', 'simple_pull_quote_validate' );
	add_settings_section('simple_pull_quote_main', 'Main Settings', 'simple_pull_quote_section_text', 'simple_pull_quote');
	add_settings_field('simple_pull_quote_text_string', 'Text Input', 'simple_pull_quote_setting_string', 'simple_pull_quote', 'simple_pull_quote_main');
	add_settings_field('simple_pull_quote_text_string1', 'Text Input 1', 'simple_pull_quote_setting_string1', 'simple_pull_quote', 'simple_pull_quote_main');
}
// validate our options
function simple_pull_quote_validate($input) {
	$newinput['text_string'] = trim($input['text_string']);
	/*if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
		$newinput['text_string'] = '';
	}*/
	return $newinput;
	$newinput1['text_string1'] = trim($input['text_string1']);
	/*if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
		$newinput['text_string'] = '';
	}*/
	return $newinput1;
}
function simple_pull_quote_section_text() {
	echo '<p>Main description of this section here.</p>';
}
function simple_pull_quote_setting_string() {
	$options = get_option('simple_pull_quote');
	echo "<input id='simple_pull_quote_text_string' name='simple_pull_quote[text_string]' size='40' type='text' value='{$options['text_string']}' />";
	
}
function simple_pull_quote_setting_string1() {
	echo "<input id='simple_pull_quote_text_string1' name='simple_pull_quote[text_string1]' size='40' type='text' value='{$options['text_string1']}' />";
}
/* END OPTIONS PAGE */








// LEGACY CODE for Version < 0.2.4

function getQuote(){
	global $post;
	$my_custom_field = get_post_meta($post->ID, "quote", true);
	/* Add CSS classes to the pull quote (a.k.a. Style the thing!) */
	return '<div class="simplePullQuote">'.$my_custom_field.'</div>'; 
}

/* Allow us to add the pull quote using Wordpress shortcode, "[quote]" */
add_shortcode('quote', 'getQuote');
function getQuote1(){
	global $post;
	$my_custom_field = get_post_meta($post->ID, "quote1", true);
	/* Add CSS classes to the pull quote (a.k.a. Style the thing!) */
	return '<div class="simplePullQuote">'.$my_custom_field.'</div>'; 
}

/* Allow us to add the pull quote using Wordpress shortcode, "[quote]" */
add_shortcode('quote1', 'getQuote1');

function getQuote2(){
	global $post;
	$my_custom_field = get_post_meta($post->ID, "quote2", true);

	/* Add CSS classes to the pull quote (a.k.a. Style the thing!) */
	return '<div class="simplePullQuote">'.$my_custom_field.'</div>'; 
}

// Allow us to add the pull quote using Wordpress shortcode, "[quote]" */
add_shortcode('quote2', 'getQuote2');