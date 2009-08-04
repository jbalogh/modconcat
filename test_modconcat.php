<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');

require('modconcat.php');


class SoMuchFail extends UnitTestCase {

    function test_no_concat() {
        $this->assertFalse(defined('MOD_CONCAT'));

        /* Nothing extra. */
        $this->assertEqual(
          stylesheets(array('one.css')),
          '<link rel="stylesheet" type="text/css" href="one.css" />');

        /* Extras. */
        $this->assertEqual(
          stylesheets(array('one.css'), array('media' => 'screen')),
          '<link rel="stylesheet" type="text/css" href="one.css" media="screen"/>');

        $this->assertEqual(
          stylesheets(array('one.css', 'foo/two.css'), array('media' => 'screen')),
          '<link rel="stylesheet" type="text/css" href="one.css" media="screen"/>'
          ."\n".
          '<link rel="stylesheet" type="text/css" href="foo/two.css" media="screen"/>');

        $this->assertEqual(
          scripts(array('one.js', 'two.js')),
          '<script type="text/javascript" src="one.js" ></script>'
          ."\n".
          '<script type="text/javascript" src="two.js" ></script>');
    }

    function test_concat() {
        define('MOD_CONCAT', True);

        /* Nothing extra. */
        $this->assertEqual(
          stylesheets(array('one.css')),
          '<link rel="stylesheet" type="text/css" href="one.css" />');

        /* Extras. */
        $this->assertEqual(
          stylesheets(array('one.css'), array('media' => 'screen')),
          '<link rel="stylesheet" type="text/css" href="one.css" media="screen"/>');

        $this->assertEqual(
          stylesheets(array('one.css', 'foo/two.css'), array('media' => 'screen')),
          '<link rel="stylesheet" type="text/css" href="??one.css,foo/two.css" media="screen"/>');

        $this->assertEqual(
          scripts(array('one.js', 'two.js')),
          '<script type="text/javascript" src="??one.js,two.js" ></script>');
    }
}

$test =& new SoMuchFail();
$test->run(new TextReporter());
