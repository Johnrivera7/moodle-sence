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
// along with Moodle.  If not, see http://www.gnu.org/licenses.

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

/**
 * Description editing form definition.
 * @author      John Rivera Gonzalez <johnriveragonzalez7@gmail.cl>
 * @package     block_sence
 * @copyright   2020 John Rivera Gonzalez <john.rivera@jrivera.cl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



class sence_form extends moodleform {
/**
 * Defines the standard structure of the form.
 * @throws \coding_exception
 */
 function definition() 
 {  global $CFG;
    $mform = $this->_form;
    $sence = $this->_customdata;
   
  
    $mform->addElement('hidden', 'RutOtec', $sence->RutOtec, array('id' => 'RutOtec'));
  	$mform->setType('RutOtec', PARAM_TEXT);
    $mform->addElement('hidden', 'Token', $sence->Token, array('id' => 'Token'));
    $mform->setType('Token', PARAM_TEXT);
    $mform->addElement('hidden', 'CodSence', $sence->CodSence, array('id' => 'CodSence'));
    $mform->setType('CodSence', PARAM_TEXT);
    $mform->addElement('hidden', 'CodigoCurso', $sence->CodigoCurso, array('id' => 'CodigoCurso'));
    $mform->setType('CodigoCurso', PARAM_TEXT);
    $mform->addElement('hidden', 'LineaCapacitacion', $sence->LineaCapacitacion, array('id' => 'LineaCapacitacion'));
    $mform->setType('LineaCapacitacion', PARAM_TEXT);
    $mform->addElement('hidden', 'RunAlumno', $sence->rut, array('id' => 'RunAlumno'));
    $mform->setType('RunAlumno', PARAM_TEXT);
    $mform->addElement('hidden', 'IdSesionAlumno', $sence->sesion, array('id' => 'IdSesionAlumno'));
    $mform->setType('IdSesionAlumno', PARAM_TEXT);
    $mform->addElement('hidden', 'UrlRetoma', $sence->UrlRetoma, array('id' => 'UrlRetoma'));
    $mform->setType('UrlRetoma', PARAM_URL);
    $mform->addElement('hidden', 'UrlError', $sence->UrlError, array('id' => 'UrlError'));
    $mform->setType('UrlError', PARAM_URL);
    
    if($sence->sesionsence){
      $mform->addElement('hidden', 'IdSesionSence', $sence->idsesionsence, array('id' => 'IdSesionSence'));
    $mform->setType('IdSesionSence', PARAM_TEXT);
      $mform->addElement('submit', 'stopsession', get_string('stopsession', 'block_sence'));
    }else{
      $mform->addElement('submit', 'startsesion', get_string('startsession', 'block_sence'));
    }
    $mform->addElement('html', '<p><h4>Enlaces de interés</h4></p>
        <a href="https://cus.sence.cl/Account/Registrar" target="_blank">Registrar CUS </a><br>
        <a href="https://cus.sence.cl/Account/RecuperarClave" target="_blank">Solicitar Nueva CUS </a><br>
        <a href="https://cus.sence.cl/Account/CambiarClave" target="_blank">Cambiar CUS </a><br>
        <a href="https://cus.sence.cl/Account/ActualizarDatos" target="_blank">Actualizar Datos </a>');
  } 
}