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

class JFormFieldInterval extends JFormField {
    protected $type = 'Interval';
    
    protected function getInput() {
    	
    	// include digigreg api
        include_once "digigreg_api.php";
        
    	// get extension general variables
    	$document = JFactory::getDocument();
    	$joomlaVersion = getJoomlaVersion();
    	
    	// specific styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		
    	} else {
			$document->addStyleDeclaration('
				.input-group span.seconds, .input-group span.milliseconds {
					background-color: transparent;
					margin-left: 7px;
					font-size: 15px;
				}
			');
    	}
        
        // assign the default data
        $type = 'number';
        $class = '';
        
        // check if input has a class
        if ($this->element['class']) {
            
            // get input class
            $class .= $this->element['class'];
            
        }
        
        // get input number data
        if ($type == 'number') {
        	
        	$min = '';
			$max = '';
			$step = '';
        	
        	if ($this->element['min']) {
				$min = $this->element['min'];
			}
			if ($this->element['max']) {
				$max = $this->element['max'];
			}
			if ($this->element['step']) {
				$step = $this->element['step'];
			}
        	
        }
        
        // generate input html
        $html = '<div class="input-group">';
        
        $html .= '<input type="'.$type.'" 
        '.($type == 'number' ? ($min ? 'min="'.$this->element['min'].'"' : '') : '').'
        '.($type == 'number' ? ($max ? 'max="'.$this->element['max'].'"' : '') : '').'
        '.($type == 'number' ? ($step ? 'step="'.$this->element['step'].'"' : '') : '').' 
        '.($class ? 'class="form-control input-'.$this->element['class'].'"' : 'class="form-control"').' 
        name="'.$this->name.'" 
        id="'.$this->id.'" 
        value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'">';
        
        // generate unit measurement label
        if ($this->element['extension'] == 's') {
            $html .= '<span class="input-group-text seconds">s</span>';
        } else if($this->element['extension'] == 'ms') {
            $html .= '<span class="input-group-text milliseconds">ms</span>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}

?>