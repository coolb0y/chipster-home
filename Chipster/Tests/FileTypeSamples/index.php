<!doctype html>
<html lang="en-US" >

<head>
<title>Chipster Personal Library</title>
<link rel="stylesheet" href="http://chipster/css/chipster.css">
<link rel="stylesheet" href="http://chipstersearch/css/styles.css">
</head>

<body>
<<?php

function convertToReadableSize($size)
{
    $base = log($size) / log(1024);
    $suffix = array('B', 'KB', 'MB', 'GB', 'TB');
    $f_base = floor($base);
    return round(pow(1024, $base - $f_base), 1) . " " . $suffix[$f_base];
}

function listFolderContent($path)
{
    $path = urldecode($path);
    
    $baseDirectory = $_SERVER['DOCUMENT_ROOT']; // Set the base directory
    $fullPath = $baseDirectory . $path;
    
    // Ensure the path is within the base directory
    if (realpath($fullPath) && strpos(realpath($fullPath), realpath($baseDirectory)) === 0) {
        $items = scandir($fullPath);

        // Exclude certain file types for security reasons:
        $excluded_extensions = array('php', 'phar', 'html', 'bat', 'htaccess', 'htpasswd', 'conf', 'ini', 'sql', 'bak'); // Add more if needed

        // Filter the items by excluding the specified file extensions and the '.' folder
        $filtered_items = array_filter($items, function ($item) use ($excluded_extensions) {
            $extension = pathinfo($item, PATHINFO_EXTENSION);
            return !in_array($extension, $excluded_extensions) && $item !== '.';
        });
        
        $directories = [];
        $files = [];

        foreach ($filtered_items as $item) {
            $itemPath = $fullPath . DIRECTORY_SEPARATOR . $item;
            $isDirectory = is_dir($itemPath);

            if ($isDirectory) {
                $directories[] = $item;
            } else {
                $files[] = $item;
            }
        }

        // Sort directories and files
        natcasesort($directories);
        natcasesort($files);

        echo "<ul>\n";

	$current_path = realpath($fullPath);
	$current_path = str_replace($baseDirectory, '', $current_path);
	
        // List directories first
        foreach ($directories as $item) {
            $escaped_item = htmlspecialchars($item);
            $itemPath = $fullPath . DIRECTORY_SEPARATOR . $item;

            echo '<li>';
            echo '<a href="javascript:void(0);" onclick="loadFolderContent(\'' . rawurlencode($path . DIRECTORY_SEPARATOR . $item)  . '/\', \'' . $escaped_item . '\')">';
            echo '📁 ' . $escaped_item . "</a></li>\n";
        }

        // List files
        foreach ($files as $item) {
            $escaped_item = htmlspecialchars($item);
            $itemPath = $fullPath . DIRECTORY_SEPARATOR . $item;

            $itemSize = convertToReadableSize(filesize($itemPath));
            $itemModifiedTime = date('d-m-Y', filemtime($itemPath));

            echo '<li>';
            echo '<a href="' . $current_path . DIRECTORY_SEPARATOR . rawurlencode($escaped_item) . '" target="_blank">' . $escaped_item . "</a> (Size: " . $itemSize . ", Last Modified: $itemModifiedTime)</li>\n";
        }
        

        echo "</ul>\n";
    } else {
        echo '<p>Access denied. You are not allowed to navigate outside the web directory.</p>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['path'])) {
    listFolderContent($_POST['path']);
    exit; // Terminate execution after handling the POST request
} else {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>Explorer</title>
    <script>
        function loadFolderContent(path, folderName) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("file-list").innerHTML = xhr.responseText;
                }
            };
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("path=" + path);
        }
    </script>
</head>
<body>
';

    echo "<h4>File Explorer</h4>\n";
    echo '<div id="file-list">' . PHP_EOL;
    listFolderContent(dirname($_SERVER['REQUEST_URI']));
    echo '</div>' . PHP_EOL;

    echo '</body>
</html>';
}
?>
</body>