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

jimport('joomla.form.formfield');

class JFormFieldDigishowcasextd extends JFormField {
    protected $type = 'Digishowcasextd';
    
    protected function getLabel() {
		
		// include module helper
		require_once JPATH_ROOT.DS.'modules'.DS.'mod_digi_showcase'.DS.'helper.php';
		
		// get module id of current istance of the module
		$moduleId = JFactory::getApplication()->input->get('id');
		
		// define label
		$label = '';
		
		if ($moduleId) {
			
			// get module params of current istance of the module
			$params = Digi_Showcase_Helper::getModuleParamsFromId($moduleId);
			
			// get the label of this field from selected expasion pack
			$label = $params['expansion-pack'];
			
			if ($label) {
				
				// format the label
				$label = strtoupper($label);
				$label = JText::_('PLG_DIGISHOWCASE_'.$label.'_MODULE_FIELD_LABEL');
			}
		}
		
        return $label;
    }
    
    protected function getInput() {
		
		$document = JFactory::getDocument();
    	
    	// add javascript code
    	$document->addScriptDeclaration('
			$j(document).ready(function(){
				
				$j("#jform_params_expansion_pack").each(function() {
					
					var item_id = "#" + $j(this).attr("id");
					var data_container_id = "#jformparamsexpansion-pack-data";
					var expansion_pack_message_container = $j("#expansion_pack_message");
					
					$j(item_id).change(function() {
						var message = "<div class=\"alert alert-block alert-warning\" style=\"display: none; margin-bottom: 0;\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><h4>SAVE SETTING</h4> Please, save settings to manage expansion pack options.</div>";
						
						$j(expansion_pack_message_container).html(message);
						
						// hide the label
						$j(data_container_id).parent().parent().children(".control-label").fadeOut();
						
						// hide the input
						$j(data_container_id).parent().children(":not(:first-child)").fadeOut( function() {
							
							// show the message
							$j(expansion_pack_message_container).children().fadeIn();
						});
						
					});
				
				});
				
			});
		');
		
		// include module helper
		require_once JPATH_ROOT.DS.'modules'.DS.'mod_digi_showcase'.DS.'helper.php';
		
		// get module id of current istance of the module
		$moduleId = JFactory::getApplication()->input->get('id');
		
		// define html
		$html = '';
		
		// add message container
		$html .= '<div id="expansion_pack_message" class="system-message"></div>';
		
		if ($moduleId) {
			
			// get module params of current istance of the module
			$params = Digi_Showcase_Helper::getModuleParamsFromId($moduleId);
			
			// get the label of this field from selected expasion pack
			$pluginName = $params['expansion-pack'];
			
			if ($pluginName) {
				
				// define plugin xml path
				$xmlPath = JPATH_ROOT.DS.'plugins'.DS.'digishowcase'.DS.$pluginName.DS.$pluginName.'.xml';
			
				// load xml
				$xml = simplexml_load_file($xmlPath);
			
				// get field data from xml
				$type = $xml->source['type'];
				$class = $xml->source['class'];
				$showon = $xml->source['showon'];
				$multiple = $xml->source['multiple'];
				$query = strval($xml->source['query']);
			
				// declare attribs array
				$attribs = array();
			
				// populate attribs array
				$class ? $attribs['class'] = $class : '';
				$showon ? $attribs['showon'] = $showon : '';
				$multiple ? $attribs['multiple'] = 1 : '';			
			} else {
				$html .= '<p class="lead">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_GET_EXPANSION_PACKS_DESC').'</p>';
				$html .= '<a class="btn btn-success" href="https://www.digigreg.com/en/products/joomla-plugins/digi-showcase-plugins.html" target="_blank">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_GET_EXPANSION_PACKS_LABEL').'</a>';
			}
			
			if ($pluginName && $type == 'sql' && $query) {
				
				// data source is from sql query in database so a select is needed
				
				// define database
				$dbo = JFactory::getDBO();
		
				// execute the query
				$dbo->setQuery($query);
				$results = $dbo->loadAssocList();
		
				// declare options array
				$options = array();
		
				// declare selected options array
				$selected = array();
		
				if(!empty($results)) {
					foreach($results AS $result) {
				
						// parse selected values array
						if(!empty($this->value)) {
							foreach($this->value AS $value) {
					
								// add the current value to selected options array
								if ($result['value'] == $value) {
									$selected[] = $result['value'];
								}
							}
						}
						
						// add current value to options array
						$options[] = JHTML::_('select.option',$result['value'], $result['expansion-packs-source']);
					}	
				}
				
				// generate input html
				$html .= JHTML::_('select.genericlist', $options, $name=$this->name.'[]', $attribs = $attribs, $key='value', $text='text', $selected = $selected);
			}
			
		}
		
        return $html;
    }
}

?>