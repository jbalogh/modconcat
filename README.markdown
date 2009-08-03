## What it is

PHP helper functions for using [mod_concat][].

## How to use it

By default, the `stylesheets` and `scripts` functions return the normal
`<link>` and `<script>` tags for each filepath.

    >>> stylesheets(array('one.css', 'two.css'), array('media' => 'screen'))
    '<link rel="stylesheet" type="text/css" href="one.css" media="screen"/>
     <link rel="stylesheet" type="text/css" href="two.css" media="screen"/>'

    >>> scripts(array('one.js', 'foo/two.js'))
    '<script type="text/javascript" src="one.js"></script>
     <script type="text/javascript" src="foo/two.js"></script>'

If `'MOD_CONCAT'` is `True`, the file URLs will be joined with a comma and
linked in a single tag.

    >>> stylesheets(array('one.css', 'two.css'), array('media' => 'screen'))
    '<link rel="stylesheet" type="text/css" href="one.css,two.css" media="screen"/>'

    >>> scripts(array('one.js', 'foo/two.js'))
    '<script type="text/javascript" src="one.js,foo/two.js"></script>'

[mod_concat]: http://code.google.com/p/modconcat/
