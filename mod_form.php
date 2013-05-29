<?php

/**
 * The main babelroom configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    mod
 * @subpackage babelroom
 * @copyright  2012-2013 John Roy <john@babelrom.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 */
class mod_babelroom_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {

        $mform = $this->_form;

        //-------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('babelroomname', 'babelroom'), array('size'=>'64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
#global $CFG;
#$bblr = $CFG->BabelRoomAPIKey;
#$mform->addElement('static', 'label1', 'babelroomsetting1', $bblr);
#$mform->addElement('static', 'label1', 'babelroomsetting2', $bblr);
#$mform->addElement('static', 'label2', 'babelroomsetting3', $bblr);
#$mform->addElement('text', 'id', 'Funky', array('size'=>'64'));
#print var_dump($this->current);

        $mform->addElement('hidden', 'conference_id', 0);   /* we need this, otherwise conference_id wouldn't be read from DB */

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'babelroomname', 'babelroom');

        // Adding the standard "intro" and "introformat" fields
        $this->add_intro_editor();

/*
        //-------------------------------------------------------------------------------
        // Adding the rest of babelroom settings, spreeading all them into this fieldset
        // or adding more fieldsets ('header' elements) if needed for better logic
        $mform->addElement('static', 'label1', 'babelroomsetting1', 'Your babelroom fields go here. Replace me!');

        $mform->addElement('header', 'babelroomfieldset', get_string('babelroomfieldset', 'babelroom'));
        $mform->addElement('static', 'label2', 'babelroomsetting2', 'Your babelroom fields go here. Replace me!');
*/

        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
    }
}
