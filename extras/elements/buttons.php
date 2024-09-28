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

// No direct access
defined('_JEXEC') or die;

// Define DS
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.form.formfield');

class JFormFieldButtons extends JFormField {
    protected $type = 'Buttons';
    
    protected function getInput() {
    	
    	// Human defined variables
		$link_jed = 'https://extensions.joomla.org/extension/digi-showcase/';
		$link_products = 'https://www.digigreg.com/en/products.html';
		$link_documentation = 'https://www.digigreg.com/en/wiki/digi-showcase.html';
		$link_support = '#digigreg_support';
		$text_prefix = 'MOD_DIGI_SHOWCASE';
		
		// General variables
    	$document = JFactory::getDocument();
        $joomlaVersion = JVERSION;
    	
    	// Specific classes and styles based on Joomla version
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
    		$document->addStyleDeclaration('
				#digigreg_buttons_wrapper .col-12 {
					padding: .5rem 1rem!important;
				}
			');
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
    	
    	// Add css style
		$document->addStyleDeclaration('
			#digigreg_buttons_wrapper a[target="_blank"]::before {
				content: "";
			}
		');
        
        // Create the html
        $html = '';
        $html .= '<div id="digigreg_buttons_wrapper" class="'.$row_class.'">';
        $html .= '<div class="'.$col_class.'" id="digigreg_button_like">';
        
        // JED
        $html .= '<p class="small">'.JText::_(strToUpper($text_prefix).'_BUTTON_DO_YOU_LIKE').'</p>';
        $html .= '<div class="button-container" id="digigreg_button_like_jed">';
        $html .= '<a class="btn '.$btn_success_class.' btn-sm" href="'.$link_jed.'" target="_blank" title="'.JText::_(strToUpper($text_prefix).'_BUTTON_REVIEW_JED_DESC').'"><i class="icon-thumbs-up"></i> '.JText::_(strToUpper($text_prefix).'_BUTTON_REVIEW_JED_TITLE').'</a>';
        $html .= '</div>';
        
        $html .= '</div>';
        $html .= '<div class="'.$col_class.'" id="digigreg_button_help">';
        
        // Support
		$html .= '<p class="small">'.JText::_(strToUpper($text_prefix).'_BUTTON_NEED_HELP').'</p>';
		$html .= '<div class="button-container" id="digigreg_button_help_links">';
		$html .= '<a class="btn '.$btn_warning_class.' btn-sm" href="'.$link_support.'" title="'.JText::_(strToUpper($text_prefix).'_BUTTON_BUY_SUPPORT_DESC').'"><i class="icon-warning"></i> '.JText::_(strToUpper($text_prefix).'_BUTTON_BUY_SUPPORT_TITLE').'</a>';
		$html .= '</div>';
        
        $html .= '</div>';
        $html .= '<div class="'.$col_class.'" id="digigreg_button_doc">';
        
        // Docs
		$html .= '<p class="small">'.JText::_(strToUpper($text_prefix).'_BUTTON_NEED_DOCS').'</p>';
		$html .= '<div class="button-container" id="digigreg_button_doc_links">';
		$html .= '<a class="btn '.$btn_info_class.' btn-sm" href="'.$link_documentation.'" target="_blank" title="'.JText::_(strToUpper($text_prefix).'_BUTTON_READ_DOCS_DESC').'"><i class="icon-file"></i> '.JText::_(strToUpper($text_prefix).'_BUTTON_READ_DOCS_TITLE').'</a>';
		$html .= '</div>';
		
        $html .= '</div>';
        $html .= '<div class="'.$col_class.'" id="digigreg_button_more">';
        
        // Other extensions
		$html .= '<p class="small">'.JText::_(strToUpper($text_prefix).'_BUTTON_NEED_MORE').'</p>';
		$html .= '<div class="button-container" id="digigreg_button_more_products">';
		$html .= '<a class="btn '.$btn_dark_class.' btn-sm" href="'.$link_products.'" target="_blank" title="'.JText::_(strToUpper($text_prefix).'_BUTTON_MORE_EXTENSIONS_DESC').'"><i class="icon-grid"></i> '.JText::_(strToUpper($text_prefix).'_BUTTON_MORE_EXTENSIONS_TITLE').'</a>';
		$html .= '</div>';
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<hr />';
		
        return $html;
        
    }
}

?>