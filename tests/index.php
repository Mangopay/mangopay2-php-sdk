<li><a href='suites/All.php'>[ALL]</a></li>
<?php

$ignore = array(".", "..", "Base.php", "index.php");
if ($handle = opendir('./cases')) {
    while (false !== ($entry = readdir($handle))) {
        if (in_array($entry, $ignore)) continue;
        echo "<li><a href='cases/$entry'>$entry</a></li>";
    }
    closedir($handle);
}
