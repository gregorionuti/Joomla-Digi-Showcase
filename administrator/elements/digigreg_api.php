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
use Joomla\CMS\Version;
    
    // return current joomla version
    function getJoomlaVersion() {
		/* deprecated with PHP 8 - return Version::getShortVersion(); */
		return JVERSION;
    }
    
    // return extension type of extension where function is called
    function getExtensionType() {
        $uri = Uri::getInstance();
        $uri_exploded_first = explode('=', $uri);
        $uri_first_part = $uri_exploded_first[1];
        $uri_exploded_second = explode('&', $uri_first_part);
        $extension_type = $uri_exploded_second[0];
        if ($extension_type == 'com_templates') {
            $extension_type_clean = 'templates';
        } else if ($extension_type == 'com_modules' || $extension_type == 'com_advancedmodules') {
            $extension_type_clean = 'modules';
        } else if ($extension_type == 'com_plugins') {
            $extension_type_clean = 'plugins';
        } else {
            $extension_type_clean = 'components';
        }
        $extension_type = substr($extension_type_clean, 0, -1);
        return $extension_type;
    }
    
    // return extension family of extension where function is called
    function getExtensionFamily() {
        $extension_type = getExtensionType();
        $extension_family = $extension_type.'s';
        return $extension_family;
    }
    
    // return plugin type of plugin where function is called
    function getPluginType() {
    	$extension_type = getExtensionType();
    	if ($extension_type == 'plugin') {
    		$uri = Uri::getInstance();
			$elements_directory = dirname(__FILE__);
			$uri_exploded_first = explode('=', $uri);
			$uri_first_part = $uri_exploded_first[1];
			$uri_exploded_second = explode('&', $uri_first_part);
			$plugin_type = $uri_exploded_second[0];
			$elements_directory_exploded_first = explode('plugins'.DS, $elements_directory);
			$path_after_plugins_folder = $elements_directory_exploded_first[1];
			$path_after_plugins_folder_exploded = explode(DS, $path_after_plugins_folder);
			$plugin_type = $path_after_plugins_folder_exploded[0];
			return $plugin_type;
    	} else {
    		return 'not a plugin';
    	}
        
    }
    
    // return extension name (human name)
    function getExtensionName() {
        $elements_directory = dirname(__FILE__);        
        $extension_type = getExtensionType();
        
        if ($extension_type == 'template') {
            $elements_directory_exploded_first = explode('templates'.DS, $elements_directory);
        } else if ($extension_type == 'module') {
            $elements_directory_exploded_first = explode('modules'.DS, $elements_directory);
        } else if ($extension_type == 'plugin') {
            $plugin_type = getPluginType();
            $elements_directory_exploded_first = explode('plugins'.DS.$plugin_type.DS, $elements_directory);
        } else {
            $elements_directory_exploded_first = explode('components'.DS, str_replace(DS.'models'.DS.'fields', '', $elements_directory));
        }
        $elements_directory_first_part = $elements_directory_exploded_first[1];
        $elements_directory_exploded_second = explode(DS.'administrator', $elements_directory_first_part);
        $extension_name = $elements_directory_exploded_second[0];
        if ($extension_type == 'template') {
            $manifest_path = str_replace('administrator'.DS.'elements', '', $elements_directory).'templateDetails.xml';
        } else if ($extension_type == 'module') {
            $manifest_path = str_replace('administrator'.DS.'elements', '', $elements_directory).$extension_name.'.xml';
        } else if ($extension_type == 'plugin') {
            $manifest_path = str_replace('administrator'.DS.'elements', '', $elements_directory).$extension_name.'.xml';
        } else {
            $manifest_path = str_replace('models'.DS.'fields', '', $elements_directory).str_replace('com_', '', $extension_name).'.xml';
        }
        if (JFile::exists($manifest_path)) {
            $manifest = simplexml_load_file($manifest_path);
            $extension_name = (string) $manifest->name;
            $extension_name = str_replace('com_', '', $extension_name);
            $extension_name = str_replace('mod_', '', $extension_name);
            $extension_name = str_replace('plg_', '', $extension_name);
            $extension_name = str_replace('tpl_', '', $extension_name);
            $extension_name = ucwords(str_replace('_', ' ', $extension_name));
            return $extension_name;
        } else {
        	return 'missing extension manifest file';
        }
    }
    
    // return extension system name (system name)
    function getExtensionSystemName() {
        $elements_directory = dirname(__FILE__);        
        $extension_type = getExtensionType();
        if ($extension_type == 'template') {
            $elements_directory_exploded_first = explode('templates'.DS, $elements_directory);
        } else if ($extension_type == 'module') {
            $elements_directory_exploded_first = explode('modules'.DS, $elements_directory);
        } else if ($extension_type == 'plugin') {
            $pluginType = getPluginType();
            $elements_directory_exploded_first = explode('plugins'.DS.$pluginType.DS, $elements_directory);
        } else {
            $elements_directory_exploded_first = explode('components'.DS, str_replace(DS.'models'.DS.'fields', '', $elements_directory));
        }
        $elements_directory_first_part = $elements_directory_exploded_first[1];
        $elements_directory_exploded_second = explode(DS.'administrator', $elements_directory_first_part);
        $extension_system_name = $elements_directory_exploded_second[0];
        return $extension_system_name;
    }
    
    // return extension version
    function getExtensionVersion() {
        $elements_directory = dirname(__FILE__);
        $extension_name = getExtensionName();
        $extension_system_name = getExtensionSystemName();
        $extension_type = getExtensionType();
        if ($extension_type == 'template') {
            $manifest_path = str_replace('administrator'.DS.'elements', '', $elements_directory).'templateDetails.xml';
        } else if ($extension_type == 'module') {
            $manifest_path = str_replace('administrator'.DS.'elements', '', $elements_directory).$extension_system_name.'.xml';
        } else if ($extension_type == 'plugin') {
            $manifest_path = str_replace('administrator'.DS.'elements', '', $elements_directory).$extension_system_name.'.xml';
        } else {
            $manifest_path = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.$extension_system_name.DS.strtolower(str_replace('', '_', $extension_name)).'.xml';
        }
        if (JFile::exists($manifest_path)) {
            $manifest = simplexml_load_file($manifest_path);
            $extension_version = (string) $manifest->version;
            return $extension_version;
        } else {
        	return 'missing extension manifest file';
        }
    }
    
?>