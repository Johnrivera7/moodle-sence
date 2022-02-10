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
 * Post installation steps for trigger plugin.
 * @package    block_sence  
 * @copyright   2020 John Rivera Gonzalez <john.rivera@jrivera.cl>  
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Add events fields from fixture file to database.
 */
function xmldb_block_sence_install() {
  global $CFG, $DB;

  $categories = array(
					  0 => 
					  array (
					    'name' => 'Datos Personales',
					    'sortorder' => '2',
					  )
					);
  foreach ($categories as $key => $value) {
  	$dbcategory = $DB->get_record('user_info_category', array('name' => $value['name']));

    if ($dbcategory) {
        $DB->update_record('user_info_category', array('id' => $dbcategory->id, 'name' => $value['name'], 'sortorder'=> $value['sortorder']));
    } else {
        $DB->insert_record('user_info_category', array('name' => $value['name'], 'sortorder'=> $value['sortorder']));
    }
  }

  $idDatosPersonales = $DB->get_record('user_info_category', array('name' => 'Datos Personales'));

  $fields = 
        array (
            0 => 
            array (
              'shortname' => 'rut',
              'name' => 'Rut',
              'datatype' => 'text',
              'description' => '',
              'descriptionformat' => 1,
              'categoryid' => $idDatosPersonales->id,
              'sortorder' => 1,
              'required' => 1,
              'locked' => 0,
              'visible' => 2,
              'forceunique' => 1,
              'signup' => 1,
              'defaultdata' => '',
              'defaultdataformat' => 0,
              'param1' => 12,
              'param2' => 12,
              'param3' => 0,
              'param4' => '',
              'param5' => '',
            )
          );
	foreach ($fields as $key => $value) {
  	$dbfields = $DB->get_record('user_info_field', array('shortname' => $value['shortname']));
    if ($dbfields) {
      $DB->update_record('user_info_field', 
        array('id' => $dbfields->id,
          'shortname' => $value['shortname'],
          'name' => $value['name'],
          'datatype' => $value['datatype'],
          'description' => $value['description'],
          'descriptionformat' => $value['descriptionformat'],
          'categoryid' => $value['categoryid'],
          'sortorder' => $value['sortorder'],
          'required' => $value['required'],
          'locked' => $value['locked'],
          'visible' => $value['visible'],
          'forceunique' => $value['forceunique'],
          'signup' => $value['signup'],
          'defaultdata' => $value['defaultdata'],
          'defaultdataformat' => $value['defaultdataformat'],
          'param1' => $value['param1'],
          'param2' => $value['param2'],
          'param3' => $value['param3'],
          'param4' => $value['param4'],
          'param5' => $value['param5']
        )
      );
    } else {
      $DB->insert_record('user_info_field', 
        array(
          'shortname' => $value['shortname'],
          'name' => $value['name'],
          'datatype' => $value['datatype'],
          'description' => $value['description'],
          'descriptionformat' => $value['descriptionformat'],
          'categoryid' => $value['categoryid'],
          'sortorder' => $value['sortorder'],
          'required' => $value['required'],
          'locked' => $value['locked'],
          'visible' => $value['visible'],
          'forceunique' => $value['forceunique'],
          'signup' => $value['signup'],
          'defaultdata' => $value['defaultdata'],
          'defaultdataformat' => $value['defaultdataformat'],
          'param1' => $value['param1'],
          'param2' => $value['param2'],
          'param3' => $value['param3'],
          'param4' => $value['param4'],
          'param5' => $value['param5']
        )
      );
    }
  }
	$errores_sence =  array(
  array(
    "identificador" => 100 , 
    "descripcion" => "Contraseña incorrecta."), 
  array(
    "identificador" => 200 , 
    "descripcion" => "Parámetros vacíos."), 
  array(
    "identificador" => 201 , 
    "descripcion" => "Parámetro UrlError sin datos."), 
  array(
    "identificador" => 202 , 
    "descripcion" => "Parámetro UrlError con formato incorrecto. "), 
  array(
    "identificador" => 203 , 
    "descripcion" => "Parámetro UrlRetoma con formato incorrecto."), 
  array(
    "identificador" => 204 , 
    "descripcion" => "Parámetro CodSence con formato incorrecto."), 
  array(
    "identificador" => 205 , 
    "descripcion" => "Parámetro CodigoCurso con formato incorrecto."), 
  array(
    "identificador" => 206 , 
    "descripcion" => "Línea de capacitación con formato incorrecto."), 
  array(
    "identificador" => 207 , 
    "descripcion" => "Parámetro RunAlumno incorrecto."), 
  array(
    "identificador" => 208 , 
    "descripcion" => "Parámetro RunAlumno diferente al enviado por OTEC."), 
  array(
    "identificador" => 209 , 
    "descripcion" => "Parámetro RutOtec incorrecto."), 
  array(
    "identificador" => 210 , 
    "descripcion" => "Sesión caducada."), 
  array(
    "identificador" => 211 , 
    "descripcion" => "Token incorrecto."), 
  array(
    "identificador" => 212 , 
    "descripcion" => "Token caducado."), 
  array(
    "identificador" => 300 , 
    "descripcion" => "Error interno."), 
  array(
    "identificador" => 301 , 
    "descripcion" => "Error interno."), 
  array(
    "identificador" => 302 , 
    "descripcion" => "Error interno."), 
  array(
    "identificador" => 303 , 
    "descripcion" => "Error interno."), 
  array(
    "identificador" => 304 , 
    "descripcion" => "Error interno."), 
  array(
    "identificador" => 305 , 
    "descripcion" => "Error interno.")
);
	$DB->insert_records('block_sence_error_manager', $errores_sence);
}