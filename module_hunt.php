#!/usr/bin/php -q

<?php

$step_number = 0;
$version_input_validation = ['d7', 'd8'];
$versions_to_search = [];
$site_list = [];
$filtered_sites= [];
$results = [];
$drupal_version = null;
$red = '\033[0;31m';
$no_color = '\033[0m';

// Read in and validate command line arguements
if (isset($argv[1])) {
  $module = $argv[1];
  $response = "Searching for installed instances of the $module module.";

  if (isset($argv[2])) {
    $drupal_version = $argv[2];
    $response .= " ($drupal_version only.)";
    $versions_to_search = [$drupal_version];
    if (!in_array($drupal_version, $version_input_validation)) {
      echo "Error, $drupal_version not a valid option. Use \"d7,\" \"d8\" or leave blank to search both. \n";
      exit;
    }
  } else {
    $versions_to_search = $version_input_validation;
  }
} else {
  echo "Syntax error: check_modules.php module_name [d8|d7]\n";
  exit;
}

echo $response . "\n";

function display_step ($step_description) {
    global $step_number;
    $step_number += 1;
    echo $step_number . ') ' . $step_description;
    echo "\n";
  }

display_step('Getting list of pantheon sites.');
$site_list = json_decode(shell_exec('terminus site:list --format=json --fields="name,framework,plan_name,frozen"'));

display_step('Filtering to relevant set of sites');

// Convert the version arguments to what Terminus uses.
foreach ($versions_to_search as $key=>$value) {
  if ($value == 'd7') {$versions_to_search[$key] = 'drupal';}
  if ($value == 'd8') {$versions_to_search[$key] = 'drupal8';}
}

foreach($site_list as $site) {
  if (in_array($site->framework, $versions_to_search) && !$site->frozen) {
    $filtered_sites[] = $site;
  }
}

if (empty($filtered_sites)) {
  echo 'Sorry, no sites matching your Drupal version parameters found\n';
  exit;
} else {
  echo "Found " . count($filtered_sites) . " sites.\n";
}


foreach($filtered_sites as $site) {
  $env = 'live';
  echo "Checking $site->name:\n";
  if ($site->plan_name == "Sandbox") {
    $env = 'dev';
  }
  $active_modules = eval("return " . shell_exec("terminus drush $site->name.$env -- pml --status=enabled --format=var_export") . ';');

  if (is_array($active_modules)) {

    if (isset($active_modules[$module])) {
    echo "$module FOUND.\n";
    $results[] = $site->name;
    } else {
      echo "not found. \n";
    }
  } else {
    echo "Error getting module data:\n";
  }
}

if (!empty($results)) {
  echo "\n\n\nSUMMARY: $module appears on the following sites:\n";
  echo implode($results, ',') . "\n";
}
