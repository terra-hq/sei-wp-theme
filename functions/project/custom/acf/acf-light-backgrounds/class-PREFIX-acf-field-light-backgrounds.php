<?php
/**
 * Defines the custom field type class.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * PREFIX_acf_field_FIELD_NAME class.
 */
class PREFIX_acf_field_lightbackgrounds extends \acf_field
{
    /**
     * Controls field type visibilty in REST requests.
     *
     * @var bool
     */
    public $show_in_rest = true;

    /**
     * Environment values relating to the theme or plugin.
     *
     * @var array $env Plugin or theme context such as 'url' and 'version'.
     */
    private $env;

    /**
     * Constructor.
     */
    public function __construct()
    {
        /**
         * Field type reference used in PHP and JS code.
         *
         * No spaces. Underscores allowed.
         */
        $this->name = 'lightbackgrounds';

        /**
         * Field type label.
         *
         * For public-facing UI. May contain spaces.
         */
        $this->label = __('Background Color Light', 'TEXTDOMAIN');

        /**
         * The category the field appears within in the field type picker.
         */
        $this->category = 'basic'; // basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME

        /**
         * Defaults for your custom user-facing settings for this field type.
         */
        $this->defaults = array(
            'font_size' => 14,
        );

        /**
         * Strings used in JavaScript code.
         *
         * Allows JS strings to be translated in PHP and loaded in JS via:
         *
         * ```js
         * const errorcoloroptions = acf._e("FIELD_NAME", "error");
         * ```
         */
        $this->l10n = array(
            'error' => __('Error! Please enter a higher value', 'TEXTDOMAIN'),
        );

        $this->env = array(
            'url' => site_url(str_replace(ABSPATH, '', __DIR__)), // URL to the acf-FIELD-NAME directory.
            'version' => '1.0', // Replace this with your theme or plugin version constant.
        );

        parent::__construct();
    }

    /**
     * Settings to display when users configure a field of this type.
     *
     * These settings appear on the ACF “Edit Field Group” admin page when
     * setting up the field.
     *
     * @param array $field
     * @return void
     */
    public function render_field_settings($field)
    {
        /*
         * Repeat for each setting you wish to display for this field type.
         */



        // To render field settings on other tabs in ACF 6.0+:
        // https://www.advancedcustomfields.com/resources/adding-custom-settings-fields/#moving-field-setting
    }

    /**
     * HTML content to show when a publisher edits the field on the edit screen.
     *
     * @param array $field The field settings and values.
     * @return void
     */
    public function render_field($field)
    {
        ?>

        <div class="dropdown-color js--background-color-light">
            <div class="selected">
                <a href="#"><span>Please select</span></a>
            </div>
            <div class="options js--select-light-background-color">
                <ul>
                    <li value="primary"><a href="#" class="c--color-bg-a c--color-bg--white" data-value="f--background-a">
                            <div></div>White
                        </a></li>
                    <li><a href="#" data-value="f--background-b" class="c--color-bg-a c--color-bg--grey">
                            <div></div>Grey
                        </a></li>
                </ul>
            </div>
        </div>

        <input type="hidden" class="setting-font-size js--background-color-light" name="<?php echo esc_attr($field['name']) ?>"
            value="<?php echo esc_attr($field['value']) ?>" />
        <?php
    }

    /**
     * Enqueues CSS and JavaScript needed by HTML in the render_field() method.
     *
     * Callback for admin_enqueue_script.
     *
     * @return void
     */
    public function input_admin_enqueue_scripts()
    {
        $url = trailingslashit($this->env['url']);
        $version = date("F j, Y, g:i a");
        wp_register_script(
            'PREFIX-lightbackgrounds',
            "{$url}assets/js/background-color.js",
            array('acf-input'),
            $version
        );
        wp_register_style(
            'PREFIX-lightbackgrounds',
            "{$url}assets/css/background-color.css",
            array('acf-input'),
            $version
        );

        wp_enqueue_script('PREFIX-lightbackgrounds');
        wp_enqueue_style('PREFIX-lightbackgrounds');
    }
}
