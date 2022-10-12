<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'../system/libraries/Form_validation'.EXT);
require_once(APPPATH.'libraries/validation'.EXT);
/**
 * set_rules를 수정하여 api 용으로 새로 생성 (put method의 data 못가져오는 문제)
 * 2019-12-04
 * @author Sunha Ryu
 */
class api_validation extends validation {
public $error_array;
	function __construct() {
		parent::__construct();	
	}
	
	/**
	 * Set Rules
	 *
	 * This function takes an array of field names and validation
	 * rules as input, any custom error messages, validates the info,
	 * and stores it
	 *
	 * @param	mixed	$field
	 * @param	string	$label
	 * @param	mixed	$rules
	 * @param	array	$errors
	 * @return	CI_Form_validation
	 */
	public function set_rules($field, $label = null, $rules = null, $errors = array())
	{
	    // No reason to set rules if we have no POST data
	    // or a validation array has not been specified
	    if ($this->CI->input->method() !== 'post' && $this->CI->input->method() !== 'put' && empty($this->validation_data))
	    {
	        return $this;
	    }
	    
	    // If an array was passed via the first parameter instead of individual string
	    // values we cycle through it and recursively call this function.
	    if (is_array($field))
	    {
	        foreach ($field as $row)
	        {
	            // Houston, we have a problem...
	            if ( ! isset($row['field'], $row['rules']))
	            {
	                continue;
	            }
	            
	            // If the field label wasn't passed we use the field name
	            $label = isset($row['label']) ? $row['label'] : $row['field'];
	            
	            // Add the custom error message array
	            $errors = (isset($row['errors']) && is_array($row['errors'])) ? $row['errors'] : array();
	            
	            // Here we go!
	            $this->set_rules($row['field'], $label, $row['rules'], $errors);
	        }
	        
	        return $this;
	    }
	    elseif ( ! isset($rules))
	    {
	        throw new BadMethodCallException('Form_validation: set_rules() called without a $rules parameter');
	    }
	    
	    // No fields or no rules? Nothing to do...
	    if ( ! is_string($field) OR $field === '' OR empty($rules))
	    {
	        throw new RuntimeException('Form_validation: set_rules() called with an empty $rules parameter');
	    }
	    elseif ( ! is_array($rules))
	    {
	        // BC: Convert pipe-separated rules string to an array
	        if ( ! is_string($rules))
	        {
	            throw new InvalidArgumentException('Form_validation: set_rules() expect $rules to be string or array; '.gettype($rules).' given');
	        }
	        
	        $rules = preg_split('/\|(?![^\[]*\])/', $rules);
	    }
	    
	    // If the field label wasn't passed we use the field name
	    $label = ($label === '') ? $field : $label;
	    
	    $indexes = array();
	    
	    // Is the field name an array? If it is an array, we break it apart
	    // into its components so that we can fetch the corresponding POST data later
	    if (($is_array = (bool) preg_match_all('/\[(.*?)\]/', $field, $matches)) === TRUE)
	    {
	        sscanf($field, '%[^[][', $indexes[0]);
	        
	        for ($i = 0, $c = count($matches[0]); $i < $c; $i++)
	        {
	            if ($matches[1][$i] !== '')
	            {
	                $indexes[] = $matches[1][$i];
	            }
	        }
	    }
	    
	    // Build our master array
	    $this->_field_data[$field] = array(
	        'field'		=> $field,
	        'label'		=> $label,
	        'rules'		=> $rules,
	        'errors'	=> $errors,
	        'is_array'	=> $is_array,
	        'keys'		=> $indexes,
	        'postdata'	=> NULL,
	        'error'		=> ''
	    );
	    
	    return $this;
	}
}

// END validation Class

/* End of file api_validation.php */
/* Location: ./app/libraries/api_validation.php */
