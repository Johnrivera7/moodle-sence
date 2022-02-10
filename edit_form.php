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

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

/**
 * Edit form
 * http://docs.moodle.org/dev/
 *
 * @package    block_sence
 * @copyright  John Rivera Gonzalez <johnriveragonzalez7@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_sence_edit_form extends block_edit_form
{
    /**
     * Defines edit form
     *
     * @param MoodleQuickForm $mform
     *
     * @throws coding_exception
     */
    protected function specific_definition($mform)
    {   global $CFG, $SITE, $OUTPUT, $COURSE;
     
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        
        $allgroups = groups_get_all_groups($COURSE->id, $userid=0, $groupingid=0, $fields='id, name');
        $groupname = array();                                                                                                       
        foreach ($allgroups as $id => $group) {                                                                          
            $groupname[$id] = $group->name;                                                                  
        }  
        $options = array(                                                                                                           
            'multiple' => true,                                                  
            'noselectionstring' => 'Grupos',                                                                
        );         
        $mform->addElement('autocomplete', 'config_grupo_sence', 'Grupos Sence', $groupname, $options);
     
        $mform->addElement('text', 'config_RutOtec', 'Rut Otec');
        $mform->setType('config_RutOtec', PARAM_TEXT);
     
        $mform->addElement('text', 'config_url_inicio_sesion', 'Url de inicio de sesion sence');
        $mform->setType('config_url_inicio_sesion', PARAM_URL);
     	
     	$mform->addElement('text', 'config_url_fin_sesion', 'Url de cierre de sesion sence');
        $mform->setType('config_url_fin_sesion', PARAM_URL);
        
        $mform->addElement('select', 'config_urltarget', get_string('sence_urltarget', 'block_sence'), [
            '_self' => get_string('urltarget_self', 'block_sence'),
            '_blank' => get_string('urltarget_blank', 'block_sence')
        ]);
        $mform->addElement('text', 'config_Token', 'Token');
        $mform->setType('config_Token', PARAM_TEXT);
        $mform->addElement('text', 'config_CodSence', 'CodSence');
        $mform->setType('config_CodSence', PARAM_TEXT);
        //$mform->addElement('text', 'config_CodigoCurso', 'Codigo Curso');
        //$mform->setType('config_CodigoCurso', PARAM_TEXT);
        $mform->addElement('text', 'config_LineaCapacitacion', 'Linea Capacitacion');
        $mform->setType('config_LineaCapacitacion', PARAM_INT);
                
        $mform->addElement('text', 'config_timesence', 'Cantidad de horas de conexion al curso');
        $mform->setType('config_timesence', PARAM_INT);
        $mform->addElement('text', 'config_ended_text', 'Mensaje al finalizar temporizador');
        $mform->setType('config_ended_text', PARAM_TEXT);
        $mform->addElement('select', 'config_style', get_string('countdown_style', 'block_sence'), [
            block_sence::STYLE_DEFAULT => get_string('countdown_style_default', 'block_sence'),
            block_sence::STYLE_CORPORATE => get_string('countdown_style_corporate', 'block_sence')
        ]);

        $mform->addElement('textarea', 'config_css', get_string("css", "block_sence"), [
            'wrap' => "virtual",
            'rows' => "20",
            'cols' => "50"
        ]);     
    }
}
