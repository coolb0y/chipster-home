
<?php

echo "<br><nbsp>Test for Laravel...<br>";
echo urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
echo "<nbsp><br><br>";

/** Absolute path to the WordPress directory. */

echo '<nbsp><br><br>';

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', "../chipster/chipsterengine/wordpress/");
}

echo "<br><nbsp>Modded ABSPATH  returns...<br>";
echo ABSPATH;
echo "<nbsp><br><br>";

?>