<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'event';
$route['404_override'] = '';

// French routes
$route["apropos"] = "about";
$route["evenements"] = "event";
$route["evenements/calendrier"] = "event/calendar";
$route["evenements/calendrier/(:num)/(:num)"] = "event/calendar/$1/$2";
$route["evenements/consulter/(:num)"] = "event/view/$1";
$route["evenements/recherche"] = "event/search/";
$route["salle/evenements/(:num)"] = "venue/events/$1";
$route["salle/evenements/(:num)/(:num)"] = "venue/events/$1/$2";