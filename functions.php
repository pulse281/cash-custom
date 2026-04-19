<?php
/**
 * Cash-custom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cash-custom
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cash_custom_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Cash-custom, use a find and replace
		* to change 'cash-custom' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'cash-custom', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'cash-custom' ),
		)
	);

	add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args, $depth ) {
    if ( isset( $args->add_a_class ) ) {
        $atts['class'] = $args->add_a_class;
    }
    return $atts;
	}, 10, 4 );

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
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'cash_custom_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'cash_custom_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cash_custom_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cash_custom_content_width', 640 );
}
add_action( 'after_setup_theme', 'cash_custom_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cash_custom_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'cash-custom' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'cash-custom' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'cash_custom_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cash_custom_scripts() {
	wp_enqueue_style( 'cash-custom-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'cash-custom-style', 'rtl', 'replace' );

	wp_enqueue_script( 'cash-custom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cash_custom_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_theme_support( 'custom-logo' );

function cash_scripts() {

	wp_enqueue_script(
		'cash-scripts',
		get_template_directory_uri() . '/assets/js/script.js',
		array(),
		null,
		true
	);

	wp_enqueue_script(
		'theme-custom-js',
		get_template_directory_uri() . '/assets/js/custom.js',
		array('cash-scripts'),
		'1.0',
		true
	);
}
add_action('wp_enqueue_scripts', 'cash_scripts');

add_filter('wpseo_breadcrumb_links', function($links) {

    if (is_404()) {
        return array(
            array(
                'url'  => home_url('/'),
                'text' => 'Главная',
            ),
            array(
                'text' => '404'
            )
        );
    }

    if (is_single()) {

        $categories = get_the_category();

        if (!empty($categories)) {

            $category = $categories[0];

            $new_link = array(
                'url'  => get_category_link($category->term_id),
                'text' => $category->name,
            );

            array_splice($links, 1, 0, array($new_link));
        }
    }

    return $links;
});

// Убрать RSS
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

// Убрать RSD
remove_action('wp_head', 'rsd_link');

// Убрать Windows Live Writer
remove_action('wp_head', 'wlwmanifest_link');

// Убрать shortlink
remove_action('wp_head', 'wp_shortlink_wp_head');

// Убрать REST API
remove_action('wp_head', 'rest_output_link_wp_head');

// Убрать oEmbed
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

// Убрать generator
remove_action('wp_head', 'wp_generator');

// Убрать emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Скрыть версию ВП
function remove_wp_version() {
return '';
}
add_filter('the_generator', 'remove_wp_version');

//Скрыть WordPress API linkWordPress API link
remove_action('template_redirect', 'rest_output_link_header', 11);

//Отключаем Gutenberg CSS
function remove_wp_block_styles() {

wp_dequeue_style('wp-block-library');
wp_dequeue_style('wp-block-library-theme');
wp_dequeue_style('global-styles');

}

add_action('wp_enqueue_scripts', 'remove_wp_block_styles', 100);

//Исправить inLanguage через фильтр Yoast
add_filter('wpseo_schema_webpage', function($data) {
    $data['inLanguage'] = 'uk-UA';
    return $data;
});

add_filter('wpseo_schema_website', function($data) {
    $data['inLanguage'] = 'uk-UA';
    return $data;
});

// Отключаем комментарий Yoast SEO в <head>
add_filter( 'wpseo_frontend_print_yoast_comment', '__return_false' );


//Активируем виджеты в хедере
function my_custom_widgets_init() {
    register_sidebar(array(
        'name'          => 'Header Widgets',
        'id'            => 'header-widgets',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'my_custom_widgets_init');

//Локализация для страницы категорий
add_filter('category_template', function ($template) {
    // Список ярлыков (slug), которые должны использовать один шаблон
    $target_slugs = ['offers', 'offers-en', 'offers-ru'];
    
    $object = get_queried_object();
    
    if ($object && in_array($object->slug, $target_slugs)) {
     
        $new_template = locate_template(['category-offers.php']);
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    
    return $template;
});

//Перевод статичных слов
add_action('init', function() {
    // Группа: Основные элементы карточки оффера
    pll_register_string('Offer Card', 'Рейтинг', 'Home Page');
    pll_register_string('Offer Card', 'Ліцензія', 'Home Page');
    pll_register_string('Offer Card', 'Робочий час', 'Home Page');
    pll_register_string('Offer Card', 'Сума позики до', 'Home Page');
    pll_register_string('Offer Card', 'грн.', 'Home Page');
    pll_register_string('Offer Card', 'Перший кредит', 'Home Page');
    pll_register_string('Offer Card', 'Відсоток від', 'Home Page');
    pll_register_string('Offer Card', 'Ставка в день', 'Home Page');
    pll_register_string('Offer Card', 'Термін до', 'Home Page');
    pll_register_string('Offer Card', 'днів', 'Home Page');
    pll_register_string('Offer Card', 'Строк позики', 'Home Page');
    
    // Группа: Юридическая информация и ссылки
    pll_register_string('Offer Legal', 'Реальна річна процентна ставка', 'Home Page');
    pll_register_string('Offer Legal', 'Істотні характеристики послуги', 'Home Page');
    pll_register_string('Offer Legal', 'Попередження про можливі наслідки', 'Home Page');
    
    // Группа: Кнопки и триггеры
    pll_register_string('Offer Buttons', 'Подати заявку', 'Home Page');
    pll_register_string('Offer Buttons', 'Детальніше', 'Home Page');
    pll_register_string('Offer Buttons', 'закрити', 'Home Page');
    
    // Группа: Детальная информация (выпадающий блок)
    pll_register_string('Offer Details', 'Повторний кредит', 'Home Page');
    pll_register_string('Offer Details', 'до', 'Home Page');
    pll_register_string('Offer Details', 'грн., ставка в день', 'Home Page');
    pll_register_string('Offer Details', 'на термін до', 'Home Page');
    pll_register_string('Offer Details', 'Вік', 'Home Page');
    pll_register_string('Offer Details', 'Необхідні документи', 'Home Page');
    pll_register_string('Offer Details', 'Паспорт громадянина України', 'Home Page');
    pll_register_string('Offer Details', 'ІПН', 'Home Page');
    pll_register_string('Offer Details', 'Працевлаштування', 'Home Page');
    pll_register_string('Offer Details', "Не обов'язково", 'Home Page');
    pll_register_string('Offer Details', 'Кредитна історія', 'Home Page');
    pll_register_string('Offer Details', 'Можна з поганою кредитною історією', 'Home Page');
    pll_register_string('Offer Details', 'Отримання', 'Home Page');
    pll_register_string('Offer Details', 'Онлайн на карту', 'Home Page');
    pll_register_string('Offer Details', 'Дострокове погашення', 'Home Page');
    pll_register_string('Offer Details', 'Можливе', 'Home Page');
    pll_register_string('Offer Details', 'Пролонгація', 'Home Page');
    pll_register_string('Offer Details', 'Можлива', 'Home Page');
    pll_register_string('Offer Details', 'Розгляд', 'Home Page');
    pll_register_string('Offer Details', '15 хвилин', 'Home Page');
    
    // Группа: Способы погашения
    pll_register_string('Offer Payment', 'Способи погашення кредиту', 'Home Page');
    pll_register_string('Offer Payment', 'За банківськими реквізитами', 'Home Page');
    pll_register_string('Offer Payment', 'Онлайн в особистому кабінеті МФО або через інтернет-банкінг', 'Home Page');
    pll_register_string('Offer Payment', 'Через термінали самообслуговування', 'Home Page');
    
    // Группа: Футер и контакты
    pll_register_string('Footer Contacts', 'Адреса', 'Home Page');
    pll_register_string('Footer Contacts', 'Телефон', 'Home Page');
    pll_register_string('Footer Contacts', 'e-mail', 'Home Page');
    
    // Группа: Сообщения
    pll_register_string('Messages', 'Збільшуйте шанси на позитивне рішення обравши декілька компаній', 'Home Page');
});

/* function custom_redirect_script() {
    wp_enqueue_script('jquery');

    wp_add_inline_script('jquery', '
        jQuery(function ($) {
            $("#offers").on("mousedown", "a.rdr, a.img-link", function () {
                const url = this.dataset.href;
                if (url) this.href = "#";
            });

            $("#offers").on("contextmenu", "a.rdr, a.img-link", function () {
                const url = this.dataset.href;
                if (url) this.href = url;
            });

            $("#offers").on("click", "a.rdr, a.img-link", function (e) {
                const url = this.dataset.href;
                if (url) {
                    e.preventDefault();
                    window.open(url, "_blank");
                }
            });
        });
    ');
}
add_action('wp_enqueue_scripts', 'custom_redirect_script'); */