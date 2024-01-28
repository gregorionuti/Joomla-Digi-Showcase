<?php
/**
 * 
 * @version             See field version manifest file
 * @package             See field name manifest file
 * @author				Gregorio Nuti
 * @copyright			See field copyright manifest file
 * @license             See field name manifest file
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

class JFormFieldXml extends JFormField {
    
    protected $type = 'Xml';
    
    protected function getInput() {
        
        // include digigreg api
        include_once "digigreg_api.php";
        
        // general variables and joomla classes
        $uri = Uri::getInstance();
        $joomlaVersion = getJoomlaVersion();
        
        // get the variable from the current url tp execute the update or not
        $execute = $uri->getVar('execute');
        
        // execute the task upon url check
        if ($execute == 'manifestupdate') {
    	
			// change xml structure to make it compatible with joomla 3
			if (!version_compare($joomlaVersion, "4.0.0", ">=")) {
			
				// module folder
				$basePath = str_replace('administrator'.DS.'elements', '', dirname(__FILE__)).DS;
		
				// get module manifest file content
				$xmlFile = file_get_contents($basePath.'mod_digi_showcase.xml');
		
				// change the manifest data accordinig to joomla 3 needs
				if ($xmlFile) {
					$xmlFile = str_replace('layout="joomla.form.field.radio.switcher"', 'class="btn-group" layout="joomla.form.field.radio"', $xmlFile);
			
					// mark changes as done
					$changed = true;
				}
		
				// write the manifest data
				if ($xmlFile && $changed) {
					JFile::write($basePath . 'mod_digi_showcase.xml' , $xmlFile);
					
					// redirect to the done url
					$done_url = str_replace('&execute=manifestupdate','&execute=done', $uri);
					header("Location: ".$done_url);
				}
				
			}
		
		} else if ($execute == 'done') {
			
				$message = '<p class="text-center alert alert-success" style="margin-bottom: 25px; margin-top: 25px; padding: 50px;">';
				$message .= JText::_('MOD_DIGI_SHOWCASE_FIELD_UPDATE_XML_DONE_DESC');
				$message .= '</p>';
				return $message;
			
		} else {
			
			// print the button to update the manifest file
			if (!version_compare($joomlaVersion, "4.0.0", ">=")) {
				
				// module folder
				$basePath = str_replace('administrator'.DS.'elements', '', dirname(__FILE__)).DS;
		
				// get module manifest file content
				$xmlFile = file_get_contents($basePath.'mod_digi_showcase.xml');
			
				if (strpos($xmlFile, 'layout="joomla.form.field.radio.switcher"') !== false) {
					$update_button = '<p class="text-center alert alert-warning" style="margin-bottom: 25px; margin-top: 25px; padding: 50px;">';
					$update_button .= JText::_('MOD_DIGI_SHOWCASE_FIELD_UPDATE_XML_DESC').'<br /><br />';
					$update_button .= '<a class="btn btn-warning btn-large" href="'.$uri.'&execute=manifestupdate">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_UPDATE_XML_TITLE').'</a>';
					$update_button .= '</p>';
					return $update_button;
				} else {
					return;
				}
				
			}
			
		}
        
    }
}

?>