<!doctype html>
<html>
<head>
    <title>PHP Database CSV Import</title>
</head>
<body>
<h1>Samples</h1>
<ul>
<?php 
    if ($handle = opendir('.')) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        if (!(strpos($entry, '.') !== false)) { // Only Folders
            echo '<li>
                    <a href="'.$entry.'">'.$entry.'</a>
                  </li>';
        }
    }

    closedir($handle);
}
?>
</ul>
</body>
</html>
