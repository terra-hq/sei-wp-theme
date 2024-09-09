<?php

/**
 * Registers AJAX actions to retrieve job listings from Greenhouse API.
 * 
 * This code snippet adds two AJAX actions for retrieving jobs: one for logged-in users and one for visitors.
 * Both actions call the `get_greenhouse_jobs` function to fetch and filter job data from the Greenhouse API.
 */

add_action('wp_ajax_nopriv_get_greenhouse_jobs', 'get_greenhouse_jobs');
add_action('wp_ajax_get_greenhouse_jobs', 'get_greenhouse_jobs');

function get_greenhouse_jobs() {
  try {
    $result = [];
    $privateJob = 'SEI Military Transition fellowship - Business and Technology Consultant';
   
    if($_GET['location']){
      $locationID = $_GET['location'];
    }
    if($_GET['department']){
      $departmentID = $_GET['department'];
    }
    if($_GET['location'] || $_GET['department'] ){
      $job_response = job_calls_filtered($locationID, $departmentID);
      $result['jobs']= $job_response;
    }else{
      $job_response = job_calls_not_repeated();
      $result['jobs'] = $job_response;
    }

    $loc_response = location_calls_with_job()[0];
    $result['locs'] = $loc_response;

    $locname_response = location_calls_with_job()[1];
    $result['locsNames'] = $locname_response;

    $dep_response = dep_calls_with_job()[0];
    $result['deps'] = $dep_response;

    $dep_response = dep_calls_with_job()[1];
    $result['depsName'] = $dep_response;

    $dep_response = single_loc_calls_with_job($locationID);
    $result['single_loc'] = $dep_response;
    
    echo json_encode($result);
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }
  die();
}

function job_calls_filtered( $locationName = null,  $departmentID = null){
  $job_response = job_calls();
  $aJobs = json_decode($job_response, true);
  $privateJob = 'SEI Military Transition fellowship - Business and Technology Consultant';
  if($aJobs){
    $jobsFilters = [];
    $jobsFiltersList = [];
    foreach ($aJobs['jobs'] as $job) {
      if($job['title'] !== $privateJob){
        if(!in_array($job['location']['name'].$job['title'],$jobsFiltersList)){
          if($_GET['location'] && $_GET['department']){
            if ($job['location']['name'] == $locationName && $departmentID == $job['title']) {
              array_push($jobsFilters, $job);
              array_push($jobsFiltersList, $job['location']['name'].$job['title']);
            }
          }else{
            if ($_GET['location'] && $job['location']['name'] == $locationName) {
              array_push($jobsFilters, $job);
              array_push($jobsFiltersList, $job['location']['name'].$job['title']);
            }else if( $_GET['department'] && $departmentID == $job['title']) {
              array_push($jobsFilters, $job);
              array_push($jobsFiltersList, $job['location']['name'].$job['title']);
            }
          }
        }
      }
    }
    return $jobsFilters;
  }
}

function job_calls() {
  try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //remove on upload
    curl_setopt($ch, CURLOPT_URL, 'https://boards-api.greenhouse.io/v1/boards/seisandbox/jobs/?content=true');
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_REFERER, "https://www.notmydomain.com");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
   
    return $result;
  } catch (Exception $exc) {
    return false;
  }
}


function job_calls_not_repeated() {
  try {
    $allJobs = json_decode(job_calls(), true);
    $jobList = [];
    $privateJob = 'SEI Military Transition fellowship - Business and Technology Consultant';
    $jobsFiltersList = [];
    foreach ($allJobs['jobs'] as $singleJob) {
      if($singleJob['title'] !== $privateJob){
        if(!in_array($singleJob['location']['name'].$singleJob['title'],$jobsFiltersList)){
          array_push($jobList, $singleJob);
          array_push($jobsFiltersList, $singleJob['location']['name'].$singleJob['title']);
        }
      }
    }
    // sort($jobList);
    return $jobList;
  } catch (Exception $exc) {
    return false;
  }
}


function job_calls_byId($ghID) {
  if ($ghID) {
    $job_response = job_calls();
    $aJobs = json_decode($job_response, true);

    foreach ($aJobs['jobs'] as $job) {
      if ($job['id'] == $ghID) {
        return $job;
      }
    }
  }
  return false;
}


function location_calls() {
  try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //remove on upload
    curl_setopt($ch, CURLOPT_URL, 'https://boards-api.greenhouse.io/v1/boards/seisandbox/offices');
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_REFERER, "https://www.notmydomain.com");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  } catch (Exception $exc) {
    return false;
  }
  return false;
}

function location_calls_with_job(){
  $locations = location_calls();
  $allLocs = json_decode($locations, true);
  if($allLocs){
    $listLocations = [];
    $listLocationsNames = [];
    foreach ($allLocs['offices'] as $key => $location) {
      if($location['departments'][0]['jobs']){
        if($location['name'] !== 'No Office'){
          $location['locName'] = str_replace("SEI - ","",$location['name']);
          array_push($listLocations, $location);
          array_push($listLocationsNames, $location['locName']);
        }
      }
    }
  }


  return [$listLocations,$listLocationsNames];
}


function dep_calls() {
  try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //remove on upload
    curl_setopt($ch, CURLOPT_URL, 'https://boards-api.greenhouse.io/v1/boards/seisandbox/departments');
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_REFERER, "https://www.notmydomain.com");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  } catch (Exception $exc) {
    return false;
  }
  return false;
}


function dep_calls_with_job(){
  $departments = dep_calls();
  $allDeps = json_decode($departments, true);
  $privateJob = 'SEI Military Transition fellowship - Business and Technology Consultant';
  if($allDeps){
    $listDepartments = [];
    $listDepartmentsID = [];

    foreach ($allDeps['departments'][0]['jobs'] as $key => $department) {
      if($department['title'] != $privateJob ){
        if(!in_array($department['title'],$listDepartmentsID)){
          $department['depName'] = str_replace("Consultant","",$department['title']);
          array_push($listDepartments, $department);
          array_push($listDepartmentsID, $department['title']);
        }
      }
    }
  }
  return [$listDepartments, $listDepartmentsID];
}

function single_loc_calls_with_job($locationID = null){
  $locations = location_calls();
  $allLocs = json_decode($locations, true);
  $privateJob = 'SEI Military Transition fellowship - Business and Technology Consultant';
  $publicJobs = [];
  foreach ($allLocs['offices'] as $key => $singleLoc) {
    if($locationID == $singleLoc['id']){
      foreach ($singleLoc['departments'][0]['jobs'] as  $publicJob) {
        if($publicJob['title'] !== $privateJob){
          array_push($publicJobs,$publicJob );
        }
      }
      return $publicJobs;
    }
  }
  return [];
}
