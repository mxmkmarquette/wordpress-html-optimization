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
            <label><input type="checkbox" name="o10n[html.minify.enabled]" value="1"<?php $checked('html.minify.enabled'); ?> /> Enabled</label>
            <p class="description">Compress HTML using an enhanced version of <a href="https://github.com/o10n-x/wordpress-html-optimization/blob/master/lib/HTML.php" target="_blank">HTML.php</a>.</p>
        </td>
    </tr>
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
