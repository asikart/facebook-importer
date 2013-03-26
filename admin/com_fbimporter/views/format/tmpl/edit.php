<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'format.cancel' || document.formvalidator.isValid(document.id('format-form'))) {
			Joomla.submitform(task, document.getElementById('format-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_( JFactory::getURI()->toString() ); ?>" method="post" name="adminForm" id="format-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_FBIMPORTER_BASIC_CONTENT'); ?></legend>
			<ul class="adminformlist">

            <?php foreach( $this->form->getFieldset('information') as $form ): ?>
            <li><?php echo $form->label.' '.$form->input; ?></li>
            <?php endforeach;?>

            </ul>
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_FBIMPORTER_OTHER_SETTING'); ?></legend>
			<ul class="adminformlist">

            <?php foreach( $this->form->getFieldset('created') as $form ): ?>
            <li><?php echo $form->label.' '.$form->input; ?></li>
            <?php endforeach;?>

            </ul>
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_FBIMPORTER_CAN_BE_INSERTED_PARAMS'); ?></legend>
			<p></p>
			<p><?php echo JText::_('COM_FBIMPORTER_CLICK_AND_INSERT'); ?></p>
			<ul class="adminformlist">
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{TITLE}', 'jform_text')">{TITLE}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_ARTICLE_TITLE'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{VIDEO}', 'jform_text')">{VIDEO}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_VIDEO_NEED_ALLVIDEOS'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{INTRO_MESSAGE}', 'jform_text')">{INTRO_MESSAGE}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_ARTICLE_INTROTEXT'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{FULL_MESSAGE}', 'jform_text')">{FULL_MESSAGE}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_ARTICLE_CONTENT'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{IMAGE}', 'jform_text')">{IMAGE}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_IMAGE'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{READMORE_LINK}', 'jform_text')">{READMORE_LINK}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_FB_ORIGIN_LINK'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{LINK_URL}', 'jform_text')">{LINK_URL}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_LINK_URL'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{LINK_NAME}', 'jform_text')">{LINK_NAME}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_LINK_TITLE'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{LIKES}', 'jform_text')">{LIKES}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_FB_LIKE_COUNT'); ?>" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{CREATED_TIME}', 'jform_text')">{CREATED_TIME}</label></li><li><input class="readonly" readonly="true" value="<?php echo JText::_('COM_FBIMPORTER_FB_PUBLISH_UP_TIME'); ?>" /></li>
            </ul>
		</fieldset>
	</div>
	
	<input type="hidden" name="option" value="com_fbimporter" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>