<?php
/**
 * Firebear GitHub Connect Module
 *
 * @category    Firebear
 * @package     Firebear_GitHub
 * @copyright   Copyright (c) 2013 Firebear
 * @author      biotech (Hlupko Viktor)
 */

/**
 *
 *
 * @category    Firebear
 * @package     Firebear_GitHub
 */
class Firebear_GitHub_Helper_Data extends Mage_Core_Helper_Abstract
{
	
			/* helper functions */
		function GitInstall($repo){	
		
			if (!strstr(mb_substr($repo, -1),'/')){
				$repo .= "/";
			}
			
			$url = $repo.'archive/master.zip';
			
			$parts = explode('/', $url);
			
			$repo_author = $parts[3];
			
			/*if (strstr($repo_author, "magento")){
				if (!strstr($repo_author, "magento-hackathon")){
					Mage::getSingleton('adminhtml/session')->addError("Here is no Magento extension in this repository!");
					return false;
				}
			}*/
			
			$repo_name = $parts[4];
			
			$var = Mage::getBaseDir().'/var/github';
			
			if (!file_exists(Mage::getBaseDir().'/var/github')){
				mkdir($var, 0777);
			}
			
			$file = $var.'/'.$repo_name.'.zip';
			
			//echo $repo_author.'/'.$repo_name; die();
			
			
			//echo file_get_contents($outputfile);
			
			ini_set("allow_url_fopen", 1);
			
			//file_put_contents($file, fopen($url, 'r'));
			
			/* Download branch master of repo in zip */
			
			set_time_limit(0);
			$fp = fopen ($file, 'w+');//This is the file where we save the    information
			$ch = curl_init(str_replace(" ","%20",$url));//Here is the file we are downloading, replace spaces with %20
			curl_setopt($ch, CURLOPT_TIMEOUT, 50);
			curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_exec($ch); // get curl response
			curl_close($ch);
			fclose($fp);
			
			
			//file_put_contents($file, file_get_contents($url)); // var/github folder should exist before!!!	
			
			

			$app_patch = Mage::getBaseDir().'/'; // get magento root folder here!
			$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
			$folder = $repo_name."-master";
			$orig_content = $path.'/'.$folder;
			
			//echo $orig_content;
			
			//echo $path; die();
			
			$zip = new ZipArchive;
			$res = $zip->open($file);
			
			if ($res === TRUE) 
			{
			  
			  $zip->extractTo($path);
			  $zip->close();
			  //echo "WOOT! $file extracted to $path <br />";
			  
			  
			  //print_r(Mage::helper('github')->listFolderFiles($orig_content));
			 
			  //die();
			
			} else {
			  Mage::getSingleton('adminhtml/session')->addError("Error in extension unzip, please check folder access permissions!");
			  return false;
			  //echo "Doh! I couldn't open $file <br />";
			
			}

			//die();
			//echo get_class($zip)
			
			//die();
			/* debug */
			/*echo $orig;
			echo '<br />';
			echo $path;
			echo '<br />';
			echo $file;*/
			
			//echo $orig_content;
			
			if (file_exists($orig_content.'/app') || file_exists($orig_content.'/src')){
				
				if (file_exists($orig_content.'/src')){
					$orig_content .= '/src';
				}
				
				/*if (Mage::helper('github')->modmanCopy($orig_content, $orig_content)){
					$modman = true;
				}else{
					$modman = false;
				}*/	
				
				/* install */				
				
				//if (shell_exec("rsync -aizP --exclude '.gitattributes' --exclude 'LICENSE' --exclude 'MIT-LICENSE.txt' --exclude 'LICENSE_OSL.txt' --exclude '.gitignore' --exclude 'README.md' --exclude 'composer.json' $orig_content/* $app_patch/")){
					//echo $repo_author.'_'.$repo_name.' be installed';
					
					if (file_exists($orig_content."/.gitattributes")) unlink($orig_content."/.gitattributes");
					if (file_exists($orig_content."/LICENSE")) unlink($orig_content."/LICENSE");
					if (file_exists($orig_content."/MIT-LICENSE.txt")) unlink($orig_content."/MIT-LICENSE.txt");
					if (file_exists($orig_content."/LICENSE_OSL.txt.md")) unlink($orig_content."/LICENSE_OSL.txt.md");
					if (file_exists($orig_content."/.gitignore")) unlink($orig_content."/.gitignore");
					if (file_exists($orig_content."/composer.json")) unlink($orig_content."/composer.json");
					if (file_exists($orig_content."/modman")) unlink($orig_content."/modman");
					if (file_exists($orig_content."/README.md")) unlink($orig_content."/README.md");
					
					
					//echo $app_patch;
					//die();
					
					$owner = fileowner($app_patch."app");
					chown($app_patch."app", "nobody"); 
					
					chmod($app_patch."app", 0777);
					chmod($app_patch."app/etc/modules", 0777);
					chmod($app_patch."app/code/community", 0777);
					chmod($app_patch."app/code/local", 0777);
					chmod($app_patch."app/design/frontend", 0777);
					chmod($app_patch."app/design/frontend/base", 0777);
					chmod($app_patch."app/design/frontend/base/default", 0777);
					chmod($app_patch."app/design/frontend/base/default/etc", 0777);
					chmod($app_patch."app/design/frontend/base/default/layout", 0777);
					chmod($app_patch."app/design/frontend/base/default/template", 0777);
					chmod($app_patch."app/design/frontend/base/default/locale", 0777);
					chmod($app_patch."app/design/frontend/default", 0777);
					chmod($app_patch."app/design/frontend/default/default", 0777);
					chmod($app_patch."app/design/frontend/default/default/etc", 0777);
					chmod($app_patch."app/design/frontend/default/default/layout", 0777);
					chmod($app_patch."app/design/frontend/default/default/template", 0777);
					chmod($app_patch."app/design/frontend/default/default/locale", 0777);
					chmod($app_patch."app/design/adminhtml", 0777);
					chmod($app_patch."app/design/adminhtml/default", 0777);
					chmod($app_patch."app/design/adminhtml/default/default", 0777);
					chmod($app_patch."app/design/adminhtml/default/default/etc", 0777);
					chmod($app_patch."app/design/adminhtml/default/default/layout", 0777);
					chmod($app_patch."app/design/adminhtml/default/default/template", 0777);
					chmod($app_patch."app/design/adminhtml/default/default/locale", 0777);
					chmod($app_patch."skin/frontend", 0777);
					chmod($app_patch."skin/frontend", 0777);
					chmod($app_patch."skin/adminhtml", 0777);
					chmod($app_patch."lib", 0777);
					chmod($app_patch."js", 0777);
					
					Mage::helper('github')->cpy($orig_content."/", $app_patch); 
					
					Mage::getSingleton('adminhtml/session')->addSuccess('Extension <b>'.$repo_author.'_'.$repo_name. '</b> installed!');
					
					//echo $orig_content.'/modman'; echo '<br />';
					//echo $orig_content.'app/etc/uninstall.txt'; die();
					
					/*if ($modman){
						Mage::getSingleton('adminhtml/session')->addSuccess('This extension can be fully and safe deleted with MageTrashApp.');
					}else{
						Mage::getSingleton('adminhtml/session')->addSuccess('This extension not can be deleted with MageTrashApp, because here is no modman file.');
					}*/
					
					 try {
					    $allTypes = Mage::app()->useCache();
					    foreach($allTypes as $type => $blah) {
					      Mage::app()->getCacheInstance()->cleanType($type);
					    }
					    Mage::getSingleton('adminhtml/session')->addSuccess('Magento cache cleaned.'); 
					 } catch (Exception $e) {
					    error_log($e->getMessage());
					 }
					 
					 Mage::getSingleton('adminhtml/session')->addSuccess('Please <a href="'.Mage::helper('adminhtml')->getUrl('/index/logout').'">log out</a> from Magento admin and then log in back for work with new extension!');
					 
					chown($app_patch."app", $owner);
					 
					chmod($app_patch."app", 0755);
					chmod($app_patch."app/etc/modules", 0755);
					chmod($app_patch."app/code/community", 0755);
					chmod($app_patch."app/code/local", 0755);
					chmod($app_patch."app/design/frontend", 0755);
					chmod($app_patch."app/design/frontend/base", 0755);
					chmod($app_patch."app/design/frontend/base/default", 0755);
					chmod($app_patch."app/design/frontend/base/default/etc", 0755);
					chmod($app_patch."app/design/frontend/base/default/layout", 0755);
					chmod($app_patch."app/design/frontend/base/default/template", 0755);
					chmod($app_patch."app/design/frontend/base/default/locale", 0755);
					chmod($app_patch."app/design/frontend/default", 0755);
					chmod($app_patch."app/design/frontend/default/default", 0755);
					chmod($app_patch."app/design/frontend/default/default/etc", 0755);
					chmod($app_patch."app/design/frontend/default/default/layout", 0755);
					chmod($app_patch."app/design/frontend/default/default/template", 0755);
					chmod($app_patch."app/design/frontend/default/default/locale", 0755);
					chmod($app_patch."app/design/adminhtml", 0755);
					chmod($app_patch."app/design/adminhtml/default", 0755);
					chmod($app_patch."app/design/adminhtml/default/default", 0755);
					chmod($app_patch."app/design/adminhtml/default/default/etc", 0755);
					chmod($app_patch."app/design/adminhtml/default/default/layout", 0755);
					chmod($app_patch."app/design/adminhtml/default/default/template", 0755);
					chmod($app_patch."app/design/adminhtml/default/default/locale", 0755);
					chmod($app_patch."skin/frontend", 0755);
					chmod($app_patch."skin/frontend", 0755);
					chmod($app_patch."skin/adminhtml", 0755);
					chmod($app_patch."lib", 0755);
					chmod($app_patch."js", 0755);

					return true;	
					
			}else{
				Mage::getSingleton('adminhtml/session')->addError("Here is no Magento extension in this repository!");
				return false;
			}
			
		}        


	public function modmanCopy($dir, $orig_content){
	 
	 	$dir .= '/';
	    
	    $ffs = scandir($dir);

	    $i = 0;
	    $list = array();
	    
	    $app = '';
	    $path='';
	 
	    foreach ( $ffs as $ff ){
	        if ( $ff != '.' && $ff != '..' ){
	                    $list[] = $ff;
							if (strstr("config.xml", $ff)){
								
								$path = $dir;

								Mage::helper('github')->modmanCopyAction($orig_content, $path);
							}		
	            if( is_dir($dir.'/'.$ff) ) 
	                Mage::helper('github')->modmanCopy($dir.'/'.$ff, $orig_content);
	        }
	    }
	    return $list;
	}
	
	
	public function modmanCopyAction($orig_content, $path){
	
		//echo $path;
		//echo $orig_content.'/modman';
		//echo "<br />";
		//echo $path.'/uninstall.txt';
		
		if (copy($orig_content.'/modman', $path.'/uninstall.txt')){
			return true;
		}else{
			return false;	
		}
		//echo $path;
	}
	
	public function cpy($source, $dest){
	
			// 777 make for app, skin, lib ... and then back to 755
	
		    if(is_dir($source)) {
		        $dir_handle=opendir($source);
		        while($file=readdir($dir_handle)){
		            if($file!="." && $file!=".."){
		                if(is_dir($source."/".$file)){
		                    mkdir($dest."/".$file);
		                    Mage::helper('github')->cpy($source."/".$file, $dest."/".$file);
		                } else {
		                    if (!copy(str_replace("///", "/", $source."/".$file), str_replace("///", "/", $dest."/".$file))){
			                    Mage::getSingleton('adminhtml/session')->addError("Error in extension install process, please check folders permissions!");
		                    }
		                }
		            }
		        }
		        closedir($dir_handle);
		    } else {
		        copy($source, $dest);
		    }
		}
	
	
	
			
}