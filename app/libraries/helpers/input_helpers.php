<?php

/**
 * Convert a string input[sample][0][data] to input.sample.0.data
 *
 * @param $string
 * @return mixed
 */
function to_dot_string($string)
{
    if (strpos($string,'['))
    {
        $string = str_replace('[]','.',$string); // name[0.name]
        $string = str_replace('[','.',$string); // name.0.name]
        $string = str_replace(']','',$string); // name.0.name
    }

    return $string;
}

/**
 * Get error's class and message, if found then return
 * the class and message, else return class and message with
 * a null values
 *
 * @param string            $input_name - Input name
 * @param MessageBag        $errors
 * @param array             $options
 * @return array
 */
function get_error($input_name, $errors, array $options = array())
{
    // Available options that the system can use
    $default = array(
        'error_prefix'      => '<p class="help-block"><i class="fa fa-exclamation-triangle "></i> ',
        'error_suffix'      => '</p>',
        'error_class'       => 'has-error'
    );

    // Override options
    $options = array_merge($default,$options);

    // note that laravel use dot notation to access array
    $input_name = to_dot_string($input_name);

    if($errors->has($input_name))
    {
        return array(
            $options['error_prefix']  . $errors->first($input_name) . $options['error_suffix'],
            $options['error_class']
        );
    }
    else
    {
        return array(
            NULL,
            NULL
        );
    }
}

function input_generate_id($input_name = null)
{
    $prefix = "input_";

    if ( ! $input_name)
    {
        return NULL;
    }
    else
    {
        return $prefix . $input_name;
    }
}


/**
 * This will just echo select attribute in html element if two given
 *
 * @param $value1           - the dynamic value (usually from the database)/ or the value that should be selected
 * @param $value2           - the select or radio actual value
 * @param $old_input        - If old input is specified
 * @return null|string
 */
function is_selected($value1,$value2,$old_input = false)
{
    // Override value 1
    if ( ! empty($old_input) || $old_input != "")
    {
        $value1 = $old_input;
    }

    if( $value1 == $value2)
    {
        return 'selected="selected"';
    }
    else
    {
        return NULL;
    }
}

/**
 * Return disabled word if two specified value is equal
 *
 * @param $val1
 * @return string
 */
function is_disabled($val1 = false)
{
    return $val1 ? " disabled " : "";
}

/**
 * @param $value1 - Array|String
 * @param $value2 - String
 * @param bool $old_input - Array|String
 * @return null|string
 */
function is_checked($value1,$value2,$old_input = false)
{
    // Override value 1
    if ( ! empty($old_input) || $old_input != "")
    {
        $value1 = $old_input;
    }

    $checked = ' checked="checked" ';

    if ( ! is_array($value1))
    {
        // We need to be string here. We need to convert all the types (except object and array)
        // to string, so we can make sure that we are doing a real condition.
        $value1 = (string) $value1;
        $value2 = (string) $value2;

        return  ($value1 === $value2) ? $checked : NULL;
    }
    else
    {
        return in_array($value2,$value1) ? $checked : NULL;
    }

}
