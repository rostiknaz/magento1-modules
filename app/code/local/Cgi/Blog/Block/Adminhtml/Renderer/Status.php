<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 27.07.16
 * Time: 11:40
 */
class Cgi_Blog_Block_Adminhtml_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        return $row->getStatus() ? 'Enabled' : 'Disabled';
    }
}