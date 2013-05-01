<?php

/**
 * Settings
 *
 * @package    mod
 * @subpackage babelroom
 * @copyright  2012-2013 John Roy <john@babelrom.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('BabelroomAPIKey', get_string('babelroomApikey', 'babelroom'), get_string('apikey', 'babelroom'), '4b566a874d24b410f15b9ea83b0cc9c7'));
}

?>
