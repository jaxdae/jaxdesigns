<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */
use Roots\WPConfig\Config;

Config::define('SAVEQUERIES', false);
Config::define('WP_DEBUG', false);

ini_set('display_errors', 0);
