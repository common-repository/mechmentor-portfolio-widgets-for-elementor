<?php
/**
 * Mechlin Portfolio Init Class
 *
 * @package Mechlin Portfolio
 */
defined('ABSPATH') || exit;

/**
 * Main Mechlin_Portfolio Class.
 *
 * @class Mechlin_Portfolio
 */
final class Mechlin_Portfolio {

    /**
     * Version.
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * The single instance of the class.
     *
     * @var Mechlin_Portfolio
     */
    protected static $_instance = null;

    /**
     * Main Mechlin_Portfolio Instance.
     *
     * Ensures only one instance of Mechlin_Portfolio is loaded or can be loaded.
     *
     * @static
     * @see Mechlin_Portfolio()
     * @return Mechlin_Portfolio - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Cloning is forbidden.
     */
    public function __clone() {
        wc_doing_it_wrong(__FUNCTION__, esc_html__('Cloning is forbidden.', 'mechlin-portfolio'), $this->version);
    }

    /**
     * Unserializing instances of this class is forbidden.
     */
    public function __wakeup() {
        wc_doing_it_wrong(__FUNCTION__, esc_html__('Unserializing instances of this class is forbidden.', 'mechlin-portfolio'), $this->version);
    }

    /**
     * Mechlin_Portfolio Constructor.
     */
    public function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Init Hooks
     */
    public function init_hooks() {
        add_action('init', array($this, 'textdomain'));
        add_action('elementor/frontend/after_register_styles', array($this, 'frontend_styles'), 10);
        add_action('elementor/frontend/after_register_scripts', array($this, 'frontend_scripts'), 10);
        add_action('elementor/widgets/widgets_registered', array($this, 'widgets_registered'));
        add_action('elementor/init', array($this, 'new_elementor_category'));
        add_action('wp_footer', array($this, 'load_single_template'));
    }

    /**
     * Define Constants.
     */
    private function define_constants() {
        $this->define('MPT_DEBUG', true);
        $this->define('MPT_ABSPATH', dirname(MPT_FILE) . '/');
        $this->define('MPT_PLUGIN_BASENAME', plugin_basename(MPT_FILE));
        $this->define('MPT_DIR', plugin_dir_path(dirname(__FILE__)));
        $this->define('MPT_ROOT_DIR', plugins_url() . '/' . plugin_basename(MPT_FILE) . '/');
        $this->define('MPT_VERSION', $this->version);
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value) {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Localize
     */
    public function textdomain() {
        load_plugin_textdomain('mechlin-portfolio', FALSE, dirname(plugin_basename(MPT_FILE)) . '/languages/');
    }

    /**
     * Load Scripts
     */
    public function frontend_scripts() {
        wp_enqueue_script('infiniteScroll', plugins_url('assets/js/infiniteScroll.js', MPT_FILE), array('jquery'), '', true);
        wp_enqueue_script('niceScroll', plugins_url('assets/js/niceScroll.js', MPT_FILE), array('jquery'), '', true);
        wp_enqueue_script('mechlin-portfolio', plugins_url('assets/js/mech-portfolio.js', MPT_FILE), array('jquery', 'masonry', 'imagesloaded'), '', true);
        wp_localize_script('mechlin-portfolio', 'mpt_data',
                array(
                    'ajaxurl' => admin_url('admin-ajax.php')
                )
        );
    }

    /**
     * Load Style
     */
    public function frontend_styles() {
        wp_enqueue_style('mechlin-portfolio', plugins_url('assets/css/mechlin-portfolio.css', MPT_FILE));
    }

    /**
     * New Elementor Category
     */
    public function new_elementor_category() {
        \Elementor\Plugin::instance()->elements_manager->add_category(
                'mechlin-portfolio',
                array(
                    'title' => esc_html__('Mechlin Portfolio', 'mechlin-portfolio'),
                    'icon' => 'fa fa-plug',
                ),
                2);
    }

    /**
     * Register Widget
     */
    public function widgets_registered($widgets_manager) {

        include_once MPT_ABSPATH . 'inc/widgets/mpt-portfolio.php';
        $widgets_manager->register_widget_type(new MPT_Portfolio());
    }

    /**
     * Include Files
     */
    public function includes() {
        include_once MPT_ABSPATH . 'inc/class-template-loader.php';
        include_once MPT_ABSPATH . 'inc/functions.php';
    }

    /**
     * Load Widget Template
     */
    public function load_template($slug, $name = '', $settings = array()) {

        $templates = new MPT_Template_Loader();
        $data = array();

        foreach ($settings as $key => $value) {
            $data[$key] = $value;
        }

        $templates
                ->set_template_data($data, 'mpt_data')
                ->get_template_part($slug, $name);
    }

    /**
     * Load Single Template
     */
    public function load_single_template() {
        mpt_load_template('mpt-portfolio', 'single', array());
    }

}
