<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die();
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

if (JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocainstall'.DS.'helpers'.DS.'phocainstall.php')) {
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocainstall'.DS.'helpers'.DS.'phocainstall.php');
} else {
	return JError::raiseError('Error', 'Helper Phoca Install file could not be found in system');
}
/*
// VM
if (JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart.cfg.php')) {
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart.cfg.php');
} else {
	return JError::raiseError('Error', 'VirtueMart Configuration file could not be found in system');
}
*/
class PhocaInstallCpControllerPhocaInstallinstall extends PhocaInstallCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'install'  , 'install' );
		$this->registerTask( 'cancel'  , 'cancel' );		
	}

	function install() {		
		
		
		$db			= &JFactory::getDBO();
		$xmlItems 	= PhocaInstallHelper::getPhocaXMLItems();
		$msg 		= array();
		
		$overwrite	= JRequest::getVar( 'overwrite_files', 0, 'post' );
		$backup		= JRequest::getVar( 'backup_files', 0, 'post' );
		$ignoreSql	= JRequest::getVar( 'ignore_sql', 0, 'post' );
		
		
		if ($ignoreSql) {
			$msg[] = '<div style="margin-left:25px;"><span style="color:#669900">'
				. JText::_('SQL Query ignored') .'</span></div>';
		} else {
			$sql = '';
			if (isset($xmlItems['psql']) && $xmlItems['psql'] != '' ) {
				$sql = $xmlItems['psql'];
			}
			
			//VM
			//$sql = str_replace('{vm}', VM_TABLEPREFIX, $sql);
			
			$sql = PhocaInstallCpControllerPhocaInstallinstall::splitSql($sql);

			$i = 1;
			foreach ($sql as $query) {
				$query = trim($query);
				if ($query != '' && $query {0} != '#') {
					$db->setQuery($query);
					if(!$db->query()) {
						$this->setError($db->getErrorMsg());
						return false;
					}
					$msg[] = '<div style="margin-left:25px;"><span style="color:#669900">'
				. JText::_('SQL Query part') .' '.$i.' '.JText::_('executed') .'</span></div>';
				}
				$i++;
			}
		}
		
		//$a = $db->loadObjectList();
		
		$files = '';
		if (isset($xmlItems['pfiles']) && $xmlItems['pfiles'] != '' ) {
			$files = $xmlItems['pfiles'];
		}
		$folders = '';
		if (isset($xmlItems['pfolders']) && $xmlItems['pfolders'] != '' ) {
			$folders = $xmlItems['pfolders'];
		}
		
		$fileFolders 	= array();
		$srcFolder 			= JPATH_ROOT . DS . 'administrator'
							. DS . 'components' . DS . 'com_phocainstall'.DS.'installfiles'. DS;
		if(!empty($folders) && is_array($folders)) {
			foreach($folders as $key => $value) {
				if (JFolder::exists($srcFolder . $value)) {
					$fileFolders[] = JFolder::files($srcFolder . $value, '.', true, true);
				}
			}
		}

		
		if(!empty($files) && is_array($files)) {
			foreach($files as $key => $value) {
				$src 		= JPATH_ROOT . DS . 'administrator'
							. DS . 'components' . DS . 'com_phocainstall'.DS.'installfiles'
							. DS . JPath::clean($value);
				$dest		= JPATH_ROOT.DS.JPath::clean($value);
				$destText	= $value;
				self::copyFiles($src, $dest, $destText, $overwrite, $backup, $msg);
			}
		}
		
		if(!empty($fileFolders) && is_array($fileFolders)) {
			foreach($fileFolders as $keyF => $valueF) {
				if(!empty($valueF) && is_array($valueF)) {
					foreach($valueF as $key => $value) {
						$src 		= JPath::clean($value);
						$destClean	= str_replace($srcFolder, '', $value);
						$dest		= JPATH_ROOT.DS.JPath::clean($destClean);
						$destText	= str_replace(DS, '/', $destClean);
						self::copyFiles($src, $dest, $destText, $overwrite, $backup, $msg);
					}
				}
			}
		}
		
		$link = 'index.php?option=com_phocainstall';
		
		// Remove install files from transfer folder (possible problem with other Phoca Install instance)
		if (JFolder::exists($srcFolder)) {
			JFolder::delete($srcFolder);
		} 
		
		$this->setRedirect($link,  implode('<br />', $msg));		
		
	}
	
	function copyFiles($src, $dest, $destText, $overwrite, $backup, &$msg) {
		if (JFile::exists($src)) {
			if (JFile::exists($dest)) {
				if($overwrite) {
					if($backup) {
					
						// Backup php to php
						$pos = stripos($dest, '.php');
						if ($pos !== false) {
							$destBak 		= str_replace('.php', '.bak.php', $dest);
							$destBakText	 = str_replace('.php', '.bak.php', $destText);
						} else {
							$destBak 		= $dest . '.bak';
							$destBakText	= $destText . '.bak';
						}
						
						if(JFile::copy($dest, $destBak)) {
							$msg[] = '<div style="margin-left:25px;">'
							. JText::_('File') . ': ' . $destText
							. ' <span style="color:#669900">'. JText::_('file was backed up to').'</span>: </div>'
							. '<div style="margin:0;padding:0;margin-left:50px;">- '.$destBakText. '</div>';
						} else {
							$msg[] = '<div style="margin-left:25px;">'
							. JText::_('File') . ': ' . $destText
							. ' <span style="color:#cc0000">'. JText::_('could not be backed up to').'</span>: </div>'
							. '<div style="margin:0;padding:0;margin-left:50px;">- '.$destBakText. '</div>';
						}
					}
				
					if(JFile::copy($src, $dest)) {
						$msg[] = '<div style="margin-left:25px;">'
						. JText::_('File') . ': ' . $destText
						. ' <span style="color:#ff9900">'. JText::_('copied and existing file overwritten')
						. '</span></div>';
					} else {
						$msg[] = '<div style="margin-left:25px;">'
						. JText::_('File') . ': ' . $destText
						. ' <span style="color:#cc0000">'. JText::_('not copied') . '</span></div>';
					}
				} else {
					$msg[] = '<div style="margin-left:25px;">'
					. JText::_('File') . ': ' . $destText
					. ' <span style="color:#669900">'. JText::_('overwriting ignored'). '</span></div>';
				}
			} else {
				if(JFile::copy($src, $dest)) {
					$msg[] = '<div style="margin-left:25px;">'
					. JText::_('File') . ': ' . $destText
					. ' <span style="color:#669900">'. JText::_('copied'). '</span></div>';
				} else {
					$msg[] = '<div style="margin-left:25px;">'
					. JText::_('File') . ': ' . $destText
					. ' <span style="color:#cc0000">'. JText::_('not copied') . '</span></div>';
				}
			}
		}
		return true;
	}

	function cancel() {
		$msg = JText::_( 'Installation was cancelled' );
		$link = 'index.php?option=com_phocainstall';
		$this->setRedirect($link, $msg);
	}
	
	function splitSql($sql)
	{
		$sql = trim($sql);
		$sql = preg_replace("/\n\#[^\n]*/", '', "\n".$sql);
		$buffer = array ();
		$ret = array ();
		$in_string = false;

		for ($i = 0; $i < strlen($sql) - 1; $i ++) {
			if ($sql[$i] == ";" && !$in_string)
			{
				$ret[] = substr($sql, 0, $i);
				$sql = substr($sql, $i +1);
				$i = 0;
			}

			if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\")
			{
				$in_string = false;
			}
			elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\"))
			{
				$in_string = $sql[$i];
			}
			if (isset ($buffer[1]))
			{
				$buffer[0] = $buffer[1];
			}
			$buffer[1] = $sql[$i];
		}

		if (!empty ($sql))
		{
			$ret[] = $sql;
		}
		return ($ret);
	}
	
}
// utf-8 test: ä,ö,ü,ř,ž
?>