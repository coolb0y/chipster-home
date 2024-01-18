
<?php

echo "<P> <P>";
echo "<br> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>";

echo "<br><nbsp>DIR returns...<br>";
echo __DIR__ ;
echo "<nbsp><br><br>";


echo "<P> <P>";
echo "<br> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>";

echo "<br><nbsp>DIR returns...<br>";
echo __DIR__;
echo "<br><nbsp>FILE returns...<br>";
echo __FILE__ ;
echo "<br><nbsp>PATHINFO_DIRNAME returns...<br>";
echo PATHINFO_DIRNAME;


if ( !defined('ABSPATH') )
define('ABSPATH', '<your absolute path to wordpress>' . '/');

define( __DIR__, 'ThisIsSuchATest/' );
echo "<br><nbsp>Modded __DIR__ returns...<br>";
echo __DIR__  ;
echo "<nbsp><br> <br>";

echo "<br> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>";

define( __DIR__, "ThisIsSuchATest/" );
echo "<br><nbsp>Modded __DIR__ returns...<br>";
echo __DIR__  ;
echo "<nbsp><br> <br>";

echo "<br> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>";

echo "<br><nbsp>Setting ABSPATH...<br>";

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . 'thisisatest/' );
}

echo "<nbsp><br><br>";
echo "<br><nbsp>ABSPATH returns...<br>";
echo ABSPATH;

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', 'TotallyBogusABSPATH' . '/' );
}

echo "<br><nbsp>Modded ABSPATH  returns...<br>";
echo ABSPATH ;
echo "<nbsp><br><br>";


/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

echo "<br> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>";

?>

<?php
echo (defined('__DIR__') ? '__DIR__ is defined' : '__DIR__ is NOT defined' . PHP_EOL);
echo (defined('__FILE__') ? '__FILE__ is defined' : '__FILE__ is NOT defined' . PHP_EOL);
echo (defined('PHP_VERSION') ? 'PHP_VERSION is defined' : 'PHP_VERSION is NOT defined') . PHP_EOL;
echo 'PHP Version: ' . PHP_VERSION . PHP_EOL;
?> 