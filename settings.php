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
    $settings->add(new admin_setting_configtext('babelroom_api_key', get_string('babelroomApikey', 'babelroom'), get_string('apikey', 'babelroom'), '65dc149155ab4e26d0b207eed9d3c710'));
    $settings->add(new admin_setting_configtext('babelroom_room_server', get_string('babelroomRoomserver', 'babelroom'), get_string('roomserver', 'babelroom'), 'https://bblr.co'));
    $settings->add(new admin_setting_configtext('babelroom_api_server', get_string('babelroomApiserver', 'babelroom'), get_string('apiserver', 'babelroom'), 'https://api.babelroom.com'));
}

?>
