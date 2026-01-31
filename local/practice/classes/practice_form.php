<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * practice page form
 *
 * @package    local_practice
 * @copyright  2022 onwards WIDE Services  {@link https://www.wideservices.gr}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
//require_once(__DIR__ . '/../lib.php');
require_once("$CFG->libdir/formslib.php");

class practice_form extends moodleform
{
    public function definition()
    {
        $mform = $this->_form;

        $mform->addElement('text', 'firstname', 'First name');
        $mform->setType('firstname', PARAM_TEXT);
        $mform->addRule('firstname', 'First name is required', 'required', null, 'client');

        $mform->addElement('text', 'lastname', 'Last name');
        $mform->setType('lastname', PARAM_TEXT);
        $mform->addRule('lastname', 'Last name is required', 'required', null, 'client');

        $mform->addElement('text', 'email', 'Email');
        $mform->setType('email', PARAM_EMAIL);
        $mform->addRule('email', 'Email is required', 'required', null, 'client');
        $mform->addRule('email', 'Invalid email format', 'email', null, 'client');

        $this->add_action_buttons(false, 'Add record');
    }

    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);

        // Check minimum length for firstname
        if (strlen($data['firstname']) < 2) {
            $errors['firstname'] = 'First name must be at least 2 characters';
        }

        // Check minimum length for lastname
        if (strlen($data['lastname']) < 2) {
            $errors['lastname'] = 'Last name must be at least 2 characters';
        }

        // Check for duplicate emailσ
        global $DB;
        if ($DB->record_exists('local_practice', ['email' => $data['email']])) {
            $errors['email'] = 'This email is already registered';
        }

        return $errors;
    }
}
