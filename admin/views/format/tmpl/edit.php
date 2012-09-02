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
			<legend><?php echo '基本內容'; ?></legend>
			<ul class="adminformlist">

            <?php foreach( $this->form->getFieldset('information') as $form ): ?>
            <li><?php echo $form->label.' '.$form->input; ?></li>
            <?php endforeach;?>

            </ul>
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend><?php echo '其他設定'; ?></legend>
			<ul class="adminformlist">

            <?php foreach( $this->form->getFieldset('created') as $form ): ?>
            <li><?php echo $form->label.' '.$form->input; ?></li>
            <?php endforeach;?>

            </ul>
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend>可插入參數</legend>
			<p></p>
			<p>點擊後直接插入文章</p>
			<ul class="adminformlist">
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{TITLE}', 'jform_text')">{TITLE}</label></li><li><input class="readonly" readonly="true" value="文章標題" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{VIDEO}', 'jform_text')">{VIDEO}</label></li><li><input class="readonly" readonly="true" value="影片（需結合Allvideos）" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{INTRO_MESSAGE}', 'jform_text')">{INTRO_MESSAGE}</label></li><li><input class="readonly" readonly="true" value="文章摘要" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{FULL_MESSAGE}', 'jform_text')">{FULL_MESSAGE}</label></li><li><input class="readonly" readonly="true" value="文章內文" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{IMAGE}', 'jform_text')">{IMAGE}</label></li><li><input class="readonly" readonly="true" value="圖片" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{READMORE_LINK}', 'jform_text')">{READMORE_LINK}</label></li><li><input class="readonly" readonly="true" value="連回Facebook原文的連結" /></li>
				<li><label style="cursor: pointer;" onclick="jInsertEditorText('{LINK_NAME}', 'jform_text')">{LINK_NAME}</label></li><li><input class="readonly" readonly="true" value="分享連結、影片等的標題" /></li>
            </ul>
		</fieldset>
	</div>
	
	<input type="hidden" name="option" value="com_fbimporter" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>