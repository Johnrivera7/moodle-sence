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
require_once ('sence_form.php');

/**
 * sence plugin
 *
 * @package    block_sence
 * @copyright  John Rivera Gonzalez <johnriveragonzalez7@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_sence extends block_base
{
    /**
     * Corporate style preset
     */
    const STYLE_DEFAULT = 'style-default';

    /**
     * Corporate style preset
     */
    const STYLE_CORPORATE = 'style-corporate';

    /**
     * @throws coding_exception
     */
    public function init()
    {
        $this->title = get_string('pluginname', 'block_sence');
    }

    /**
     * @return bool
     */
    function instance_allow_multiple()
    {
        return true;
    }
	

	
	
    /**
     * @return string Content of the block
     *
     * @throws coding_exception
     */
    public function get_content()
    { 
        global $CFG, $SITE, $USER, $SESSION, $COURSE;
    	$action = optional_param('action', '' ,PARAM_ALPHA);
    	$session_sence = optional_param('sence', 0, PARAM_BOOL);
    	$cs_sence = optional_param('cs', 0, PARAM_BOOL);
    	$idsesion_sence = optional_param('IdSesionSence', '' ,PARAM_TEXT);
     	$glosaerror_sence = optional_param('GlosaError', '' ,PARAM_INT);
     	$fechahora_sence = optional_param('FechaHora', '' ,PARAM_TEXT);
     	$zonahoraria_sence = optional_param('ZonaHoraria', '' ,PARAM_TEXT);
    	$courseid = $this->page->course->id;
    	$url = new moodle_url('/course/view.php', array('id' => $courseid));
   print_r($idsesion_sence); 
        $datasence['id_usuario'] = $USER->id;
        $datasence['id_curso'] = $courseid;
        if (is_null($this->config) || empty($this->config->grupo_sence)) {
        //verifica que este configurado el bloque de sence
            $this->content->text = get_string('changesettings', 'block_sence');

            return $this->content;
        }else{
    
            $usergroups = groups_get_user_groups($courseid, $USER->id);//grupos del usuario
            $groupsence = array_intersect($usergroups[0], $this->config->grupo_sence);
              if (!empty($groupsence)) {
                    $alum_sence = true;
                    $group =  groups_get_group($usergroups[0][0], $fields='name', $strictness=IGNORE_MISSING);
                   $this->config->CodigoCurso = $group->name;
                }else{
                    $alum_sence = false;
                }
            if($alum_sence){
                $this->config->timesencehours =  $this->config->timesence * 3600;
                if(empty($fechahora_sence && empty($cs_sence))){
                    $lastdatetimesence = self::lastdatetimesence($datasence);//1592541948
print_r($lastdatetimesence);
		    $existesesion = $lastdatetimesence + $this->config->timesencehours;

                    if (!empty($lastdatetimesence)) {
                        if ($existesesion > time()) {
                            $datasence['datetime_sence'] = $lastdatetimesence;
                            $lastsessionsence = self::lastsessionsence($datasence);
                            $fechahora_sence = $lastsessionsence->fecha_hora_sence;
                            $datetime_sence = $lastsessionsence->datetime_sence;
                            $idsesion_sence = $lastsessionsence->idsesion_sence;
                            $session_sence = 1;
                        }
                    }	
                }
                 
             
                if(!empty($glosaerror_sence)){
                	$dataerrors['identificador'] = $glosaerror_sence;
                	$dataerrors['id_usuario'] = $USER->id;
                	$dataerrors['id_curso'] = $courseid;
                	$dataerrors['idsesion_sence'] = $idsesion_sence;
                	$dataerrors['fecha_hora_sence'] = $fechahora_sence;
             		$datetimes_sence = new DateTime($fechahora_sence, core_date::get_user_timezone_object());
                    $datetime_sence = $datetimes_sence->getTimestamp();
             		$dataerrors['datetime_sence'] = $datetime_sence;
             		if(!empty($idsesion_sence) && empty($cs_sence)){
                    	$dataerrors['type'] = 0;
                    }else{
                    	$dataerrors['type'] = 1;
                    }
                    if(empty($cs_sence)){
                        $session_sence = 0;
                    }else{
                     	$session_sence = 1;
                    }
                 	$error_sence = self::errormanager($dataerrors);//manejador de errores
                    echo '<script type="text/javascript">alert("Error: ' .$error_sence->descripcion. '");</script>';
                }
             
             	if (!empty($fechahora_sence) && empty($glosaerror_sence)) {
                    $datasence['fecha_hora_sence'] = $fechahora_sence;
                    $datetimes_sence = new DateTime($fechahora_sence, core_date::get_user_timezone_object());
                    $datetime_sence = $datetimes_sence->getTimestamp();
                    $datasence['datetime_sence'] = $datetime_sence;
                	$datasence['id_usuario'] = $USER->id;
                	$datasence['id_curso'] = $courseid;
                	$datasence['idsesion_sence'] = $idsesion_sence;
                	$datasence['fecha_hora'] = $fechahora_sence;
                	if (!empty($session_sence)) {
                        $session_sence = 1;
                        }else{
                            $session_sence = 0;
                        }
        			if(!empty($idsesion_sence)){
                    	$datasence['idsesion_sence'] = $idsesion_sence;
            			$this->config->idsesionsence = $idsesion_sence;
        			 	}else{
                    	$session_sence = 0;
                    }
                	$datasence['type'] = $session_sence;
                	self::savesencedata($datasence);
                }
            	
            
            	$categoryid = ($this->page->context->contextlevel === CONTEXT_COURSECAT) ? $this->page->category->id : null;
            	if (!empty($this->content)) {
                	return $this->content;
            	}

            	$this->content = new stdClass();
                if (is_null($this->config)) {
                    $this->content->text = get_string('changesettings', 'block_sence');
                    return $this->content;
                }else{
            		if ($session_sence) {
            			$this->config->sesionsence = 1;
            		}else {
            			$this->config->sesionsence = 0;
                    }
            		
                }

            	$this->page->requires->jquery();
            	$this->page->requires->js("/blocks/sence/js/jquery.sence.js");
            	$this->page->requires->js("/blocks/sence/js/start.js");
            	
                $tag = 'div';
            	$params = [];
         		
                if (!$session_sence) {
                $params['class'] = 'sence_blocked';
                $params['data-sessionsence_blocked'] = 1;
                $this->content->text = html_writer::tag($tag, '', $params);    
                }else{
                    $params['class'] = 'sence_blocked';
                    $params['data-sessionsence_blocked'] = 0;
                    $this->content->text = html_writer::tag($tag, '', $params); 
                }

             
             	if (!empty($fechahora_sence && !empty($session_sence))) {
          			$this->config->timesencehours =  $this->config->timesence * 3600;
             		$this->config->timesencestop = $datetime_sence + $this->config->timesencehours;

                    if ($this->config->timesencestop > time() && $session_sence = 1) {
                    $params['class'] = "block-countdown-timer {$this->config->style}";
                    $params['data-endedtext'] = $this->config->ended_text;

                        try {
                            $until = new DateTime();
                            $until->setTimestamp($this->config->timesencestop);
                            $params['data-datetime'] = $until->format(DATE_ATOM);
                        } catch (\Exception $ex) {
                        	$params['data-datetime'] = date(DATE_ATOM, $this->config->timesencestop);
                        }

                        $this->content->text = html_writer::tag($tag, '', $params);
                	} else {
                        if ($this->config->ended_text) {
                        $endedtext = $this->config->ended_text;
                        } else {
                            $endedtext = get_string('changesettings', 'block_sence');
                        }
                        $params['class'] = 'countdown-ended';
                        $this->content->text = html_writer::tag($tag, $endedtext, $params);
               		}
                }

           		if ($this->config->css) {
                	$this->content->text = html_writer::tag('style', $this->config->css) . $this->content->text;
            	}
            
        		$this->config->rut = $USER->profile['rut'];
         		$this->config->sesion = $USER->sesskey;
         		$this->config->UrlRetoma = $CFG->wwwroot.'/course/view.php?id='.$courseid.'&sence=1';
         		$this->config->UrlError = $CFG->wwwroot.'/course/view.php?id='.$courseid.'&sence=0';
         		
                if($session_sence){
         			$this->config->url = $this->config->url_fin_sesion;
                	$this->config->UrlError = $CFG->wwwroot.'/course/view.php?id='.$courseid.'&sence=0&cs=1';
                }else{
                	$this->config->url = $this->config->url_inicio_sesion;
                }

        		if($alum_sence){
				$sence = new sence_form($this->config->url, $this->config, 'post', $this->config->urltarget);
		//		print_r($sence);
            		$this->content->text .= $sence->render();
            	}
            }
        // 	       print_r($this->content); 
            return $this->content;
        }
    }



	private static function errormanager($dataerror)
    {
        global $DB;
        $dataerror['timecreated'] = time();
    	$result = $DB->get_record('block_sence_error_manager', array('identificador' => $dataerror['identificador']));
    	$error = $DB->get_record('block_sence_error_log', array('id_usuario' => $dataerror['id_usuario'],'id_curso' => $dataerror['id_curso'], 'datetime_sence' => $dataerror['datetime_sence'], 'type' => $dataerror['type']));
        if (!$error) {
            $id_error = $DB->insert_record('block_sence_error_log', $dataerror);
        }
    	return $result;
    }


	private static function savesencedata($datasence)
    {
        global $DB;
        $datasence['timecreated'] = time();
        $log = $DB->get_record('block_sence_sesion_log', array('id_usuario' => $datasence['id_usuario'],'idsesion_sence' => $datasence['idsesion_sence'], 'id_curso' => $datasence['id_curso'], 'datetime_sence' => $datasence['datetime_sence'], 'type' => $datasence['type']));
        if ($log) {
            $resp = false;
        }else{
    	   $resp = $DB->insert_record('block_sence_sesion_log', $datasence);
        }
    	return $resp;
    }


    private static function lastdatetimesence($datasence)
    {
        global $DB;
    	$ultimo_cierre = $DB->get_field('block_sence_sesion_log', 'MAX(datetime_sence)', array('id_usuario' => $datasence['id_usuario'], 'id_curso' => $datasence['id_curso'],  'type' => 0));
        $ultimo_inicio = $DB->get_field('block_sence_sesion_log', 'MAX(datetime_sence)', array('id_usuario' => $datasence['id_usuario'], 'id_curso' => $datasence['id_curso'], 'type' => 1));
    	if(empty($ultimo_cierre) || $ultimo_cierre < $ultimo_inicio){
        	$resp = $ultimo_inicio;
        }else{
        	$resp = false;
        }
        return $resp;
    }


    private static function lastsessionsence($datasence)
    {
        global $DB;
        $lastsessionsence = $DB->get_record('block_sence_sesion_log', array('id_usuario' => $datasence['id_usuario'], 'id_curso' => $datasence['id_curso'], 'datetime_sence' => $datasence['datetime_sence'], 'type' => 1));
print_r($lastsessionsence);    
	return $lastsessionsence;
    } 
}
