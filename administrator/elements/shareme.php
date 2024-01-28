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

class JFormFieldShareMe extends JFormField {
    protected $type = 'ShareMe';
    
    protected function getInput() {
    	
    	// links
		$link_jed = 'https://extensions.joomla.org/extension/news-display/articles-display/digi-showcase/';
		$link_products = 'https://www.digigreg.com/en/products.html';
		$link_documentation = 'https://www.digigreg.com/en/wiki/digi-showcase.html';
		$link_support = '#digigreg_adv';
    	
    	// include digigreg api
        include_once "digigreg_api.php";
        
        // get extension general variables
        $extension_system_name = getExtensionSystemName();
        $extension_type = getExtensionType();
        $plugin_type = getPluginType();
        $document = JFactory::getDocument();
        $joomlaVersion = getJoomlaVersion();
    	
    	// specific classes and styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12 col-md-3';
    		$card_class = 'card';
    		$card_title_class = 'card-title';
    		$card_body_class = 'card-body';
    		$card_text_class = 'card-text';
    		$bg_success_class = "bg-success";
    		$btn_success_class = "btn-outline-success";
    		$btn_dark_class = "btn-outline-dark";
    		$btn_warning_class = "btn-outline-warning";
    		$btn_info_class = "btn-outline-info";
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span3';
    		$card_class = 'well';
    		$card_title_class = 'title';
    		$card_body_class = 'well';
    		$card_text_class = 'text';
    		$bg_success_class = "alert alert-success";
    		$btn_success_class = "btn-success";
    		$btn_dark_class = "btn-default";
    		$btn_warning_class = "btn-warning";
    		$btn_info_class = "btn-info";
    	}
        
        // if the extension is a plugin, add the needed prefix and plugin type for the language strings
        if ($extension_type == 'plugin') {
        	$extension_system_name = 'plg_'.str_replace('-', '_', $plugin_type).'_'.str_replace('-', '_', $extension_system_name);
        }
    	
    	// general variables
    	$document = JFactory::getDocument();
    	
    	// add css style
		$document->addStyleDeclaration('
			#shareme_wrapper a[target="_blank"]::before {
				content: "";
			}
			@media (max-width: 990px) {
				#shareme_wrapper,
				#digigreg_shareme_like,
				#digigreg_shareme_more,
				#digigreg_shareme_help,
				#digigreg_shareme_doc {
					display: none;
				}
			}
		');
        
        $html = '';
        
        // open row
        $html .= '<div id="shareme_wrapper" class="'.$row_class.'">';
        
        // open column
        $html .= '<div class="'.$col_class.'" id="digigreg_shareme_like">';
        
        // like title
        $html .= '<p class="small">'.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_DO_YOU_LIKE').'</p>';
       
        // joomla extensions link
        $html .= '<div class="share-me" id="digigreg_shareme_like_jed">';
        $html .= '<a class="btn '.$btn_success_class.' btn-sm" href="'.$link_jed.'" target="_blank" title="'.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_REVIEW_JED_DESC').'"><i class="icon-thumbs-up"></i> '.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_REVIEW_JED_TITLE').'</a>';
        $html .= '</div>';
        
		// close column
        $html .= '</div>';
        
        // open column
        $html .= '<div class="'.$col_class.'" id="digigreg_shareme_more">';
        
        // more title
		$html .= '<p class="small">'.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_NEED_MORE').'</p>';
		
		// our extensions link
		$html .= '<div class="share-me" id="digigreg_shareme_more_products">';
		$html .= '<a class="btn '.$btn_dark_class.' btn-sm" href="'.$link_products.'" target="_blank" title="'.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_MORE_EXTENSIONS_DESC').'"><i class="icon-grid"></i> '.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_MORE_EXTENSIONS_TITLE').'</a>';
		$html .= '</div>';
        
        // close column
        $html .= '</div>';
        
        // open column
        $html .= '<div class="'.$col_class.'" id="digigreg_shareme_help">';
        
        // support title
		$html .= '<p class="small">'.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_NEED_HELP').'</p>';
		
        // support links
		$html .= '<div class="share-me" id="digigreg_shareme_help_links">';
		$html .= '<a class="btn '.$btn_warning_class.' btn-sm" href="'.$link_support.'" title="'.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_BUY_SUPPORT_DESC').'"><i class="icon-cart"></i> '.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_BUY_SUPPORT_TITLE').'</a>';
		$html .= '</div>';
        
        // close column
        $html .= '</div>';
        
        // open column
        $html .= '<div class="'.$col_class.'" id="digigreg_shareme_doc">';
        
        // docs title
		$html .= '<p class="small">'.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_NEED_DOCS').'</p>';
		
		// docs links
		$html .= '<div class="share-me" id="digigreg_shareme_doc_links">';
		$html .= '<a class="btn '.$btn_info_class.' btn-sm" href="'.$link_documentation.'" target="_blank" title="'.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_READ_DOCS_DESC').'"><i class="icon-file"></i> '.JText::_(strToUpper($extension_system_name).'_FIELD_SHAREME_READ_DOCS_TITLE').'</a>';
		$html .= '</div>';
		
		// close column
        $html .= '</div>';
        
        // close row
        $html .= '</div>';
		
        return $html;
        
    }
}

?>