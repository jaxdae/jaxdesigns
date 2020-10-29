<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */
use Roots\WPConfig\Config;

Config::define('SAVEQUERIES', false);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_LOG', true);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
