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

class JFormFieldSupport extends JFormField {
    protected $type = 'Support';
    
    protected function getInput() {
    	
    	// Human defined variables
		$github_link = 'https://github.com/gregorionuti/Joomla-Digi-Showcase';
		$github_issues_link = 'https://github.com/gregorionuti/Joomla-Digi-Showcase/issues';
		$github_pull_link = 'https://github.com/gregorionuti/Joomla-Digi-Showcase/pulls';
        $extension_family = 'modules';
        $extension_name = 'mod_digi_showcase';
        $text_prefix = 'MOD_DIGI_SHOWCASE';
		
    	// General variables
    	$document = JFactory::getDocument();
    	$joomlaVersion = JVERSION;
    	
    	// Specific classes and styles based on Joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12 col-md-12';
    		$card_class = 'card';
    		$card_title_class = 'card-title';
    		$card_body_class = 'card-body';
    		$card_text_class = 'card-text';
    		$bg_success_class = "bg-success";
    		$btn_dark_class = "btn-outline-dark";
    		$document->addStyleDeclaration('
    			@media (max-width: 1300px) {
					#digigreg_support .card-text {
						word-wrap: anywhere;
					}
				}
    			@media (max-width: 767px) {
					#digigreg_support {
						margin: 0 1rem;
					}
				}
    		');
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span12';
    		$card_class = 'well';
    		$card_title_class = 'title';
    		$card_body_class = 'well';
    		$card_text_class = 'text';
    		$bg_success_class = "alert alert-success";
    		$btn_dark_class = "btn-warning";
    		$document->addStyleDeclaration('
    			#digigreg_support .well {
					margin: 0;
					background-color: rgba(255, 255, 255, 0.7);
				}
    			#digigreg_support .well .btn-group,
    			#digigreg_support .well .mt-1 {
					margin-top: 10px;
				}
				@media (max-width: 1300px) {
					#digigreg_support .btn {
						display: block;
						border-radius: 3px;
						margin-bottom: 10px;
					}
				}
    		');
    	}
    	
    	// Add css style
		$document->addStyleDeclaration('
			#digigreg_support {
				background-color: #f89406;
				background-image: url("'.JURI::root().$extension_family.DS.$extension_name.DS.'assets'.DS.'images'.DS.'pattern-support.png");
				background-repeat: repeat;
				position: relative;
				z-index: 0;
				overflow: hidden;
			}
			#digigreg_support a[target="_blank"]::before {
				content: "";
			}
			#digigreg_support_text {
				text-align: left;
			}
		');
        
        // Create the html
        $html = '';
        $html .= '<div class="'.$row_class.'">';
        $html .= '<div class="'.$col_class.'">';
        $html .= '<div id="digigreg_support" class="'.$card_class.'">';
        $html .= '<div id="digigreg_support_text" class="'.$card_body_class.'">';
        $html .= '<h2 class="'.$card_title_class.' text-light">'.strToUpper(JText::_($text_prefix.'_SUPPORT_TITLE')).'</h2>';
        $html .= '<p class="'.$card_text_class.' bg-light text-dark rounded p-3">'.JText::_($text_prefix.'_SUPPORT_DESC').'</p>';
		$html .= '<p class="'.$card_text_class.' bg-warning text-dark rounded p-3">';
        $html .= '<span class="text-uppercase">'.JText::_($text_prefix.'_SUPPORT_GO_TO_GITHUB').'</span> <br />';
        $html .= '<span class="btn-group btn-group-sm mt-1 mb-1" role="group">';
        $html .= '<a class="btn '.$btn_dark_class.' btn-sm mt-1" href="'.$github_link.'" target="_blank">'.strToUpper(JText::_($text_prefix.'_SUPPORT_BROWSE_REPO')).'</a>';
        $html .= '<a class="btn '.$btn_dark_class.' btn-sm mt-1" href="'.$github_pull_link.'" target="_blank">'.strToUpper(JText::_($text_prefix.'_SUPPORT_PULL_REQUEST')).'</a>';
        $html .= '<a class="btn '.$btn_dark_class.' btn-sm mt-1" href="'.$github_issues_link.'" target="_blank">'.strToUpper(JText::_($text_prefix.'_SUPPORT_REPORT_BUG')).'</a>';
        $html .= '</span> <br />';
        $html .= '</p>';
		$html .= '</div>';
		$html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}

?>