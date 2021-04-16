<li><a href='Suites/All.php'>[ALL]</a></li>
<?php

$ignore = [".", "..", "Base.php", "index.php"];
if ($handle = opendir(__DIR__.'/Cases')) {
    while (false !== ($entry = readdir($handle))) {
        if (in_array($entry, $ignore)) {
            continue;
        }
        echo "<li><a href='Cases/$entry'>$entry</a></li>";
    }
    closedir($handle);
}
