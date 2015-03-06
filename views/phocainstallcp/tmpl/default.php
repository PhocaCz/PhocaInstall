<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">

<div id="j-sidebar-container" class="span2"><?php echo JHtmlSidebar::render(); ?></div>

<div id="j-main-container" class="span10">
	<div class="adminform">
		<div class="ph-cpanel-left">
			<div id="cpanel">
				<div class="alert alert-block alert-error ph-w80">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<p>This component is used only for a single installation of special addons. It is not necessary to have it remain active in the Joomla! system. For security reasons, please <strong>uninstall it</strong> in:</p>
					<p style="text-align:right;font-size:normal"><a style="text-decoration:underline;" href="index.php?option=com_installer">Extensions - Install/Uninstall - Components</a></p>
				</div>
				
				<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="color: #c0c0c0;">		
<a href="http://www.phoca.cz/phocainstall/" target="_blank">Phoca Install Main Site</a><br />
<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca Install User Manual</a><br />
<a href="http://www.phoca.cz/forum/" target="_blank">Phoca Install Forum</a><br />
<a href="http://www.phoca.cz/" target="_blank">Phoca.cz</a>
</p>
			</div>
		</div>
	
		<div class="ph-cpanel-right">
			<div class="well">
				<div style="float:right;margin:10px;"><?php echo JHTML::_('image', $this->t['i'] . 'logo-phoca.png', 'Phoca.cz' );?></div><?php

echo '<h3>'.  JText::_($this->t['l'] . '_COPYRIGHT').'</h3>'
.'<p>© 2007 - '.  date("Y"). ' Jan Pavelka</p>'
.'<p><a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>';
echo '<h3>'.  JText::_($this->t['l'] . '_LICENCE').'</h3>'
.'<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>';

			?></div>
		</div>
	</div>
	<input type="hidden" name="option" value="<?php echo $this->t['c'] ?>" />
	<input type="hidden" name="view" value="<?php echo $this->t['c'] ?>cp" />
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>

<?php /*

<form action="index.php" method="post" name="adminForm">
<div class="adminform">
<div class="cpanel-left">
	<div id="cpanel">
		
		<div style="margin:10px;font-size:large;margin:15px;padding:15px;float:right; color: #D35061;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;background: #F1CAD0; border: 3px solid #D35061">
		<p>This component is used only for a single installation of special addons. It is not necessary to have it remain active in the Joomla! system. For security reasons, please <strong>uninstall it</strong> in:</p>
		<p style="text-align:right;font-size:normal"><a style="text-decoration:underline;" href="index.php?option=com_installer">Extensions - Install/Uninstall - Components</a><p>
		</div>
				
		<div style="clear:both">&nbsp;</div>
		<p>&nbsp;</p>
		<div style="text-align:center;padding:0;margin:0;border:0;">
			<iframe style="padding:0;margin:0;border:0" src="http://www.phoca.cz/adv/phocainstall" noresize="noresize" frameborder="0" border="0" cellspacing="0" scrolling="no" width="500" marginwidth="0" marginheight="0" height="125">
			<a href="http://www.phoca.cz/adv/phocainstall" target="_blank">Phoca Install</a>
			</iframe>
		</div>
	</div>
</div>
		
<div class="cpanel-right">
	<div style="border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
		<div style="float:right;margin:10px;">
			<?php echo JHTML::_('image', 'administrator/components/com_phocainstall/assets/images/icon-logo-seal.png', 'Phoca.cz' );?>
		</div>
			
		<?php

		echo '<h3>'.  JText::_('Copyright').'</h3>'
		.'<p>© 2007 - '.  date("Y"). ' Jan Pavelka</p>'
		.'<p><a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>';

		echo '<h3>'.  JText::_('License').'</h3>'
		.'<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>';
		
		echo '<p>&nbsp;</p>';
		?>
		
	</div>
</div>

<div style="clear:both"></div>

</div>

<input type="hidden" name="option" value="com_phocainstall" />
<input type="hidden" name="view" value="phocainstallcp" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>

*/ ?>