<?php
namespace O10n;

/**
 * HTML Optimization Controller
 *
 * @package    optimization
 * @subpackage optimization/controllers
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */
if (!defined('ABSPATH')) {
    exit;
}

class Html extends Controller implements Controller_Interface
{
    private $preserve_comments = false; // preserve comments
    private $replace = false; // replace in HTML

    private $minifier; // minifier
    
    /**
     * Load controller
     *
     * @param  Core       $Core Core controller instance.
     * @return Controller Controller instance.
     */
    public static function &load(Core $Core)
    {
        // instantiate controller
        return parent::construct($Core, array(
            'env',
            'output',
            'options'
        ));
    }

    /**
     * Setup controller
     */
    protected function setup()
    {
        // disabled
        if (!$this->env->is_optimization()) {
            return;
        }

        /*
         * Preserve comments
         */
        if ($this->options->bool('html.remove_comments')) {
            $this->preserve_comments = $this->options->get('html.remove_comments.preserve');
            if (!is_array($this->preserve_comments)) {
                $this->preserve_comments = false;
            }
        }

        // HTML Search & Replace
        $this->replace = $this->options->get('html.replace');
        if (isset($this->replace) && is_array($this->replace) && !empty($this->replace)) {
        
            // add filter for HTML output
            add_filter('o10n_html_pre', array( $this, 'search_replace' ), $this->first_priority, 1);
        } else {
            $this->replace = false;
        }

        /**
         * HTML Optimization Enabled
         */
        if ($this->options->bool('html.minify.enabled')) {

            // minifier
            $this->minifier = $this->options->get('html.minify.minifier', 'htmlphp');

            // add filter for HTML output
            add_filter('o10n_html', array( $this, 'process_html' ), 1000, 1);
        }
    }

    /**
     * Minify the markeup given in the constructor
     *
     * @return string
     */
    final public function process_html($HTML)
    {
        // verify if empty
        $HTML = trim($HTML);
        if ($HTML === '') {
            return $HTML; // no data to compress
        }

        // minimum bytes required to activate optimization
        if ($bytes = $this->options->get('html.minimum_bytes')) {
            if (strlen($HTML) < $bytes) {
                return $HTML;
            }
        }

        // remove HTML comments
        if ($this->options->bool('html.remove_comments')) {
            $HTML = preg_replace_callback(
                '/<!--([\\s\\S]*?)-->/',
                array($this, 'remove_comments'),
                $HTML
            );
        }

        // minification
        if ($this->options->bool('html.minify')) {
            switch ($this->minifier) {
                case "voku-htmlmin":
                    if (!class_exists('\voku\helper\HtmlMin')) {
                        require_once $this->core->modules('html')->dir_path() . 'lib/vendor/autoload.php';
                    }

                    $htmlMin = new \voku\helper\HtmlMin();

                    $options = array(
                        'doOptimizeViaHtmlDomParser',
                        'doRemoveComments',
                        'doSumUpWhitespace',
                        'doRemoveWhitespaceAroundTags',
                        'doOptimizeAttributes',
                        'doRemoveHttpPrefixFromAttributes',
                        'doRemoveDefaultAttributes',
                        'doRemoveDeprecatedAnchorName',
                        'doRemoveDeprecatedScriptCharsetAttribute',
                        'doRemoveDeprecatedTypeFromScriptTag',
                        'doRemoveDeprecatedTypeFromStylesheetLink',
                        'doRemoveEmptyAttributes',
                        'doRemoveValueFromEmptyInput',
                        'doSortCssClassNames',
                        'doSortHtmlAttributes',
                        'doRemoveSpacesBetweenTags',
                        'doRemoveOmittedQuotes',
                        'doRemoveOmittedHtmlTags'
                    );
                    foreach ($options as $option_name) {
                        $htmlMin->{$option_name}($this->options->bool('html.minify.voku-htmlmin.' . $option_name));
                    }

                    // minify
                    try {
                        $minified = $htmlMin->minify($HTML);
                    } catch (\Exception $err) {
                        throw new Exception('HtmlMin minifier failed: ' . $err->getMessage(), 'js');
                    }

                    if (!$minified && $minified !== '') {
                        throw new Exception('HtmlMin minifier failed: unknown error', 'js');
                    }

                break;
                case "custom":

                    // minify
                    try {
                        $minified = apply_filters('o10n_html_custom_minify', $HTML);
                    } catch (\Exception $err) {
                        throw new Exception('Custom HTML minifier failed: ' . $err->getMessage(), 'js');
                    }

                    if (!$minified && $minified !== '') {
                        throw new Exception('Custom HTML minifier failed: unknown error', 'js');
                    }

                break;
                case "htmlphp":
                default:

                    // load library
                    if (!class_exists('O10n\HTMLMinify')) {
                        require_once $this->core->modules('html')->dir_path() . 'lib/HTML.php';
                    }
                    $htmlmin = new HTMLMinify();

                    // try minification
                    try {
                        $minified = $htmlmin->minify($HTML);
                    } catch (Exception $err) {
                        $minified = false;
                    }

                break;
            }
            

            if ($minified) {
                return $minified;
            } else {
                return $HTML;
            }
        }

        return $HTML;
    }

    /**
     * HTML Search & Replace
     */
    final public function search_replace($HTML)
    {
        if ($this->replace) {
            foreach ($this->replace as $object) {
                if (!isset($object['search']) || trim($object['search']) === '') {
                    continue;
                }

                if (isset($object['regex']) && $object['regex']) {
                    $this->output->add_search_replace($object['search'], $object['replace'], true);
                } else {
                    $this->output->add_search_replace($object['search'], $object['replace']);
                }
            }
        }

        return $HTML;
    }
    
    /**
     * Remove comments from HTML
     *
     * @param  array  $match The preg_replace_callback match result.
     * @return string The modified string.
     */
    final private function remove_comments($match)
    {
        if (!empty($this->preserve_comments)) {
            foreach ($this->preserve_comments as $str) {
                if (strpos($match[1], $str) !== false) {
                    return $match[0];
                }
            }
        }

        return (0 === strpos($match[1], '[') || false !== strpos($match[1], '<!['))
            ? $match[0]
            : '';
    }
}
