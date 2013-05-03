<?php

/**
 * Library of API calls and utilities
 *
 * @package    mod
 * @subpackage babelroom
 * @copyright  2012-2013 John Roy <john@babelrom.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

define('API_HOST', 'https://api.babelroom.com/v1');
define('PAGE_HOST', 'https://bblr.co');

////////////////////////////////////////////////////////////////////////////////
// Babelroom API calls                                                        //
////////////////////////////////////////////////////////////////////////////////

/* returns bool(y) */
function _do_api_call($verb, $url, $data, &$result) { 
    global $CFG;
    $rc = false;

    if (!extension_loaded('curl'))
      return false;

    if (
        !(stripos(ini_get('disable_functions'), 'curl_init') !== FALSE) and
        ($ch = @curl_init($url)) !== false) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
#        curl_setopt($ch, CURLOPT_HEADER, false); -- for later reference
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $CFG->BabelroomAPIKey.':');
        if ($data) {
            $data_string = json_encode($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
            }
        $tmp_result = curl_exec($ch);
        if (!curl_errno($ch)) {
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($code>=200 and $code<=299) {
                $result = json_decode($tmp_result);
                $rc = true;
                }
            else
                print_error($code); // this logs the http error code .. useful
            }
        else {
            print_error('api_connect_error','babelroom');
            }
        curl_close($ch);
        }

    return $rc;
}

/* status check */
function api_status()
{
    $result;
    return _do_api_call('GET', API_HOST.'/status', null, $result);
}

/* --- */
function api_create_conference(&$babelroom)
{
    $params = array(
        'name' => $babelroom->name,
        'introduction' => $babelroom->intro,
        'origin_data' => 'Moodle',
#        'origin_id' => $babelroom->id -- we don't have the id yet because the record hasn't been created
        );
    $result = null;
    if (!_do_api_call('POST', API_HOST.'/conferences', $params, $result) || empty($result->data) || empty($result->data->id))
        return false;
    $babelroom->conference_id = $result->data->id;
    $babelroom->url = PAGE_HOST.'/i/'.$result->data->id;
    return true;
}

/* --- */
function api_update_conference($babelroom)
{
    $params = array('name' => $babelroom->name, 'introduction' => $babelroom->intro);
    $result = null;
    return _do_api_call('PUT', API_HOST.'/conferences/'.$babelroom->conference_id, $params, $result);
}

/* --- */
function api_delete_conference($babelroom)
{
    $result = null;
    return _do_api_call('DELETE', API_HOST.'/conferences/'.$babelroom->conference_id, array(), $result);
}

/* --- */
function _util_canon_phone($in)
{
    $out = preg_replace('/\D/','',$in);
    if (strncmp('+',$out,1))
        $out = '+1'.$out;
    return $out;
}
function api_create_invitation($babelroom, $user, $avatar_url, $context, &$result)
{
    $params = array(
        'return_token' => true,
        'name' => $user->firstname,
        'user' => array(
            'name' => $user->firstname,
            'last_name' => $user->lastname,
            'email' => $user->email,
            'origin_data' => 'Moodle',
            'origin_id' => $user->id,
/* other fields of interest ...
    $user->phone2,
    $user->timezone,
    $user->url,
*/
            'phone' => _util_canon_phone($user->phone1),
            ),
        'avatar_url' => $avatar_url,
        'invitation' => array(
            'role' => (has_capability('moodle/category:manage', $context) ? 'Host': null),
            ),
        );
    return _do_api_call('POST', API_HOST.'/add_participant/i/'.$babelroom->conference_id, $params, $result);
}

