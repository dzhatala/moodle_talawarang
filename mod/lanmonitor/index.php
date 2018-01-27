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
 * This is a one-line short description of the file
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_lanmonitor
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace lanmonitor with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = required_param('id', PARAM_INT); // Course.

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_login();
require_course_login($course);

$params = array(
    'context' => context_course::instance($course->id)
);
$event = \mod_lanmonitor\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

$strname = get_string('modulenameplural', 'mod_lanmonitor');
$PAGE->set_url('/mod/lanmonitor/index.php', array('id' => $id));
$PAGE->navbar->add($strname);
$PAGE->set_title("$course->shortname: $strname");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('incourse');

echo $OUTPUT->header();
echo $OUTPUT->heading($strname);

/*if (! $lanmonitors = get_all_instances_in_course('lanmonitor', $course)) {
    notice(get_string('nolanmonitors', 'lanmonitor'), new moodle_url('/course/view.php', array('id' => $course->id)));
}

$usesections = course_format_uses_sections($course->format);

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_'.$course->format);
    $table->head  = array ($strsectionname, $strname);
    $table->align = array ('center', 'left');
} else {
    $table->head  = array ($strname);
    $table->align = array ('left');
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($modinfo->instances['lanmonitor'] as $cm) {
    $row = array();
    if ($usesections) {
        if ($cm->sectionnum !== $currentsection) {
            if ($cm->sectionnum) {
                $row[] = get_section_name($course, $cm->sectionnum);
            }
            if ($currentsection !== '') {
                $table->data[] = 'hr';
            }
            $currentsection = $cm->sectionnum;
        }
    }

    $class = $cm->visible ? null : array('class' => 'dimmed');

    $row[] = html_writer::link(new moodle_url('view.php', array('id' => $cm->id)),
                $cm->get_formatted_name(), $class);
    $table->data[] = $row;
}

echo html_writer::table($table);*/
//exec('ls -la', $outputArray);
//exec('nmap --help', $outputArray);
$lm_debug=1;
$cmd="arp -an";
$cmd.=" ";
$outputArray=array();
exec($cmd, $outputArray);
//print_r($outputArray);
if($lm_debug)
    foreach ($outputArray as $key => $value) {
        echo $value."<BR>\n";
    }
echo "<br>";

//$cmd="nmap -T5 -sT -p22 --host-timeout 1 --max-retries 1 localhost 192.168.43.102 192.168.43.1  ";
$cmd="nmap -T5 -sT -p22 --host-timeout 1 --max-retries 1 localhost ";

$outputArray=array();
exec($cmd, $outputArray);
//print_r($outputArray);
if($lm_debug)
    foreach ($outputArray as $key => $value) {
        echo $value."<BR>\n";
    }

$data=array();
//echo $OUTPUT->render_from_template('mod_lanmonitor/recipe', $data);
echo $OUTPUT->render_from_template('mod_lanmonitor/lab_r', $data);

echo $OUTPUT->footer();
