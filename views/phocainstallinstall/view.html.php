<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die();
jimport( 'joomla.application.component.view' );
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
class PhocaInstallCpViewPhocaInstallInstall extends JViewLegacy
{
	public function display($tpl = null) {
		JHTML::stylesheet( 'media/com_phocainstall/css/administrator/phocainstall.css' );
		$this->addToolbar();
		parent::display($tpl);
	}
	
	protected function addToolbar() {
		JToolBarHelper::title( JText::_( 'COM_PHOCAINSTALL_PHOCAINSTALL' ), 'install.png' );
		JToolBarHelper::divider();
		
		$bar = & JToolBar::getInstance( 'toolbar' );
		$dhtml = '<a href="index.php?option=com_phocainstall" class="btn btn-small"><i class="icon-home" title="'.JText::_('COM_PHOCAINSTALL_CONTROL_PANEL').'"></i> '.JText::_('COM_PHOCAINSTALL_CONTROL_PANEL').'</a>';
		$bar->appendButton('Custom', $dhtml);
		
		JToolBarHelper::help( 'screen.phocainstall', true );
	}
}
?>