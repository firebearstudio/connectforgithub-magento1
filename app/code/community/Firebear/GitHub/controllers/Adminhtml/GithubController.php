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

class Firebear_GitHub_Adminhtml_GithubController extends Mage_Adminhtml_Controller_Action
{

    public function installAction()
    {
        $url = $this->getRequest()->getPost("git_url");
        
		$result = Mage::helper('github')->GitInstall($url);

    	Mage::app()->getResponse()->setBody(1);
    	
    }
    
}