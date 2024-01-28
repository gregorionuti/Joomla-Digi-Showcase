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

// include jquery
if (version_compare(JVERSION, "4.0.0", ">=")) {
	$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
	$wa->useScript('jquery');
} else {
	JHtml::_('jquery.framework', false);
}

// include module helper
if (file_exists(dirname(__FILE__).DS.'override'.DS.'helper.php')) {
	require_once dirname(__FILE__).DS.'override'.DS.'helper.php';
} else {
	require_once dirname(__FILE__).DS.'helper.php';
}

// include module variables
require 'modules'.DS.'mod_digi_showcase'.DS.'include'.DS.'variables.php';

// add bootstrap framework before any javascript library
if (file_exists(JPATH_BASE."/media/jui/js/bootstrap.min.js")) {
    JHtml::_('bootstrap.framework');
}

// add style files
$document->addStyleSheet(URI::root().'modules/mod_digi_showcase/assets/css/style.css');

// include layout
require JModuleHelper::getLayoutPath('mod_digi_showcase', $params->get('layout', 'default'));

?>