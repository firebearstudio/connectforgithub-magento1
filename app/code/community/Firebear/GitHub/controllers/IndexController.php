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
 
class Firebear_GitHub_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction(){
 
		Mage::helper('github')->GitInstall('https://github.com/GordonLesti/Lesti_Fpc');
		//Mage::helper('github')->listFolderFiles('/var/github/Lesti_Fpc-master');
				
		
	}
		
}		
?>