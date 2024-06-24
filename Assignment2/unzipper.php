<?php
/**
 * The Unzipper extracts .zip or .rar archives and .gz files on webservers.
 * It's handy if you do not have shell access. E.g. if you want to upload a lot
 * of files (php framework or image collection) as an archive to save time.
 * As of version 0.1.0 it also supports creating archives.
 *
 * @author  Group 9
 */

// Define the version of the Unzipper
define('VERSION', '0.1.1');

// Start the timer to measure processing time
$timestart = microtime(TRUE);
$GLOBALS['status'] = array();

// Create an instance of the Unzipper class
$unzipper = new Unzipper;
if (isset($_POST['dounzip'])) {
  // Check if an archive was selected for unzipping.
  $archive = isset($_POST['zipfile']) ? strip_tags($_POST['zipfile']) : '';
  $destination = isset($_POST['extpath']) ? strip_tags($_POST['extpath']) : '';
  $unzipper->prepareExtraction($archive, $destination);
}

if (isset($_POST['dozip'])) {
  // Zip functionality
  $zippath = !empty($_POST['zippath']) ? strip_tags($_POST['zippath']) : '.';
  // Resulting zipfile e.g. zipper--2016-07-23--11-55.zip.
  $zipfile = 'zipper-' . date("Y-m-d--H-i") . '.zip';
  Zipper::zipDir($zippath, $zipfile);
}

// Stop the timer
$timeend = microtime(TRUE);
$time = round($timeend - $timestart, 4);

/**
 * Class Unzipper
 */
class Unzipper {
  // Properties
  public $localdir = '.';
  public $zipfiles = array();

  // Constructor
  public function __construct() {
    // Read directory and pick .zip, .rar and .gz files.
    if ($dh = opendir($this->localdir)) {
      while (($file = readdir($dh)) !== FALSE) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'zip'
          || pathinfo($file, PATHINFO_EXTENSION) === 'gz'
          || pathinfo($file, PATHINFO_EXTENSION) === 'rar'
        ) {
          $this->zipfiles[] = $file;
        }
      }
      closedir($dh);

      if (!empty($this->zipfiles)) {
        $GLOBALS['status'] = array('info' => '.zip or .gz or .rar files found, ready for extraction');
      } else {
        $GLOBALS['status'] = array('info' => 'No .zip or .gz or rar files found. So only zipping functionality available.');
      }
    }
  }

  // Methods...
}

/**
 * Class Zipper
 */
class Zipper {
  // Methods...
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>File Unzipper + Zipper</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <style type="text/css">
    <!--
    // CSS styles...
    -->
  </style>
</head>
<body>
<p class="status status--<?php echo strtoupper(key($GLOBALS['status'])); ?>">
  Status: <?php echo reset($GLOBALS['status']); ?><br/>
  <span class="small">Processing Time: <?php echo $time; ?> seconds</span>
</p>
<form action="" method="POST">
  <!-- Archive Unzipper section -->
  <fieldset>
    <h1>Archive Unzipper</h1>
    <label for="zipfile">Select .zip or .rar archive or .gz file you want to extract:</label>
    <select name="zipfile" size="1" class="select">
      <?php foreach ($unzipper->zipfiles as $zip) {
        echo "<option>$zip</option>";
      }
      ?>
    </select>
    <label for="extpath">Extraction path (optional):</label>
    <input type="text" name="extpath" class="form-field" />
    <p class="info">Enter extraction path without leading or trailing slashes (e.g. "mypath"). If left empty current directory will be used.</p>
    <input type="submit" name="dounzip" class="submit" value="Unzip Archive"/>
  </fieldset>

  <!-- Archive Zipper section -->
  <fieldset>
    <h1>Archive Zipper</h1>
    <label for="zippath">Path that should be zipped (optional):</label>
    <input type="text" name="zippath" class="form-field" />
    <p class="info">Enter path to be zipped without leading or trailing slashes (
