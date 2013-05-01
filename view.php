<?php

/**
 * Prints a particular instance of babelroom
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod
 * @subpackage babelroom
 * @copyright  2012-2013 John Roy <john@babelrom.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/api.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // babelroom instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('babelroom', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $babelroom  = $DB->get_record('babelroom', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $babelroom  = $DB->get_record('babelroom', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $babelroom->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('babelroom', $babelroom->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

add_to_log($course->id, 'babelroom', 'view', "view.php?id={$cm->id}", $babelroom->name, $cm->id);

/* avatar */
$pic = new user_picture($USER);
$pic->size = 160;
$murl = $pic->get_url($PAGE);
$pic_url = $murl->out(false /* don't escape */);
$result = null;
if (api_create_invitation($babelroom, $USER, $pic_url, $context, $result)) {
    if (!isset($result) || !isset($result->token)) {
        print_error('bad_invitation_response','babelroom');
        }
    else {
        $url = $babelroom->url . '?t=' . $result->token;
        redirect($url);
        }
}   /* api will already have dropped error */

/// Print the page header

$PAGE->set_url('/mod/babelroom/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($babelroom->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('babelroom-'.$somevar);

// Output starts here
echo $OUTPUT->header();

if ($babelroom->intro) { // Conditions to show the intro can change to look for own settings or whatever
    echo $OUTPUT->box(format_module_intro('babelroom', $babelroom, $cm->id), 'generalbox mod_introbox', 'babelroomintro');
}

// Replace the following lines with you own code
echo $OUTPUT->heading('');

/*
echo '<pre><code>';

echo "USER\n";
var_dump($USER);

echo "course\n";
var_dump($course);

echo "\n\ncontext\n";
var_dump($context);

echo "--- timezone\n";
var_dump($USER->timezone);
$tz = get_user_timezone($USER->timezone);
var_dump($tz);
$tz = usertimezone($USER->timezone);
var_dump($tz);
echo "--- timezone\n";

echo "\n\ncm\n";
var_dump($cm);

echo "\n\nbabelroom\n";
var_dump($babelroom);

echo "\n\nadministrator";
$administrator = has_capability('moodle/category:manage', $context);
var_dump($administrator);

echo "\npicture---\n";
//require_once($CFG->libdir.'/filelib.php');
echo "\n111---\n";
$pic = new user_picture($USER);
$pic->size = 160;
$murl = $pic->get_url($PAGE);
var_dump($murl);
$out = $murl->out(false);
var_dump($out);
echo "\n111---\n";
echo "\n222---\n";
$src->popup = true;
$OUTPUT->render($src);
echo "\n222---\n";
$url = new moodle_url('/user/profile.php', array('id' => $USER->id));
var_dump($url);
echo "\n$url\n";
echo "\npicture---\n";

echo '</code></pre>';
*/

// Finish the page
echo $OUTPUT->footer();

