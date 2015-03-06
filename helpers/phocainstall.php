<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

class PhocaInstallHelper
{	
	function getPhocaXMLItems()
	{
		$folder = JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_phocainstall';
		if (JFolder::exists($folder)) {
			$xmlFilesInDir = JFolder::files($folder, '.xml$');
		} else {
			$folder = JPATH_SITE .DS. 'components'.DS.'com_phocainstall';
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$xmlFilesInDir = null;
			}
		}

		$data = array();
		if (count($xmlFilesInDir))
		{
			foreach ($xmlFilesInDir as $xmlfile)
			{				
				
				if ($xmlfile == 'phocainstall.xml') {
					$xml	= JFactory::getXML($folder.DS.$xmlfile, true);
					
					if (!$xml) {
						unset ($xml);
						return null;
					}
					
					if (!is_object($xml) || ($xml->name() != 'extension' )) {
						unset ($xml);
						return null;
					}
					
					$element = & $xml->children()->pinstructions;
					
					$data['pinstructions'] = $element ? (string)$element : '';
					$element = & $xml->children()->psql;
					$data['psql'] = $element ? (string)$element : '';
					
					
					$dataFolders = array();
					$f = $xml->children()->pfiles->children();
					
					if(isset($f)) {
						
						foreach ($f as $key => $value) {
							
							if($key == 'folder') {
							
								if ((string)$value != '') {
									$dFo = (string)$value;
									if (isset($dFo)) {	
										$dataFolders[] = $dFo;
									}
									
								}
							}
						}
					}
					$data['pfolders'] = $dataFolders;
					
					$dataFiles = array();
					if(isset($f)) {
						foreach ($f as $key => $value) {
							
							if($key == 'filename') {
								
								if ((string)$value != '') {
									$dFi = (string)$value;
									if (isset($dFi)) {	
										$dataFiles[] = $dFi;
									}
									
								}
							}
						}
					}
					
					$data['pfiles'] = $dataFiles;
					
				}
			}
		}
	
		return $data;
	}
}
?>