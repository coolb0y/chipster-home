<?php
    print '<table border="0">';
    foreach ($_SERVER as $key=>$val )
       {
         echo '<tr><td>$_SERVER[' . "'" .$key . "']" ."</td><td>" .$val."</tr>";
        }
    print"</table>";
?>
