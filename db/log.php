<?php

/**
 * Definition of log events
 *
 * NOTE: this is an example how to insert log event during installation/update.
 * It is not really essential to know about it, but these logs were created as example
 * in the previous 1.9 NEWMODULE.
 *
 * @package    mod
 * @subpackage babelroom
 * @copyright  2012-2013 John Roy <john@babelrom.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $DB;

$logs = array(
    array('module'=>'babelroom', 'action'=>'add', 'mtable'=>'babelroom', 'field'=>'name'),
    array('module'=>'babelroom', 'action'=>'update', 'mtable'=>'babelroom', 'field'=>'name'),
    array('module'=>'babelroom', 'action'=>'view', 'mtable'=>'babelroom', 'field'=>'name'),
    array('module'=>'babelroom', 'action'=>'view all', 'mtable'=>'babelroom', 'field'=>'name')
);
