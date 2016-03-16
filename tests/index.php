<li><a href='suites/all.php'>[ALL]</a></li>
<?php

$ignore = array(".", "..", "base.php", "index.php");
if ($handle = opendir('./cases')) {
    while (false !== ($entry = readdir($handle))) {
        if (in_array($entry, $ignore)) continue;
        echo "<li><a href='cases/$entry'>$entry</a></li>";
    }
    closedir($handle);
}
