<?php

/**
 * Defines the version of babelroom
 *
 * This code fragment is called by moodle_needs_upgrading() and
 * /admin/index.php
 *
 * @package    mod
 * @subpackage babelroom
 * @copyright  2012-2013 John Roy <john@babelrom.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$module->version   = 2013050100;      // The current module version (Date: YYYYMMDDXX)
$module->requires  = 2010112400;      // Requires this Moodle version
$module->cron      = 0;               // Period for cron to check this module (secs)
$module->component = 'mod_babelroom'; // To check on upgrade, that module sits in correct place
$module->maturity = MATURITY_BETA;  // [MATURITY_STABLE | MATURITY_RC | MATURITY_BETA | MATURITY_ALPHA]
$module->release  = '0.9.0b';

