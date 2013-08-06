<?PHP
/* Copyright 2012, Bergware International.
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2, or (at your option)
 * any later version.
 * 
 * limetech - modified and documented:
 * 
 * This may be used to update the contents of a php ini-style configuration file.
 * NOTE: the file extension used is .cfg NOT .ini
 * 
 * (Note that generally these files are store on the USB flash device, but read access to these files
 * is fast because they are cached by the linux buffer cache.)
 * 
 * The querylist contains a list of name=value pairs to be updated in the file. There are a number of
 * special parameters prefixed with a hash '#' character:
 * #plugin - If present, then it names a plugin, eg, "#plugin=myplugin".  In this case the file processed will be
 * "/boot/config/plugins/myplugin/myplugin.ini".
 * If the "#plugin" parameter is omitted then we process the webGui configration file:
 * "/boot/config/webGui.ini".
 * #section - If present, then the ini file consists of a set of named sections, and all of the querystring
 * parameters apply to this one particular section.  If omitted, then it's just a flat ini file without
 * sections.
 * #include - specifies name of an include file to read in before saving the file contents
 * #cleanup - if present then parameters with empty strings are omitted from being written to the file
 */
?>
<?
parse_str($argv[1], $_GET);
$plugin = isset($_GET['#plugin']) ? $_GET['#plugin'] : "";
$section = isset($_GET['#section']) ? $_GET['#section'] : "";
$cleanup = isset($_GET['#cleanup']);

$ini = "/boot/config/plugins/{$plugin}/{$plugin}.cfg";

$keys = parse_ini_file($ini, $section);
$save = true;

if (isset($_GET['#include'])) include "/usr/local/emhttp/{$_GET['#include']}";
if ($save) {
  $ram = "# Generated settings:\n";
  if ($section) {
    foreach ($_GET as $key => $value) if (substr($key,0,1)!='#') $keys[$section][$key] = $value;
    foreach ($keys as $section => $block) {
      $ram .= "[$section]\n";
      foreach ($block as $key => $value) {
        if (strlen($value) || !$cleanup) {
          $ram .= "$key=\"$value\"\n";
        }
      }
    }
  } else {
    foreach ($_GET as $key => $value) if (substr($key,0,1)!='#') $keys[$key] = $value;
    foreach ($keys as $key => $value) {
      if (strlen($value) || !$cleanup) {
        $ram .= "$key=\"$value\"\n";
      }
    }
  }
  file_put_contents($ini, $ram);
}
?>
<html>
<head><script>var goback=parent.location;</script></head>
<body onLoad="parent.location=goback;"></body>
</html>
