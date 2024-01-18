<head>
<title>Chipster Personal Library</title>
<link rel="stylesheet" href="http://chipster/css/chipster.css">
</head>

<body>
<h1>Chipster Tests Home Page</h1>

<?php

function convertToReadableSize($size){
  $base = log($size) / log(1024);
  $suffix = array('B', 'KB', 'MB', 'GB', 'TB');
  $f_base = floor($base);
  return round(pow(1024, $base - floor($base)), 1) . " " . $suffix[$f_base];
}

$current_directory = getcwd();

// Exclude certain file types for security reasons:
$excluded_extensions = array('php', 'phar', 'html', 'bat', 'htaccess', 'htpasswd', 'conf', 'ini', 'sql', 'bak'); // Add more if needed

$all_files = array_diff(scandir($current_directory), array('..', '.')); // List all files except the special directories .. and . (previous and current directory)

// Filter the files by excluding the specified file extensions
$filtered_files = array_filter($all_files, function ($file) use ($excluded_extensions) {
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    return !in_array($extension, $excluded_extensions);
});

echo '<!DOCTYPE html>
<html lang="en">
  <head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <title>File List</title>
  </head>
  <body>
 ';

if (empty($filtered_files)) {
 	echo '<h4>No files found!<h4>\n';
} else {
 	echo "<h4>Found " . count($filtered_files) . " files</h4>\n";
 	echo "<ul>\n";
 	
 	//$current_path = htmlspecialchars((empty($_SERVER['HTTPS']) ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . DIRECTORY_SEPARATOR);
    	$current_path = htmlspecialchars(dirname($_SERVER['REQUEST_URI'])) . '/';
    	
	foreach($filtered_files as $file)
	{
		$escaped_file = htmlspecialchars($file);
		
        	$filePath = $current_directory . DIRECTORY_SEPARATOR . $file;
        	
        	$fileSize = filesize($filePath);
        	$fileModifiedTime = date('d-m-Y', filemtime($filePath));
        
	 	echo '<li><a href="' . $current_path . rawurlencode($escaped_file) . '">' . $escaped_file . "</a> (Size: " . convertToReadableSize($fileSize) . ", Last Modified: $fileModifiedTime)</li>\n";
	}
	
	echo "</ul>\n";
 }
 
echo '  </body>
</html>';

?>