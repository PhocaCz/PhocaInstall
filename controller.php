<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
jimport('joomla.application.component.controller');

$app 	= JFactory::getApplication();
$view	= $app->input->get('view', '', 'string');
if ($view == '' || $view == 'phocainstallcp') {
	JHtmlSidebar::addEntry(JText::_('Phoca Install'), 'index.php?option=com_phocainstall', true);
}


class PhocaInstallCpController extends JControllerLegacy {
	function display() {
		parent::display();
	}
}
?>
