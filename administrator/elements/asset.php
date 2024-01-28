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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField {
    protected $type = 'Asset';
    
    protected function getLabel() {
        return;
    }
    
    protected function getInput() {
    
        // include digigreg api
        include_once "digigreg_api.php";
        
        // general variables and joomla classes
        $uri = Uri::getInstance();
        $doc = JFactory::getDocument();
        $extension_family = getExtensionFamily();
        $extension_system_name = getExtensionSystemName();
        
        if ($extension_family == 'plugins') {
            $plugin_type = getPluginType().DS;
        } else {
            $plugin_type = '';
        }
    	
    	// load jquery in joomla 4
    	$joomlaVersion = getJoomlaVersion();
    	if ($joomlaVersion >= '4') {
			$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
			$wa->useScript('jquery');
    	}
        
        $doc->addScript(URI::root().$extension_family.DS.$plugin_type.$extension_system_name.DS.'administrator'.DS.'asset.js');
        $doc->addStyleSheet(URI::root().$extension_family.DS.$plugin_type.$extension_system_name.DS.'administrator'.DS.'asset.css');
                
        if ($this->element['extension'] == 'js') {
            $doc->addScript(URI::root().$this->element['path']);
        } else {
            $doc->addStyleSheet(URI::root().$this->element['path']);       
        }
        
        // debug
        /*
        $joomla_version = getJoomlaVersion();
        $extension_type = getExtensionType();
        $plugin_type = getPluginType();
        $extension_family = getExtensionFamily();
        $extension_name = getExtensionName();
        $extension_system_name = getExtensionSystemName();
        $extension_version = getExtensionVersion();
        $extension_version_type = getExtensionVersionType();
        echo '<div style="border: 1px solid #000; margin-bottom: 20px; padding: 30px;">';
        echo '<h3>DEBUG</h3><br />';
        echo 'Joomla version: '.$joomla_version.'<br />';
        echo 'Extension type: '.$extension_type.'<br />';
        echo 'Plugin type: '.$plugin_type.'<br />';
        echo 'Extension family: '.$extension_family.'<br />';
        echo 'Extension name: '.$extension_name.'<br />';
        echo 'Extension system name: '.$extension_system_name.'<br />';
        echo 'Extension version: '.$extension_version.'<br />';
        echo 'Extension type: '.$extension_version_type.'<br />';
        echo '</div>';
        */
        
        return;
    }
}

?>