<?php

namespace common;

use common\common__view;

/**
 * Some common definitios
 *
 * @author Xavier Piquer
 */
class common extends common__view
{
    public function __construct()
    {
        
    }
    
    public function getJS()
    {
        $res = $this->uniqueID();
        // $res .= $this->daterangeVType();
        $res .= $this->passwordVType();
        
        return $res;
    }
}
