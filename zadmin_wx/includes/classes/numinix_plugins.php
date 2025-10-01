<?php
/**
 * Plugin loader that dynamically includes the IonCube-encoded class file
 * based on the current PHP version or defaults to the clear version.
 */

$basePath = __DIR__;
$clearFile = $basePath . '/numinix_plugins_clear.php';

// Step 1: Always prefer clear version if present
if (file_exists($clearFile)) {
    require_once($clearFile);
    return;
}

// Step 2: Determine PHP version in X_Y format
$currentPhpVersion = PHP_MAJOR_VERSION . '_' . PHP_MINOR_VERSION;
$currentPhpFloat   = (float)(PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION);

// Step 3: Scan for all versioned plugin files
$versionedFiles = glob($basePath . '/numinix_plugins_*.php');

$availableVersions = [];

foreach ($versionedFiles as $filePath) {
    if (preg_match('/numinix_plugins_(\d+)_(\d+)\.php$/', basename($filePath), $matches)) {
        $versionKey = $matches[1] . '_' . $matches[2];
        $versionFloat = (float)($matches[1] . '.' . $matches[2]);
        if ($versionFloat <= $currentPhpFloat) {
            $availableVersions[$versionKey] = $filePath;
        }
    }
}

// Step 4: Load the highest compatible version at or below the current PHP version
if (!empty($availableVersions)) {
    uksort($availableVersions, function ($a, $b) {
        return version_compare($b, $a);
    }); // Sort descending
    require_once(reset($availableVersions));
    return;
}

// No valid loader found
die("Error: No compatible encoded plugin class file found for PHP {$currentPhpVersion}.");
