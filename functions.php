<?php

/**
 * Twenty Twenty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_theme_support()
{

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if (!isset($content_width)) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// Set post thumbnail size.
	set_post_thumbnail_size(1200, 9999);

	// Add custom image size used in Cover Template.
	add_image_size('twentytwenty-fullscreen', 1980, 9999);

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if (get_theme_mod('retina_logo', false)) {
		$logo_width  = floor($logo_width * 2);
		$logo_height = floor($logo_height * 2);
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Twenty, use a find and replace
	 * to change 'twentytwenty' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('twentytwenty');

	// Add support for full and wide align images.
	add_theme_support('align-wide');

	// Add support for responsive embeds.
	add_theme_support('responsive-embeds');

	/*
	 * Adds starter content to highlight the theme on fresh sites.
	 * This is done conditionally to avoid loading the starter content on every
	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
	if (is_customize_preview()) {
		require get_template_directory() . '/inc/starter-content.php';
		add_theme_support('starter-content', twentytwenty_get_starter_content());
	}

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new TwentyTwenty_Script_Loader();
	add_filter('script_loader_tag', array($loader, 'filter_script_loader_tag'), 10, 2);
}

// add_action('after_setup_theme', 'twentytwenty_theme_support');


/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-twentytwenty-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-twentytwenty-customize.php';

// Require Separator Control class.
require get_template_directory() . '/classes/class-twentytwenty-separator-control.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-twentytwenty-script-loader.php';

// Non-latin language handling.
require get_template_directory() . '/classes/class-twentytwenty-non-latin-languages.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Register and Enqueue Styles.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_register_styles()
{

	$theme_version = wp_get_theme()->get('Version');
	wp_enqueue_script('jquery');

	wp_enqueue_style('twentytwenty-style', get_stylesheet_uri(), array(), $theme_version);
	wp_style_add_data('twentytwenty-style', 'rtl', 'replace');

	// Add output of Customizer settings as inline style.
	wp_add_inline_style('twentytwenty-style', twentytwenty_get_customizer_css('front-end'));

	// Add print CSS.
	wp_enqueue_style('twentytwenty-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print');
	wp_enqueue_style('wp-bootstrap-starter-bootstrap-css', get_template_directory_uri() . '/inc/assets/css/bootstrap.min.css');
	wp_enqueue_style('wp-bootstrap-starter-site', get_template_directory_uri() . '/dist/css/site.css?' . time(), null, $theme_version);
}


add_action('wp_enqueue_scripts', 'twentytwenty_register_styles');

/**
 * Register and Enqueue Scripts.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_register_scripts()
{

	$theme_version = wp_get_theme()->get('Version');

	if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_enqueue_script('twentytwenty-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false);
	wp_enqueue_script('wp-bootstrap-starter-bootstrapjs', get_template_directory_uri() . '/inc/assets/js/bootstrap.min.js', array(), '', true);
	wp_enqueue_script('isotope-pkgd', get_template_directory_uri() . '/inc/assets/js/isotope.pkgd.min.js', array(), '', true);
	wp_enqueue_script('js-js', get_template_directory_uri() . '/dist/js/js.js?' . time(), array(), '', true);
	wp_script_add_data('twentytwenty-js', 'async', true);
}


add_action('wp_enqueue_scripts', 'twentytwenty_register_scripts');

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @since Twenty Twenty 1.0
 *
 * @link https://git.io/vWdr2
 */
function twentytwenty_skip_link_focus_fix()
{
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
?>
	<script>
		/(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
			var t, e = location.hash.substring(1);
			/^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
		}, !1);
	</script>
	<?php
}
add_action('wp_print_footer_scripts', 'twentytwenty_skip_link_focus_fix');

/**
 * Enqueue non-latin language styles.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_non_latin_languages()
{
	$custom_css = TwentyTwenty_Non_Latin_Languages::get_non_latin_css('front-end');

	if ($custom_css) {
		wp_add_inline_style('twentytwenty-style', $custom_css);
	}
}

add_action('wp_enqueue_scripts', 'twentytwenty_non_latin_languages');

/**
 * Register navigation menus uses wp_nav_menu in five places.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_menus()
{

	$locations = array(
		'primary'  => __('Desktop Horizontal Menu', 'twentytwenty'),
		// 'expanded' => __( 'Desktop Expanded Menu', 'twentytwenty' ),
		'mobile'   => __('Mobile Menu', 'twentytwenty'),
		'footer-col-1'   => __('Footer Column 1', 'twentytwentyone'),
		'footer-col-2'   => __('Footer Column 2', 'twentytwentyone'),
		'footer-col-3'   => __('Footer Column 3', 'twentytwentyone'),
		'footer-bottom-menu'   => __('Footer Bottom Menu', 'twentytwentyone'),
	);

	register_nav_menus($locations);
}

add_action('init', 'twentytwenty_menus');

/**
 * Get the information about the logo.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $html The HTML output from get_custom_logo (core function).
 * @return string
 */
function twentytwenty_get_custom_logo($html)
{

	$logo_id = get_theme_mod('custom_logo');

	if (!$logo_id) {
		return $html;
	}

	$logo = wp_get_attachment_image_src($logo_id, 'full');

	if ($logo) {
		// For clarity.
		$logo_width  = esc_attr($logo[1]);
		$logo_height = esc_attr($logo[2]);

		// If the retina logo setting is active, reduce the width/height by half.
		if (get_theme_mod('retina_logo', false)) {
			$logo_width  = floor($logo_width / 2);
			$logo_height = floor($logo_height / 2);

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if (strpos($html, ' style=') === false) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace($search, $replace, $html);
		}
	}

	return $html;
}

add_filter('get_custom_logo', 'twentytwenty_get_custom_logo');

if (!function_exists('wp_body_open')) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 *
	 * @since Twenty Twenty 1.0
	 */
	function wp_body_open()
	{
		/** This action is documented in wp-includes/general-template.php */
		do_action('wp_body_open');
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_skip_link()
{
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __('Skip to the content', 'twentytwenty') . '</a>';
}

add_action('wp_body_open', 'twentytwenty_skip_link', 5);

/**
 * Register widget areas.
 *
 * @since Twenty Twenty 1.0
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentytwenty_sidebar_registration()
{
    register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'twentytwenty' ),
		'id'            => 'sidebar-primary',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Primary-both Sidebar', 'twentytwenty' ),
		'id'            => 'sidebar-primary-both',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __('Footer #1', 'twentytwenty'),
				'id'          => 'sidebar-1',
				'description' => __('Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty'),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __('Footer #2', 'twentytwenty'),
				'id'          => 'sidebar-2',
				'description' => __('Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty'),
			)
		)
	);
}

add_action( 'widgets_init', 'twentytwenty_sidebar_registration' );

function twentytwenty_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'twentytwenty' ),
		'id'            => 'sidebar-primary',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Primary-both Sidebar', 'twentytwenty' ),
		'id'            => 'sidebar-primary-both',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}
/**
 * Enqueue supplemental block editor styles.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_block_editor_styles()
{

	// Enqueue the editor styles.
	wp_enqueue_style('twentytwenty-block-editor-styles', get_theme_file_uri('/assets/css/editor-style-block.css'), array(), wp_get_theme()->get('Version'), 'all');
	wp_style_add_data('twentytwenty-block-editor-styles', 'rtl', 'replace');

	// Add inline style from the Customizer.
	wp_add_inline_style('twentytwenty-block-editor-styles', twentytwenty_get_customizer_css('block-editor'));

	// Add inline style for non-latin fonts.
	wp_add_inline_style('twentytwenty-block-editor-styles', TwentyTwenty_Non_Latin_Languages::get_non_latin_css('block-editor'));

	// Enqueue the editor script.
	wp_enqueue_script('twentytwenty-block-editor-script', get_theme_file_uri('/assets/js/editor-script-block.js'), array('wp-blocks', 'wp-dom'), wp_get_theme()->get('Version'), true);
}

add_action('enqueue_block_editor_assets', 'twentytwenty_block_editor_styles', 1, 1);

/**
 * Enqueue classic editor styles.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_classic_editor_styles()
{

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.css',
	);

	add_editor_style($classic_editor_styles);
}

add_action('init', 'twentytwenty_classic_editor_styles');

/**
 * Output Customizer settings in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @since Twenty Twenty 1.0
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_customizer_styles($mce_init)
{

	$styles = twentytwenty_get_customizer_css('classic-editor');

	if (!isset($mce_init['content_style'])) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;
}

add_filter('tiny_mce_before_init', 'twentytwenty_add_classic_editor_customizer_styles');

/**
 * Output non-latin font styles in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_non_latin_styles($mce_init)
{

	$styles = TwentyTwenty_Non_Latin_Languages::get_non_latin_css('classic-editor');

	// Return if there are no styles to add.
	if (!$styles) {
		return $mce_init;
	}

	if (!isset($mce_init['content_style'])) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;
}

add_filter('tiny_mce_before_init', 'twentytwenty_add_classic_editor_non_latin_styles');

/**
 * Block Editor Settings.
 * Add custom colors and font sizes to the block editor.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_block_editor_settings()
{

	// Block Editor Palette.
	$editor_color_palette = array(
		array(
			'name'  => __('Accent Color', 'twentytwenty'),
			'slug'  => 'accent',
			'color' => twentytwenty_get_color_for_area('content', 'accent'),
		),
		array(
			'name'  => _x('Primary', 'color', 'twentytwenty'),
			'slug'  => 'primary',
			'color' => twentytwenty_get_color_for_area('content', 'text'),
		),
		array(
			'name'  => _x('Secondary', 'color', 'twentytwenty'),
			'slug'  => 'secondary',
			'color' => twentytwenty_get_color_for_area('content', 'secondary'),
		),
		array(
			'name'  => __('Subtle Background', 'twentytwenty'),
			'slug'  => 'subtle-background',
			'color' => twentytwenty_get_color_for_area('content', 'borders'),
		),
	);

	// Add the background option.
	$background_color = get_theme_mod('background_color');
	if (!$background_color) {
		$background_color_arr = get_theme_support('custom-background');
		$background_color     = $background_color_arr[0]['default-color'];
	}
	$editor_color_palette[] = array(
		'name'  => __('Background Color', 'twentytwenty'),
		'slug'  => 'background',
		'color' => '#' . $background_color,
	);

	// If we have accent colors, add them to the block editor palette.
	if ($editor_color_palette) {
		add_theme_support('editor-color-palette', $editor_color_palette);
	}

	// Block Editor Font Sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => _x('Small', 'Name of the small font size in the block editor', 'twentytwenty'),
				'shortName' => _x('S', 'Short name of the small font size in the block editor.', 'twentytwenty'),
				'size'      => 18,
				'slug'      => 'small',
			),
			array(
				'name'      => _x('Regular', 'Name of the regular font size in the block editor', 'twentytwenty'),
				'shortName' => _x('M', 'Short name of the regular font size in the block editor.', 'twentytwenty'),
				'size'      => 21,
				'slug'      => 'normal',
			),
			array(
				'name'      => _x('Large', 'Name of the large font size in the block editor', 'twentytwenty'),
				'shortName' => _x('L', 'Short name of the large font size in the block editor.', 'twentytwenty'),
				'size'      => 26.25,
				'slug'      => 'large',
			),
			array(
				'name'      => _x('Larger', 'Name of the larger font size in the block editor', 'twentytwenty'),
				'shortName' => _x('XL', 'Short name of the larger font size in the block editor.', 'twentytwenty'),
				'size'      => 32,
				'slug'      => 'larger',
			),
		)
	);

	add_theme_support('editor-styles');

	// If we have a dark background color then add support for dark editor style.
	// We can determine if the background color is dark by checking if the text-color is white.
	if ('#ffffff' === strtolower(twentytwenty_get_color_for_area('content', 'text'))) {
		add_theme_support('dark-editor-style');
	}
}

// add_action('after_setup_theme', 'twentytwenty_block_editor_settings');

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string
 */
function twentytwenty_read_more_tag($html)
{
	return preg_replace('/<a(.*)>(.*)<\/a>/iU', sprintf('<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title(get_the_ID())), $html);
}

add_filter('the_content_more_link', 'twentytwenty_read_more_tag');

/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_controls_enqueue_scripts()
{
	$theme_version = wp_get_theme()->get('Version');

	// Add main customizer js file.
	wp_enqueue_script('twentytwenty-customize', get_template_directory_uri() . '/assets/js/customize.js', array('jquery'), $theme_version, false);

	// Add script for color calculations.
	wp_enqueue_script('twentytwenty-color-calculations', get_template_directory_uri() . '/assets/js/color-calculations.js', array('wp-color-picker'), $theme_version, false);

	// Add script for controls.
	wp_enqueue_script('twentytwenty-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array('twentytwenty-color-calculations', 'customize-controls', 'underscore', 'jquery'), $theme_version, false);
	wp_localize_script('twentytwenty-customize-controls', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars());
}

add_action('customize_controls_enqueue_scripts', 'twentytwenty_customize_controls_enqueue_scripts');

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_preview_init()
{
	$theme_version = wp_get_theme()->get('Version');

	wp_enqueue_script('twentytwenty-customize-preview', get_theme_file_uri('/assets/js/customize-preview.js'), array('customize-preview', 'customize-selective-refresh', 'jquery'), $theme_version, true);
	// wp_localize_script( 'twentytwenty-customize-preview', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars() );
	wp_localize_script('twentytwenty-customize-preview', 'twentyTwentyPreviewEls', twentytwenty_get_elements_array());

	wp_add_inline_script(
		'twentytwenty-customize-preview',
		sprintf(
			'wp.customize.selectiveRefresh.partialConstructor[ %1$s ].prototype.attrs = %2$s;',
			wp_json_encode('cover_opacity'),
			wp_json_encode(twentytwenty_customize_opacity_range())
		)
	);
}

add_action('customize_preview_init', 'twentytwenty_customize_preview_init');

/**
 * Get accessible color for an area.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $area    The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function twentytwenty_get_color_for_area($area = 'content', $context = 'text')
{

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'accent_accessible_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				// 'accent'    => '#cd2653',
				// 'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
			'header-footer' => array(
				'text'      => '#000000',
				// 'accent'    => '#cd2653',
				// 'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
		)
	);

	// If we have a value return it.
	if (isset($settings[$area]) && isset($settings[$area][$context])) {
		return $settings[$area][$context];
	}

	// Return false if the option doesn't exist.
	return false;
}

/**
 * Returns an array of variables for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function twentytwenty_get_customizer_color_vars()
{
	$colors = array(
		'content'       => array(
			'setting' => 'background_color',
		),
		'header-footer' => array(
			'setting' => 'header_footer_background_color',
		),
	);
	return $colors;
}

/**
 * Get an array of elements.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function twentytwenty_get_elements_array()
{

	// The array is formatted like this:
	// [key-in-saved-setting][sub-key-in-setting][css-property] = [elements].
	$elements = array(
		'content'       => array(
			'accent'     => array(
				'color'            => array('.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a'),
				'border-color'     => array('blockquote', '.border-color-accent', '.border-color-accent-hover:hover', '.border-color-accent-hover:focus'),
				'background-color' => array('button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file .wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.bg-accent', '.bg-accent-hover:hover', '.bg-accent-hover:focus', ':root .has-accent-background-color', '.comment-reply-link'),
				'fill'             => array('.fill-children-accent', '.fill-children-accent *'),
			),
			'background' => array(
				'color'            => array(':root .has-background-color', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.wp-block-button', '.comment-reply-link', '.has-background.has-primary-background-color:not(.has-text-color)', '.has-background.has-primary-background-color *:not(.has-text-color)', '.has-background.has-accent-background-color:not(.has-text-color)', '.has-background.has-accent-background-color *:not(.has-text-color)'),
				'background-color' => array(':root .has-background-background-color'),
			),
			'text'       => array(
				'color'            => array('body', '.entry-title a', ':root .has-primary-color'),
				'background-color' => array(':root .has-primary-background-color'),
			),
			'secondary'  => array(
				'color'            => array('cite', 'figcaption', '.wp-caption-text', '.post-meta', '.entry-content .wp-block-archives li', '.entry-content .wp-block-categories li', '.entry-content .wp-block-latest-posts li', '.wp-block-latest-comments__comment-date', '.wp-block-latest-posts__post-date', '.wp-block-embed figcaption', '.wp-block-image figcaption', '.wp-block-pullquote cite', '.comment-metadata', '.comment-respond .comment-notes', '.comment-respond .logged-in-as', '.pagination .dots', '.entry-content hr:not(.has-background)', 'hr.styled-separator', ':root .has-secondary-color'),
				'background-color' => array(':root .has-secondary-background-color'),
			),
			'borders'    => array(
				'border-color'        => array('pre', 'fieldset', 'input', 'textarea', 'table', 'table *', 'hr'),
				'background-color'    => array('caption', 'code', 'code', 'kbd', 'samp', '.wp-block-table.is-style-stripes tbody tr:nth-child(odd)', ':root .has-subtle-background-background-color'),
				'border-bottom-color' => array('.wp-block-table.is-style-stripes'),
				'border-top-color'    => array('.wp-block-latest-posts.is-grid li'),
				'color'               => array(':root .has-subtle-background-color'),
			),
		),
		'header-footer' => array(
			'accent'     => array(
				'color'            => array('body:not(.overlay-header) .primary-menu > li > a', 'body:not(.overlay-header) .primary-menu > li > .icon', '.modal-menu a', '.footer-menu a, .footer-widgets a', '#site-footer .wp-block-button.is-style-outline', '.wp-block-pullquote:before', '.singular:not(.overlay-header) .entry-header a', '.archive-header a', '.header-footer-group .color-accent', '.header-footer-group .color-accent-hover:hover'),
				'background-color' => array('.social-icons a', '#site-footer button:not(.toggle)', '#site-footer .button', '#site-footer .faux-button', '#site-footer .wp-block-button__link', '#site-footer .wp-block-file__button', '#site-footer input[type="button"]', '#site-footer input[type="reset"]', '#site-footer input[type="submit"]'),
			),
			'background' => array(
				'color'            => array('.social-icons a', 'body:not(.overlay-header) .primary-menu ul', '.header-footer-group button', '.header-footer-group .button', '.header-footer-group .faux-button', '.header-footer-group .wp-block-button:not(.is-style-outline) .wp-block-button__link', '.header-footer-group .wp-block-file__button', '.header-footer-group input[type="button"]', '.header-footer-group input[type="reset"]', '.header-footer-group input[type="submit"]'),
				'background-color' => array('#site-header', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal', '.menu-modal-inner', '.search-modal-inner', '.archive-header', '.singular .entry-header', '.singular .featured-media:before', '.wp-block-pullquote:before'),
			),
			'text'       => array(
				'color'               => array('.header-footer-group', 'body:not(.overlay-header) #site-header .toggle', '.menu-modal .toggle'),
				'background-color'    => array('body:not(.overlay-header) .primary-menu ul'),
				'border-bottom-color' => array('body:not(.overlay-header) .primary-menu > li > ul:after'),
				'border-left-color'   => array('body:not(.overlay-header) .primary-menu ul ul:after'),
			),
			'secondary'  => array(
				'color' => array('.site-description', 'body:not(.overlay-header) .toggle-inner .toggle-text', '.widget .post-date', '.widget .rss-date', '.widget_archive li', '.widget_categories li', '.widget cite', '.widget_pages li', '.widget_meta li', '.widget_nav_menu li', '.powered-by-wordpress', '.to-the-top', '.singular .entry-header .post-meta', '.singular:not(.overlay-header) .entry-header .post-meta a'),
			),
			'borders'    => array(
				'border-color'     => array('.header-footer-group pre', '.header-footer-group fieldset', '.header-footer-group input', '.header-footer-group textarea', '.header-footer-group table', '.header-footer-group table *', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal nav *', '.footer-widgets-outer-wrapper', '.footer-top'),
				'background-color' => array('.header-footer-group table caption', 'body:not(.overlay-header) .header-inner .toggle-wrapper::before'),
			),
		),
	);

	$elements = array();

	/**
	 * Filters Twenty Twenty theme elements.
	 *
	 * @since Twenty Twenty 1.0
	 *
	 * @param array Array of elements.
	 */
	return apply_filters('twentytwenty_get_elements_array', $elements);
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
// require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


require get_template_directory() . '/inc/custom-post-type.php';


/**
 * Load custom WordPress nav walker.
 */
if (!class_exists('wp_bootstrap_navwalker')) {
	require_once(get_template_directory() . '/inc/wp_bootstrap_navwalker.php');
}



if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title'     => 'Theme General Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'        => false
	));

	acf_add_options_sub_page(array(
		'page_title'     => 'Theme Header Settings',
		'menu_title'    => 'Header',
		'parent_slug'    => 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title'     => 'Theme Footer Settings',
		'menu_title'    => 'Footer',
		'parent_slug'    => 'theme-general-settings',
	));
}



add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types()
{
	// Check function exists.
	if (function_exists('acf_register_block_type')) {
		acf_register_block_type(array(
			'name'              => 'faqs',
			'title'             => __('FAQs'),
			'description'       => __('FAQs'),
			'render_template'   => 'template-parts/blocks/faqs.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'heading_with_description_button',
			'title'             => __('Heading With Description & Button'),
			'description'       => __('Heading With Description & Button'),
			'render_template'   => 'template-parts/blocks/heading_with_description_button.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'image_Video_with_link',
			'title'             => __('Image / Video With Link'),
			'description'       => __('Image / Video With Link'),
			'render_template'   => 'template-parts/blocks/image_Video_with_link.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'hero_text_left_three_images_in_right',
			'title'             => __('Hero, Text Left, 3 Images In Right'),
			'description'       => __('Hero, Text Left, 3 Images In Right'),
			'render_template'   => 'template-parts/blocks/hero_text_left_three_images_in_right.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'hero_text_left_4images',
			'title'             => __('Hero, Text Left, 4 Images'),
			'description'       => __('Hero, Text Left, 4 Images'),
			'render_template'   => 'template-parts/blocks/hero_text_left_4images.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'left_right_content_with_download_brochure_button',
			'title'             => __('Left/Right Content With Download Brochure Button'),
			'description'       => __('Left/Right Content With Download Brochure Button'),
			'render_template'   => 'template-parts/blocks/left_right_content_with_download_brochure_button.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'mini_site_cta',
			'title'             => __('CTA'),
			'description'       => __('CTA'),
			'render_template'   => 'template-parts/blocks/cta.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'hero_text_right_4images_in_left',
			'title'             => __('Hero, Text Right, 4 Images In Left'),
			'description'       => __('Hero, Text Right, 4 Images In Left'),
			'render_template'   => 'template-parts/blocks/hero_text_right_4images_in_left.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'speakers_data',
			'title'             => __('Speakers Data'),
			'description'       => __('Speakers Data'),
			'render_template'   => 'template-parts/blocks/speakers_data.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'speakers_list',
			'title'             => __('Speakers List'),
			'description'       => __('Speakers List'),
			'render_template'   => 'template-parts/blocks/speakers_list.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'sponsors',
			'title'             => __('Sponsors'),
			'description'       => __('Sponsors'),
			'render_template'   => 'template-parts/blocks/sponsors.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'standard_content',
			'title'             => __('Standard Content'),
			'description'       => __('Standard Content'),
			'render_template'   => 'template-parts/blocks/standard_content.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array('Standard Content', 'quote'),
		));
		acf_register_block_type(array(
			'name'              => 'stream_category_cards_list',
			'title'             => __('Stream Category Cards List'),
			// 'description'       => __('Stream Category Cards List'),
			'render_template'   => 'template-parts/blocks/stream_category_cards_list.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'article_list',
			'title'             => __('Article List'),
			'description'       => __('Article List'),
			'render_template'   => 'template-parts/blocks/article_list.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'main_banner',
			'title'             => __('Main Banner'),
			'description'       => __('Main Banner'),
			'render_template'   => 'template-parts/blocks/main_banner.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'image_grid_highlights',
			'title'             => __('Image Grid Highlights'),
			'description'       => __('Image Grid Highlights'),
			'render_template'   => 'template-parts/blocks/image_grid_highlights.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'conferences_events',
			'title'             => __('Conferences and Events'),
			'render_template'   => 'template-parts/blocks/conferences_events.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'sponsor_data',
			'title'             => __('Sponsor Data'),
			'description'       => __('Sponsor Data'),
			'render_template'   => 'template-parts/blocks/sponsor_data.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
		));
		acf_register_block_type(array(
			'name'              => 'generic_form',
			'title'             => __('Generic Form'),
			'description'       => __('Generic Form'),
			'render_template'   => 'template-parts/blocks/generic_form.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array('Generic Form', 'quote'),
		));
		acf_register_block_type(array(
            'name'              => 'upcoming_event_webinars_version3',
            'title'             => __('Upcoming Events and Webinars version 3'),
            'description'       => __('Upcoming Events and Webinars vserion 3'),
            'render_template'   => 'template-parts/blocks/upcoming_event_webinars_version3.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
        ));
		acf_register_block_type(array(
            'name'              => 'logo_ticker',
            'title'             => __('logo_ticker'),
            'description'       => __('logo_ticker'),
            'render_template'   => 'template-parts/blocks/logo_ticker.php',
			'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array('Profile Card version 2', 'quote'),
        ));
		acf_register_block_type(array(
            'name'              => 'logo_ticker version 2',
            'title'             => __('logo_ticker2'),
            'description'       => __('logo_ticker'),
            'render_template'   => 'template-parts/blocks/logo_ticker2.php',
			'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array('Profile Card version 2', 'quote'),
        ));
		acf_register_block_type(array(
            'name'              => 'icons_with_Modal_link',
            'title'             => __('Icons With Modal Link'),
            'description'       => __('Icons With Modal Link'),
            'render_template'   => 'template-parts/blocks/icons_with_modal_link.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
        ));
		acf_register_block_type(array(
            'name'              => 'content-pricing',
            'title'             => __('Pricing Block'),
            'description'       => __('Pricing Block'),
            'render_template'   => 'template-parts/blocks/content-pricing.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array('Pricing Block'),
        ));
		acf_register_block_type(array(
            'name'              => 'content-pricing-tabs',
            'title'             => __('Pricing Block Tab'),
            'description'       => __('Pricing Block Tab'),
            'render_template'   => 'template-parts/blocks/content-pricing-tab.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array('Pricing Block'),
        ));
		acf_register_block_type(array(
            'name'              => 'content-pricing-single',
            'title'             => __('Pricing Block single'),
            'description'       => __('Pricing Block single'),
            'render_template'   => 'template-parts/blocks/content-pricing-single.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array('Pricing Block'),
        ));
		
	}
}

function hex2rgba($color, $opacity = false)
{

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if (empty($color))
		return $default;

	//Sanitize $color if "#" is provided 
	if ($color[0] == '#') {
		$color = substr($color, 1);
	}

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
	} elseif (strlen($color) == 3) {
		$hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if ($opacity) {
		if (abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode(",", $rgb) . ')';
	}

	//Return rgb(a) color string
	return $output;
}

function filter_event_post_mp009()
{
	$date_now = $_POST["date_now"];
	$date_end00 = date_create($date_now)->format("Y-m-d");
	$date_end = date_create($date_end00 . ' 23:59:59')->format("Y-m-d H:i:s");
	$paged = $_POST["paged"];
	$ev_s = $_POST["ev_s"];

	ob_start();

	if ($ev_s == '') :
		get_template_part('template-parts/eventList', 'none', array('date_now' => $date_now, 'date_end' => $date_end));
	else :
		get_template_part('template-parts/search', 'eventList', array('date_now' => $date_now, 'ev_s' => $ev_s, 'paged' => $paged));
	endif;

	$output = ob_get_contents();
	ob_end_clean();
	wp_send_json_success($output);
}
add_action("wp_ajax_filter_event_post", "filter_event_post_mp009");
add_action("wp_ajax_nopriv_filter_event_post", "filter_event_post_mp009");


function single_event_post_mp009()
{
	$post_id = $_POST["post_id"];

	ob_start();

	if ($post_id) :
		get_template_part('template-parts/single', 'event', array('post_id' => $post_id));
	endif;

	$output = ob_get_contents();
	ob_end_clean();
	wp_send_json_success($output);
}
add_action("wp_ajax_single_event_post", "single_event_post_mp009");
add_action("wp_ajax_nopriv_single_event_post", "single_event_post_mp009");

function event_post_loadmore_mp009()
{
	$term_id = $_POST["term_id"];
	$paged = $_POST["paged"];
	if ($term_id) :
		$postQuery = new WP_Query(array(
			'post_type' => 'stream', 'post_status' => 'publish', 'posts_per_page' => 8, 'fields' => 'ids',
			'paged' => $paged,
			'tax_query'      => array(
				array(
					'taxonomy' => 'stream_category',
					'field'    => 'term_id',
					'terms'    => $term_id,
				)
			),
			/* 'meta_query' => array(
				array(
					'key'           => 'agenda_date',
					'compare'       => '>=',
					'value'         => $date_now,
					'type'          => 'DATETIME',
				)
			), */
		));
		$postList = $postQuery->posts;
		$maxPages = $postQuery->max_num_pages;
		// echo '<pre>'; print_r($postList); echo '</pre>'; 
		ob_start();

		foreach ($postList as $key => $post_id) {
			get_template_part('template-parts/session_item', 'none', array('post_id' => $post_id));
		}

		if ($maxPages > 1 && $maxPages != $paged) : ?>
			<div class="sessions_list__postRow__box loadMore">
				<a href="#" class="btn white sessions_loadMore" data-paged="<?php echo ($paged + 1); ?>">Load More</a>
			</div>
	<?php endif;

	endif;

	$output = ob_get_contents();
	ob_end_clean();
	wp_send_json_success($output);
}
add_action("wp_ajax_event_post_loadmore", "event_post_loadmore_mp009");
add_action("wp_ajax_nopriv_event_post_loadmore", "event_post_loadmore_mp009");

function filter_upcoming_event_webinars_mp10()
{
    $post_count       = $_POST["post_count"];
    $paged       = $_POST["paged"];
    $cat       = $_POST["cat"];
    $sType = $_POST["sType"];
    $cType = $_POST["cType"];

    $args = array(
        'posts_per_page'      => $post_count,
        'post_type'        => 'post',
        'post_status'    => 'publish',
        'paged' => $paged,
        'fields' => 'ids',
		'orderby' 	=> 'date',
        'order' => 'ASC',

		
    );

    if ($sType == "category" && !empty($cat)) {
        $args['cat'] = $cat;
    } else if ($sType == "type" && !empty($cType)) {
        $args['meta_query'] = array(
            array(
                'key'     => 'content_type',
                'value'   => $cType,
                'compare' => 'LIKE',
            ),
        );
    }
    $postQuery = new WP_Query($args);
    $postList = $postQuery->posts;
    $maxPages = $postQuery->max_num_pages;
    ob_start();    ?>
    <?php if (count($postList) > 0) : ?>
        <?php foreach ($postList as $key => $postId) {
            set_query_var('postId', $postId);
            get_template_part('template-parts/content-upcoming_event_webinars_item_version3');
        } ?>
        <?php if ($maxPages > 1 && $paged != $maxPages) : ?>
            <div class="upcoming_event_webinars_list_item updated_upcoming loadMore text-center w-100 mt-5">
                <a href="#" class="upcoming_event_webinars_loadMore btn white" data-paged="<?php echo ($paged + 1); ?>">Load More</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php
    $output = ob_get_contents();
    ob_end_clean();
    wp_send_json_success($output);
}
add_action("wp_ajax_filter_upcoming_event_webinarsa", "filter_upcoming_event_webinars_mp10");
add_action("wp_ajax_nopriv_filter_upcoming_event_webinarsa", "filter_upcoming_event_webinars_mp10");

function my_acf_collor_pallete_script()
{
	?>
	<script type="text/javascript">
		(function($) {

			acf.add_filter('color_picker_args', function(args, $field) {

				// do something to args
				args.palettes = ['#FFFFFF', '#C4C4C4', '#654185', '#4DB6AC', '#4E8EF4', '#96BF0D', '#7772DB', '#FF8A65', '#E5E5E5', '#CE5BDF']

				console.log(args);
				// return
				return args;
			});

		})(jQuery);
	</script>
<?php
}

add_action('acf/input/admin_footer', 'my_acf_collor_pallete_script');

function remove_admin_login_header()
{
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');

// ACF style fix

function acf_filter_rest_api_preload_paths( $preload_paths ) {
  if ( ! get_the_ID() ) {
    return $preload_paths;
  }
  $remove_path = '/wp/v2/' . get_post_type() . 's/' . get_the_ID() . '?context=edit';
  $v1 =  array_filter(
    $preload_paths,
    function( $url ) use ( $remove_path ) {
      return $url !== $remove_path;
    }
  );
  $remove_path = '/wp/v2/' . get_post_type() . 's/' . get_the_ID() . '/autosaves?context=edit';
  return array_filter(
    $v1,
    function( $url ) use ( $remove_path ) {
      return $url !== $remove_path;
    }
  );
}
add_filter( 'block_editor_rest_api_preload_paths', 'acf_filter_rest_api_preload_paths', 10, 1 );


// event ajax work 

function event_script() {
    wp_enqueue_style('slick-style', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
	wp_enqueue_script('slick-script', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), null, true);
	wp_enqueue_script( 'event-ajax', get_stylesheet_directory_uri() . '/assets/js/filter.js',  array( 'jquery' ) , '1.0.0', true );
	wp_localize_script( 'event-ajax', 'event_ajax_object',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        )
    );
}
add_action( 'wp_enqueue_scripts', 'event_script' );


add_action('wp_ajax_event_action', 'event_action_function'); 
add_action('wp_ajax_nopriv_event_action', 'event_action_function');
function event_action_function(){  
	//if(isset($_POST['event_term'])){
	    
	    
	    if( isset($_POST['reset']) && $_POST['reset'] == "yes" ){
	        $evnts = [];
	    } else {
	         $evnts = $_POST['event_term'];
	    }
	    
	   
	    $date_now = $_POST['date_now'];
	    
	    
	    $datemn= date("Y-m-d");
	   
    	$date_end00 = date_create($date_now)->format("Y-m-d");
    	if ($date_end00 < $datemn){
    	    $date_end00 = date('Y-m-d', strtotime('+1 year', strtotime($date_end00)) );
    	    $date_end00 = date('Y-m-d', strtotime('-1 day', strtotime($date_end00)) );
    	    
    	}
    	
    	
    	$date_end = date_create($date_end00 . ' 23:59:59')->format("Y-m-d H:i:s");
    	
    	$paged = $_POST["paged"];
    	$ev_s = $_POST["ev_s"];
    
    	ob_start();
    
    	if ($ev_s == '') :
    	    get_template_part('template-parts/eventList', 'none', array('date_now' => $date_now, 'date_end' => $date_end, 'evnts' => $evnts) );
    	else :
    		get_template_part('template-parts/search', 'eventList', array('date_now' => $date_now, 'ev_s' => $ev_s, 'paged' => $paged));
    	endif;
    
    	$output = ob_get_contents();
    	ob_end_clean();
    	wp_send_json_success($output);
    	die;
    	
//	}
}

add_editor_style('dist/css/site.css');

// Enable font size & font family selects in the editor.
add_filter( 'mce_buttons_2', function( $buttons ) {
	array_unshift( $buttons, 'fontselect' );
	array_unshift( $buttons, 'fontsizeselect' );
	return $buttons;
} );

// Add custom Fonts to the Fonts list.
add_filter( 'tiny_mce_before_init', function( $initArray ) {
    $initArray['font_formats'] = 'Lato=Lato;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;Work sans Bold=work_sansbold;Work sans Regular=work_sansregular;Work sans Semibold=work_sanssemibold;Work sans pro Semi bold=source_sans_prosemibold';
	return $initArray;
} );