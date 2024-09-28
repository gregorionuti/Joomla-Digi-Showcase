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

class JFormFieldAsset extends JFormField {
    protected $type = 'Asset';
    
    protected function getLabel() {
        return;
    }
    
    protected function getInput() {
    
        // human defined variables
        $extension_family = 'modules';
        $extension_name = 'mod_digi_showcase';
        
        // general variables
        $uri = JUri::getInstance();
        $document = JFactory::getDocument();
    	
    	// load jquery in joomla 4
    	$joomlaVersion = JVERSION;
    	if ($joomlaVersion >= '4') {
			$wa = JFactory::getApplication()->getDocument()->getWebAssetManager();
			$wa->useScript('jquery');
    	}
        
        $document->addScript(JURI::root().$extension_family.DS.$extension_name.DS.'extras'.DS.'asset.js');
        $document->addStyleSheet(JURI::root().$extension_family.DS.$extension_name.DS.'extras'.DS.'asset.css');
        
        return;
    }
}

?>