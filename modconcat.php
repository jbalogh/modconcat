<?php

/**
 * Takes a list of CSS files and an assoc array of extra attributes and turns it
 * into a string of <link> tags, taking advantage of mod_concat if possible.
 *
 * >>> stylesheets(array('one.css', 'two.css'), array('media' => 'screen'))
 * '<link rel="stylesheet" type="text/css" href="one.css" media="screen"/>
 *  <link rel="stylesheet" type="text/css" href="two.css" media="screen"/>'
 *
 * @param array files CSS resources
 * @param array attributes extra properties, like media, added to each tag
 * @return string <link> tags to the CSS files
 */
function stylesheets($files, $attributes=array()) {
    $template = '<link rel="stylesheet" type="text/css" href="%s" %s/>';
    return _concat($template, $files, $attributes);
}

/**
 * Takes a list of Javascript files and an assoc array of extra attributes and
 * turns it into a string of <script> tags, taking advantage of mod_concat if
 * possible.
 *
 * >>> scripts(array('one.js', 'foo/two.js'))
 * '<script type="text/javascript" src="one.js"></script>
 *  <script type="text/javascript" src="foo/two.js"></script>'
 *
 * @param array files Javascript resources
 * @param array attributes extra properties added to each tag
 * @return string <script> tags for the Javascript files
 */
function scripts($files, $attributes=array()) {
    $template = '<script type="text/javascript" src="%s" %s></script>';
    return _concat($template, $files, $attributes);
}

/**
 * Output a list of files and any extra attributes according to $template,
 * taking advantage of mod_concat if CONCAT is True.
 */
function _concat($template, $files, $attributes=array()) {
    if (defined('MOD_CONCAT') && MOD_CONCAT === True && count($files) > 1) {
        $files = array('??' . join(',', $files));
    }

    $extra = _attrs($attributes);

    $out = array();
    foreach ($files as $file) {
        $out[] = sprintf($template, $file, $extra);
    }

    return join("\n", $out);
}

/**
 * Turn an assoc array into a string of 'key="value"' pairs.
 */
function _attrs($attributes) {
    $a = array();
    foreach ($attributes as $key => $value) {
        $a[] = sprintf('%s="%s"', $key, $value);
    }
    return join(' ', $a);
}
