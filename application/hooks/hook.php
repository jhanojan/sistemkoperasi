<?php
class hook {
    function Mzhook(){
         $CI =& get_instance();
         $buffer = $CI->output->get_output();  
          
         $search = array(
            '/\>[^\S ]+/s', 
            '/[^\S ]+\#s/');
             
         $replace = array(
            '>',
            '<',
            '\\1',
            "//<![CDATA[\n".'\1'."\n//]]>");
             
         $bufferz = preg_replace($search, $replace, $buffer);
         $CI->output->set_output($bufferz);
         $CI->output->_display();
    }
}
?>