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

/**
 * Compatibility layer for legacy Joomla global class names.
 *
 * On Joomla 3 these classes are native and this file does nothing.
 * On Joomla 4/5 with the "Behaviour - Backward Compatibility" plugin
 * active, the aliases already exist and this file does nothing.
 * On Joomla 5/6 with that plugin disabled, the legacy names below do
 * not exist at all: this file recreates them as aliases of the
 * equivalent namespaced core classes, which are always present
 * regardless of the plugin state.
 */
if (!function_exists('digiShowcaseRegisterLegacyAlias')) {
	function digiShowcaseRegisterLegacyAlias($legacyName, $modernClass) {

		// already available: native on J3, or already aliased by Joomla (BC plugin) or by us
		if (class_exists($legacyName, false)) {
			return;
		}

		// modern namespaced class not available (expected on J3): nothing to alias
		if (!class_exists($modernClass)) {
			return;
		}

		// class_exists($modernClass) above may have triggered, as a side effect,
		// the autoload of the modern class and with it Joomla's own automatic
		// aliasing (JLoader::applyAliasFor), if the Backward Compatibility
		// plugin is active. Re-check to avoid a harmless but needless
		// duplicate class_alias() call.
		if (!class_exists($legacyName, false)) {
			class_alias($modernClass, $legacyName);
		}
	}
}

digiShowcaseRegisterLegacyAlias('JFormField',    '\Joomla\CMS\Form\FormField');
digiShowcaseRegisterLegacyAlias('JFactory',      '\Joomla\CMS\Factory');
digiShowcaseRegisterLegacyAlias('JText',         '\Joomla\CMS\Language\Text');
digiShowcaseRegisterLegacyAlias('JHtml',         '\Joomla\CMS\HTML\HTMLHelper');
digiShowcaseRegisterLegacyAlias('JUri',          '\Joomla\CMS\Uri\Uri');
digiShowcaseRegisterLegacyAlias('JRoute',        '\Joomla\CMS\Router\Route');
digiShowcaseRegisterLegacyAlias('JRegistry',     '\Joomla\Registry\Registry');
digiShowcaseRegisterLegacyAlias('JPluginHelper', '\Joomla\CMS\Plugin\PluginHelper');
digiShowcaseRegisterLegacyAlias('JModuleHelper', '\Joomla\CMS\Helper\ModuleHelper');
digiShowcaseRegisterLegacyAlias('JFile',         '\Joomla\CMS\Filesystem\File');

?>
