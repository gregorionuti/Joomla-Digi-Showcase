<?php
/**
 * 
 * @version             See field version manifest file
 * @package             See field name manifest file
 * @author				Gregorio Nuti
 * @copyright			See field copyright manifest file
 * @license             GNU General Public License version 2 or later
 * 
 */

// no direct access
defined('_JEXEC') or die;

// define ds variable for joomla 3 compatibility
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// namespaces
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

jimport('joomla.filesystem.file');

class JFormFieldBackup extends JFormField {
    protected $type = 'Backup';
    
    protected function getInput() {
    	
    	// include digigreg api
        include_once "digigreg_api.php";
        
        // get extension general variables
        $joomla_version = getJoomlaVersion();
        $extension_type = getExtensionType();
        $extension_name = getExtensionName();
        $extension_system_name = getExtensionSystemName();
        $extension_version = getExtensionVersion();
        $document = Factory::getDocument();
        $joomlaVersion = getJoomlaVersion();
    	
    	// specific classes and styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12 col-md-6';
    		$card_class = 'card';
    		$card_title_class = 'card-title';
    		$card_body_class = 'card-body';
    		$card_text_class = 'card-text';
    		$bg_success_class = "bg-success";
    		$btn_success_class = "btn-outline-success";
    		$btn_dark_class = "btn-outline-dark";
    		$btn_warning_class = "btn-outline-warning";
    		$btn_info_class = "btn-outline-info";
    		$badge_success_class = "badge bg-success";
    		$badge_info_class = "badge bg-info";
    		$badge_danger_class = "badge bg-danger";
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span6';
    		$card_class = 'well';
    		$card_title_class = 'title';
    		$card_body_class = 'well';
    		$card_text_class = 'text';
    		$bg_success_class = "alert alert-success";
    		$btn_success_class = "btn-success";
    		$btn_dark_class = "btn-default";
    		$btn_warning_class = "btn-warning";
    		$btn_info_class = "btn-info";
    		$badge_success_class = "label label-success";
    		$badge_info_class = "label label-info";
    		$badge_danger_class = "label label-important";
    		
    		$document->addStyleDeclaration('
    			#backup_form > .well {
					margin: 0;
					background-color: rgba(0, 0, 0, 0.1);
				}
    			#backup_form .input-group-text {
					display: inline-block;
					margin-right: 5px;
					margin-left: 5px;
				}
				#backup_form .bg-dark {
					background-color: rgb(33, 37, 41);
					padding: 15px;
					border-radius: 5px;
					color: rgb(255, 181, 20);
					font-weight: bold;
				}
    		');
    	}
        
        // general variables
        $uri = Uri::getInstance();
        $base_path = str_replace('administrator'.DS.'elements', '', dirname(__FILE__)).'settings'.DS;
        $db = Factory::getDBO();
    	$document = Factory::getDocument();
    	
    	// add css style
		$document->addStyleDeclaration('
			#backup_message {
				margin-top: 40px;
			}
			#backup_form {
				background-color: #fcf8e3;
				background: repeating-linear-gradient(
				  45deg,
				  #fcf8e3,
				  #fcf8e3 10px,
				  #f0ecd7 10px,
				  #f0ecd7 20px
				);
				border-color: #f0ecd7;
			}
			#backup_form > *, #backup_form .card-title {
				color: #8a6d3b;
			}
			#backup_form .lead {
				font-weight: 400;
			}
			li.active > a[href="#attrib-backup"] {
				background-color: #fcf8e3 !important;
				color: #8a6d3b !important;
			}
		');
    	
    	// add javascript code
    	$document->addScriptDeclaration('
			$j(document).ready(function(){
				
				var backup_message_container = $j("#backup_message");
				$j(function backup() {
		
					var loadButton = $j("#backup_load");
					var saveButton = $j("#backup_save");
					var deleteButton = $j("#backup_delete");
		
					backup_message_container.html("<div class=\"alert alert-block alert-warning\"><h4 style=\"text-transform: uppercase;\">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_INFO').'</h4> '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_CURRENT').' " + backup_message_container.attr("type") + " '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_IS').' " + backup_message_container.attr("extension") + " " + backup_message_container.attr("version") + " '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_JOOMLA_VERSION').' " + backup_message_container.attr("joomlaversion") + ".</div>");
		
					saveButton.click(function(e) {
						e.stopPropagation();
						e.preventDefault();
						backupOperation("save");
					});
		
					deleteButton.click(function(e) {
						e.stopPropagation();
						e.preventDefault();
						backupOperation("delete");
					});
		
					loadButton.click(function(e) {
						e.stopPropagation();
						e.preventDefault();
						backupOperation("load");
					});
		
				});
	
				function backupOperation(current_operation) {
		
					var current_url = window.location;
					var current_file = $j("#backup_" + current_operation + "_filename").val();
					var load_container = $j("#backup_load_filename");
					var delete_container = $j("#backup_delete_filename");
		
					if (current_file == "") {
						// get the current time in the proper format to use it if file name is not specified
						var now = new Date();
						var s = now.getSeconds();
						var m = now.getMinutes();
						var h = now.getHours();
						var dd = now.getDate();
						var mm = now.getMonth() + 1;
						var yyyy = now.getFullYear();
						// add a "0" if number is only one character
						if (s < 10) {
							s = "0" + s
						}
						if (m < 10) {
							m = "0" + m
						}
						if (h < 10) {
							h = "0" + h
						} 
						if (dd < 10) {
							dd = "0" + dd
						} 
						if (mm < 10) {
							mm = "0" + mm
						} 
						now = mm + "_" + dd + "_" + yyyy + "-" + h + "_" + m + "_" + s;
			
						current_file = "settings_" + now;
					}
		
					current_url = current_url + "&backup_task=" + current_operation + "&backup_file=" + current_file;
					backup_message_container.html("<div class=\"alert alert-block alert-warning\"><h4 style=\"text-transform: uppercase;\">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_PLEASE_WAIT').'</h4> <span id=\"loader\"><img style=\"margin-left: 30px;\" width=\"14\" src=\"http://www.digigreg.com/images/icons/loader.gif\" alt=\"loading\"></span></div>");
		
					$j.ajax({
						url: current_url,
						success: function(){
							if (current_operation == "save") {
								// save function
								if (!(load_container.html().indexOf(current_file) >= 0)) {
									load_container.append("<option value=\"" + current_file + ".json\">" + current_file + ".json</option>");
									delete_container.append("<option value=\"" + current_file + ".json\">" + current_file + ".json</option>");
								}
								$j(load_container).val(current_file + ".json").trigger("liszt:updated");
								$j(delete_container).val(current_file + ".json").trigger("liszt:updated");
								backup_message_container.html("<div class=\"alert alert-block alert-success\"><h4 style=\"text-transform: uppercase;\">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_DONE').'</h4> '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_CURRENT_SETTINGS_SAVED').' \"" + current_file + ".json\".</div>");
							} else if (current_operation == "delete") {
								// delete function
								$j(load_container).find("option[value=\"" + current_file + "\"]").remove();
								$j(delete_container).find("option[value=\"" + current_file + "\"]").remove();
								$j(load_container).val("").trigger("liszt:updated");
								$j(delete_container).val("").trigger("liszt:updated");
								backup_message_container.html("<div class=\"alert alert-block alert-success\"><h4 style=\"text-transform: uppercase;\">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_DONE').'</h4> '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_FILE').' \"" + current_file + "\" '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_FILE_DELETED').'.</div>");
							} else if (current_operation == "load") {
								// load function
								backup_message_container.html("<div class=\"alert alert-block alert-success\"><h4 style=\"text-transform: uppercase;\">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_DONE').'</h4> '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_FILE').' \"" + current_file + "\" '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_FILE_LOADED').'.</div>");
								// reload the page to load loaded values into fields
								window.location = current_url.replace("#", "").replace("&backup_task=" + current_operation + "&backup_file=" + current_file, "");
							}
						}
					});
		
				}
				
			});
		');
        
        // get correct table of database
        if ($extension_type == 'module') {
            $db_table = '#__modules';
        } else if ($extension_type == 'template') {
            $db_table = '#__template_styles';
        } else if ($extension_type == 'plugin') {
            $db_table = '#__extensions';
        } else if ($extension_type == 'component') {
            $db_table = '#__extensions';
        }
        
        // get variables from url and set database column
        if (($extension_type == 'module') || ($extension_type == 'template')) {
            $extension_id = $uri->getVar('id', 'none');
            $db_column = 'id';
        } else if (($extension_type == 'plugin') || ($extension_type == 'component')) {
            $extension_id = $uri->getVar('extension_id', 'none');
            $db_column = 'extension_id';
        }
        $task = $uri->getVar('backup_task', 'none');
        $file = $uri->getVar('backup_file', 'none');
        
        // if url contains proper variables
		if ($extension_id !== 'none' && is_numeric($extension_id) && $task !== 'none') {
            if($task == 'load') {
                if(JFile::exists($base_path . $file)) {
                	
                	// load file
                	$file_content = file_get_contents($base_path . $file);
                	
                    $query = 'UPDATE '.$db_table.' SET params = '.$db->quote($file_content).' WHERE '.$db_column.' = '.$extension_id.' LIMIT 1';	
                    $db->setQuery($query);
                    $result = $db->execute();
                    
                }
            } else if ($task == 'save') {
            	
                $query = 'SELECT params AS params FROM '.$db_table.' WHERE '.$db_column.' = '.$extension_id.' LIMIT 1';	
                $db->setQuery($query);
                $result = $db->loadObject();
                // write file
                JFile::write($base_path.$file.'.json' , $result->params);
                
            } else if ($task == 'delete') {
            	
                // delete the file
                JFile::delete($base_path.$file);	
                
            }
        }
        
        // call function to generate files list
        $list = (array) $this->getFiles();
        
        // load the results
        $load_file = JHtml::_('select.genericlist', $list, 'load_list', 'class="form-select"', 'value', 'text', 'default', 'backup_load_filename');
        $delete_file = JHtml::_('select.genericlist', $list, 'delete_list', 'class="form-select"', 'value', 'text', 'default', 'backup_delete_filename');
        
        $html = '';
        $html .= '<div id="backup_form" class='.$card_class.'>';
        $html .= '<div class='.$card_body_class.'>';
        $html .= '<h2 class='.$card_title_class.'>'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_TITLE').'</h2>';
        $html .= '<p class="card-text bg-dark text-warning rounded p-3">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_DESC').'</p>';
        $html .= '<div class='.$row_class.'>';
        $html .= '<div class="'.$col_class.'">';
        $html .= '<p><span class="'.$badge_success_class.'">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_SAVE_SETTINGS').'</span></p><div class="input-group"><input type="text" id="backup_save_filename" class="form-control" placeholder="'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_SAVE_PLACEHOLDER').'" /><span class="input-group-text">.json</span><button id="backup_save" class="btn btn-success"><em class="icon-file-add"></em> '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_SAVE').'</button></div>';
        $html .= '<hr /><p><span class="'.$badge_info_class.'">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_LOAD_SETTINGS').'</span></p><div class="input-group">'.$load_file.'<button id="backup_load" class="btn btn-info"><em class="icon-file-check"></em> '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_LOAD').'</button></div>';
        $html .= '<hr /><p><span class="'.$badge_danger_class.'">'.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_DELETE_SETTINGS').'</span></p><div class="input-group">'.$delete_file.'<button id="backup_delete" class="btn btn-danger"><em class="icon-file-remove"></em> '.JText::_(strToUpper($extension_system_name).'_FIELD_BACKUP_DELETE').'</button></div>';
        $html .= '</div>';
        $html .= '<div class="'.$col_class.'">';
        $html .= '<div id="backup_message" class="system-message" type="'.$extension_type.'" extension="'.$extension_name.'" version="'.$extension_version.'" joomlaversion="'.$joomla_version.'"></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
    
    protected function getFiles() {
        jimport('joomla.filesystem.folder');
        
        $list = array();
        $path = str_replace('administrator'.DS.'elements', '', dirname(__FILE__)).'settings'.DS;
        
        if (!is_dir($path)) $path = JPATH_ROOT.'/'.$path;
            $files = JFolder::files($path, '.json');
            if (is_array($files)) {
                foreach($files as $file) {
                    $list[] = JHtml::_('select.option', $file, $file);
                }
            }
        
        return array_merge($list);
    }
}

?>