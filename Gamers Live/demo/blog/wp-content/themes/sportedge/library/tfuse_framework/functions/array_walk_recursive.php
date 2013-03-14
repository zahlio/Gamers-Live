<?php

function tfuse_array_walk_recursive(&$input, $funcname, $userdata = '') {
  if(!function_exists('array_walk_recursive')) {
    if(!is_callable($funcname))
      return false;

    if(!is_array($input))
      return false;

    foreach($input as $key=>$value) {
      if(is_array($input[$key])) {
        if(isset($this)) {
          eval('$this->' . __FUNCTION__ . '($input[$key], $funcname, $userdata);');
        } else {
          if(@get_class($this))
            eval(get_class() . '::' . __FUNCTION__ . '($input[$key], $funcname, $userdata);');
          else
            eval(__FUNCTION__ . '($input[$key], $funcname, $userdata);');
        }
      } else {
        $saved_value = $value;

        if(is_array($funcname)) {
          $f = '';
          for($a=0; $a<count($funcname); $a++)
            if(is_object($funcname[$a])) {
              $f .= get_class($funcname[$a]);
            } else {
              if($a > 0)
                $f .= '::';
              $f .= $funcname[$a];
            }
          $f .= '($value, $key' . (!empty($userdata) ? ', $userdata' : '') . ');';
          eval($f);
        } else {
          if(!empty($userdata))
            $funcname($value, $key, $userdata);
          else
            $funcname($value, $key);
        }

        if($value != $saved_value)
          $input[$key] = $value;
      }
    }
    return true;
  } else {
    array_walk_recursive($input, $funcname, $userdata);
  }
}

?>