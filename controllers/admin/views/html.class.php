<?php
namespace O10n;

/**
 * HTML Optimization Admin View Controller
 *
 * @package    optimization
 * @subpackage optimization/controllers/admin
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH')) {
    exit;
}

class AdminViewHtml extends AdminViewBase
{
    protected static $view_key = 'html'; // reference key for view
    protected $module_key = 'html';

    // default tab view
    private $default_tab_view = 'intro';

    /**
     * Load controller
     *
     * @param  Core       $Core   Core controller instance.
     * @param  false      $module Module parameter not used for core view controllers
     * @return Controller Controller instance.
     */
    public static function &load(Core $Core)
    {
        // instantiate controller
        return parent::construct($Core, array(
            'json',
            'file',
            'AdminClient'
        ));
    }
    
    /**
     * Setup controller
     */
    protected function setup()
    {
        // WPO plugin
        if (defined('O10N_WPO_VERSION')) {
            $this->default_tab_view = 'optimization';
        }
        // set view etc
        parent::setup();
    }

    /**
     * Setup view
     */
    public function setup_view()
    {
        // process form submissions
        add_action('o10n_save_settings_verify_input', array( $this, 'verify_input' ), 10, 1);

        // enqueue scripts
        add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), $this->first_priority);
    }

    /**
     * Return help tab data
     */
    final public function help_tab()
    {
        $data = array(
            'name' => __('HTML Optimization', 'o10n'),
            'github' => 'https://github.com/o10n-x/wordpress-html-optimization',
            'wordpress' => 'https://wordpress.org/support/plugin/html-optimization',
            'docs' => 'https://github.com/o10n-x/wordpress-html-optimization/tree/master/docs'
        );

        return $data;
    }

    /**
     * Enqueue scripts and styles
     */
    final public function enqueue_scripts()
    {
        // skip if user is not logged in
        if (!is_admin() || !is_user_logged_in()) {
            return;
        }

        // set module path
        $this->AdminClient->set_config('module_url', $this->module->dir_url());
    }


    /**
     * Return view template
     */
    public function template($view_key = false)
    {
        // template view key
        $view_key = false;

        $tab = (isset($_REQUEST['tab'])) ? trim($_REQUEST['tab']) : $this->default_tab_view;
        switch ($tab) {
            case "optimization":
            case "intro":
                $view_key = 'html-' . $tab;
            break;
            default:
                throw new Exception('Invalid view ' . esc_html($view_key), 'core');
            break;
        }

        return parent::template($view_key);
    }
    
    /**
     * Verify settings input
     *
     * @param  object   Form input controller object
     */
    final public function verify_input($forminput)
    {
        // HTML Optimization

        $tab = (isset($_REQUEST['tab'])) ? trim($_REQUEST['tab']) : 'optimization';

        switch ($tab) {
            case "optimization":

                $forminput->type_verify(array(
                    'html.minify.enabled' => 'bool',
                    'html.minify.minifier' => 'string',
                    'html.remove_comments.enabled' => 'bool',
                    'html.remove_comments.preserve' => 'newline_array',
                    'html.replace' => 'json-array'
                ));

                $minifier = $forminput->get('html.minify.minifier');
                if ($minifier === 'voku-htmlmin') {
                    $forminput->type_verify(array(
                        'html.minify.voku-htmlmin.doOptimizeViaHtmlDomParser' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveComments' => 'bool',
                        'html.minify.voku-htmlmin.doSumUpWhitespace' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveWhitespaceAroundTags' => 'bool',
                        'html.minify.voku-htmlmin.doOptimizeAttributes' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveHttpPrefixFromAttributes' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveDefaultAttributes' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveDeprecatedAnchorName' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveDeprecatedScriptCharsetAttribute' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveDeprecatedTypeFromScriptTag' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveDeprecatedTypeFromStylesheetLink' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveEmptyAttributes' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveValueFromEmptyInput' => 'bool',
                        'html.minify.voku-htmlmin.doSortCssClassNames' => 'bool',
                        'html.minify.voku-htmlmin.doSortHtmlAttributes' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveSpacesBetweenTags' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveOmittedQuotes' => 'bool',
                        'html.minify.voku-htmlmin.doRemoveOmittedHtmlTags' => 'bool'
                    ));
                }
            break;
        }
    }
}
