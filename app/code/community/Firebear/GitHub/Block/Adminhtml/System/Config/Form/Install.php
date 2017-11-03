<?php
/**
 * Firebear GitHub Connect Module
 *
 * @category    Firebear
 * @package     Firebear_GitHub
 * @copyright   Copyright (c) 2014 Firebear
 * @author      biotech (Hlupko Viktor)
 */

/**
 *
 *
 * @category    Firebear
 * @package     Firebear_GitHub
 */
 
class Firebear_GitHub_Block_Adminhtml_System_Config_Form_Install extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('firebear/github/system/config/install.phtml');
    }
 
    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }
 
    /**
     * Generate button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
            'id'        => 'github_button',
            'label'     => $this->helper('adminhtml')->__('Install extension'),
            'onclick'   => 'javascript:check(); return false;'
        ));
 
        return $button->toHtml();
    }

}