<?php
namespace O10n;

/**
 * HTML optimization admin template
 *
 * @package    optimization
 * @subpackage optimization/admin
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH') || !defined('O10N_ADMIN')) {
    exit;
}

// print form header
$this->form_start(__('HTML Optimization', 'o10n'), 'html');

?>

<table class="form-table">
    <tr valign="top">
        <th scope="row">Minify HTML</th>
        <td>
            <label><input type="checkbox" name="o10n[html.minify.enabled]" data-json-ns="1" value="1"<?php $checked('html.minify.enabled'); ?> /> Enabled</label>
            <p class="description">Compress and optimize HTML code.</p>


            <div class="suboption" data-ns="html.minify"<?php $visible('html.minify'); ?>>

                <p class="poweredby" data-ns="html.minify"<?php $visible('html.minify', ($get('html.minify.minifier') === 'htmlphp')); ?> data-ns-condition="html.minify.minifier==htmlphp">Powered by <a href="https://github.com/mrclay/minify/" target="_blank">Minify's HTML.php</a><span class="star">
                    <a class="github-button" data-manual="1" href="https://github.com/mrclay/minify/" data-icon="octicon-star" data-show-count="true" aria-label="Star mrclay/minify on GitHub">Star</a></span>
                    </p>

                <p class="poweredby" data-ns="html.minify"<?php $visible('html.minify', ($get('html.minify.minifier') === 'voku-htmlmin')); ?> data-ns-condition="html.minify.minifier==voku-htmlmin">Powered by <a href="https://github.com/voku/HtmlMin" target="_blank">HtmlMin</a><span class="star">
                    <a class="github-button" data-manual="1" href="https://github.com/voku/HtmlMin" data-icon="octicon-star" data-show-count="true" aria-label="Star voku/HtmlMin on GitHub">Star</a></span>
                    </p>

                <select name="o10n[html.minify.minifier]" data-ns-change="html.minify" data-json-default="<?php print esc_attr(json_encode('htmlphp')); ?>">
                    <option value="htmlphp"<?php $selected('html.minify.minifier', 'htmlphp'); ?>>HTML.php from Minify (mcrclay)</option>
                    <option value="voku-htmlmin"<?php $selected('html.minify.minifier', 'voku-htmlmin'); ?>>HtmlMin by voku</option>
                    <option value="custom"<?php $selected('html.minify.minifier', 'custom'); ?>>Custom minifier (WordPress filter hook)</option>
                </select> 
                <p class="description">Choose a minifier that provides the best performance for your HTML code.</p>
            </div>

            <div class="suboption" data-ns="html.minify"<?php $visible('html.minify', ($get('html.minify.minifier') === 'custom')); ?> data-ns-condition="html.minify.minifier==custom">
                <p style="font-size:16px;line-height:18px;">The Custom Minifier option enables to use any HTML minifier via the WordPress filter hook <code>o10n_html_custom_minify</code>. (<a href="javascript:void(0);" onclick="jQuery('#custom_minify_example').fadeToggle();">show example</a>)</p>
            <div class="info_yellow" id="custom_minify_example" style="display:none;"><strong>Example:</strong> <pre class="clickselect" title="<?php print esc_attr('Click to select', 'optimization'); ?>" style="cursor:copy;padding: 10px;margin: 0 1px;margin-top:5px;font-size: 13px;">
/* Custom HTML minifier */
add_filter('o10n_html_custom_minify', function ($HTML) {

    // apply html optimization
    exec('/node /path/to/optimize-html.js /tmp/js-source.html');
    $minified = file_get_contents('/tmp/output.html');

    // alternative
    $minified = HTMLCompressor::minify($HTML);

    return $minified;

});</pre></div>
            </div>
        </td>
    </tr>
</table>


<div class="advanced-options" data-ns="html.minify" data-json-advanced="html.minify.voku-htmlmin"<?php $visible('html.minify', ($get('html.minify.minifier') === 'voku-htmlmin')); ?> data-ns-condition="html.minify.minifier==voku-htmlmin">

    <p class="warning_red">Due to <a href="https://make.wordpress.org/systems/2018/03/12/change-all-svn-php-linting-to-php7/" target="_blank">a bug</a> in WordPress SVN it is not possible yet to publish PHP 7+ code on WordPress. The <code>HtmlDomParser()</code> options require Symfony <a href="https://github.com/symfony/css-selector/" target="_blank">css-selector</a> (PHP 7). If you want to start using this option you can manually install the css-selector dependency via composer in the directory <code>cd /wp-content/plugins/html-optimization/lib/; composer require symfony/css-selector</code>.</p>

    <table class="advanced-options-table widefat fixed striped">
        <colgroup><col style="width: 85px;"/><col style="width: 250px;"/><col /></colgroup>
        <thead class="first">
            <tr>
                <th class="toggle">
                    <a href="javascript:void(0);" class="advanced-toggle-all button button-small">Toggle All</a>
                </th>
                <th class="head">
                  HtmlMin Options
                </th>
                <th>
                    <p class="poweredby">Powered by <a href="https://github.com/voku/HtmlMin" target="_blank">HtmlMin</a><span class="star">
                    <a class="github-button" data-manual="1" href="https://github.com/voku/HtmlMin" data-icon="octicon-star" data-show-count="true" aria-label="Star voku/HtmlMin on GitHub">Star</a></span>
                    </p>
                </th> 
            </tr>
        </thead>
        <tbody>
<?php
    $advanced_options('html.minify.voku-htmlmin');
?>
        </tbody>
    </table>
<br />
<?php
submit_button(__('Save'), 'primary large', 'is_submit', false);
?>
<br />
</div>

<table class="form-table">
    <tr valign="top">
        <th scope="row">Strip HTML comments</th>
        <td>
            <label><input type="checkbox" name="o10n[html.remove_comments.enabled]" data-json-ns="1" value="1"<?php $checked('html.remove_comments.enabled', true); ?> /> Enabled</label>
            <p class="description">Remove HTML comments from HTML, e.g. <code>&lt;!-- comment --&gt;</code>.</p>
        </td>
    </tr>
    <tr valign="top" data-ns="html.remove_comments"<?php $visible('html.remove_comments'); ?>>
        <th scope="row">&nbsp;</th>
        <td style="padding-top:0px;">
            <h5 class="h">&nbsp;Preserve List</h5>
            <textarea class="json-array-lines" name="o10n[html.remove_comments.preserve]" data-json-type="json-array-lines"><?php $line_array('html.remove_comments.preserve'); ?></textarea>
            <p class="description">Enter (parts of) HTML comments to exclude from removal. One string per line.</p>
        </td>
    </tr>
</table>

<h3 style="margin-bottom:0px;" id="searchreplace">Search &amp; Replace</h3>
<?php $searchreplace = $get('html.replace', array()); ?>
<p class="description">This option enables to replace strings in the HTML. Enter JSON objects <span class="dashicons dashicons-editor-help"></span>.</p>
<div id="html-replace"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'optimization'); ?></div></div>
<input type="hidden" class="json" name="o10n[html.replace]" data-json-type="json-array" data-json-editor-compact="1" data-json-editor-init="1" value="<?php print esc_attr($json('html.replace')); ?>" />

<div class="info_yellow"><strong>Example:</strong> <code id="html_search_replace_example" class="clickselect" data-example-text="show string" title="<?php print esc_attr('Click to select', 'optimization'); ?>" style="cursor:copy;">{"search":"string to match","replace":"newstring"}</code> (<a href="javascript:void(0);" data-example="html_search_replace_example" data-example-html="<?php print esc_attr(__('{"search":"|string to (match)|i","replace":"newstring $1","regex":true}', 'optimization')); ?>">show regular expression</a>)</div>

<p>You can also add a search and replace configuration using the PHP function <code>O10n\search_replace($search,$replace[,$regex])</code>. (<a href="javascript:void(0);" onclick="jQuery('#wp_html_search_replace_example').fadeToggle();">show example</a>)</p>

<div id="wp_html_search_replace_example" style="display:none;">
<pre style="padding:10px;border:solid 1px #efefef;">add_action('init', function () {

    /* String replace */
    O10n\search_replace('string', 'replace');

    /* Regular Expression */
    O10n\search_replace(array(
        '|regex (string)|i',
        '|regex2 (string)|i'
    ), array(
        '$1',
        'xyz'
    ), true);

}, 10);
</pre>
</div>
<hr />
<?php
    submit_button(__('Save'), 'primary large', 'is_submit', false);

// print form header
$this->form_end();
