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
JHtml::_('behavior.multiselect');

$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_fbimporter');
$saveOrder	= $listOrder == 'a.ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_fbimporter&view=items'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="import-num-lbl" for="import_num">快取數量</label>
			<?php echo JHtml::_('select.integerlist', 50, 1000, 50 , 'import_num', array('onchange'=>"Joomla.submitbutton('items.refresh')"), $this->state->get('import_num') ); ?>
			
		</div>
		
		<!--<div class="filter-select fltrt">
                <select name="filter_published" class="inputbox" onchange="this.form.submit()">
                    <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
                    <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true);?>
                </select>
		</div>-->
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
				<th width="3%">圖片</th>
				<th width="8%">時間</th>
				<th width="14%">分類</th>
				<th width="20%">標題</th>
				<th>敘述</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php //echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		$params = $this->state->get('params') ;
		$i = 0 ;
		
		JLoader::import( 'models.fields.format' , FBIMPORTER_ADMIN) ;
		
		foreach ($this->items as $item ) :
			if( $item->continue ) continue ;
			
			// get format form
			$format_form = new JFormFieldFormat() ;
			$format_form->value = $params->get('format');
			
			$likes = isset($item->likes->count) ? $item->likes->count : 0;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center" style="padding: 0;">
					<input style="width:100%; height:100%; <?php echo $item->exists ? 'visibility: hidden ;' : null; ?>" type="checkbox" id="cb<?php echo $i; ?>" <?php echo $item->exists ? 'disabled="true"' : null; ?>
							name="cid[<?php echo $item->likes->count; ?>]" value="<?php echo $item->id; ?>" onclick="Joomla.isChecked(this.checked);" title="行 <?php echo $i + 1 ; ?> 的勾選盒" />
				</td>
				<td class="center">
					<a target="_blank" href="http://www.facebook.com/<?php echo $params->get('fb_uid'); ?>/posts/<?php echo $item->id; ?>">
						<img src="<?php echo $item->get('picture', 'components/com_fbimporter/images/facebook-default.png'); ?>" style="max-width:150px;max-height: 150px;" onerror="this.src='components/com_fbimporter/images/facebook-default.png';" alt="<?php echo $item->get('title'); ?>" />
					</a>
				</td>
				<td class="center">
					<p>
						<?php echo $item->date->format('Y-m-d') ; ?>
						<br />
						<?php echo $item->date->format('H:i:s') ; ?>
						(<?php echo $item->date->format('D'); ?>)	
					</p>
					<p>
						讚： <span style="color: blue;"><?php echo $likes; ?></span>
						<br />
						類型：<span style="color: red;"><?php echo $item->get('type'); ?></span>
					</p>
					<p>
						<a target="_blank" href="http://www.facebook.com/<?php echo $params->get('fb_uid'); ?>/posts/<?php echo $item->id; ?>">[原始連結]</a>
					</p>
				</td>
				<td align="">
					<?php if( !$item->exists ): ?>
						<?php if( $item->catid && !$params->get('select_category_when_exists', 1) ): ?>
							<?php echo $item->cat_name; ?>
							<input type="hidden" name="item[<?php echo $item->id; ?>][catid]" 	value="<?php echo $item->catid; ?>" />
						<?php else: ?>
							<?php
							if(!$item->catid){
								$item->catid = $params->get('catid') ;
							}
							echo JHtml::_('list.category', "item[{$item->id}][catid]", 'com_content', $item->catid);
							?>
						<?php endif; ?>
						
						<?php if( $params->get('can_select_format', 0) ): ?>
							
							<br />
							<br /><hr />
							選擇格式：
							<?php
							$format_form->name = "item[{$item->id}][format]" ;
							echo $format_form->input ;
							?>						
						<?php endif; ?>
					<?php else: ?>
						<div align="center" style="color:#C00;">(已匯入)</div>
					<?php endif; ?>
				</td>
				<td>
					<?php if( $item->exists ): ?>
						<h3><?php echo $item->title; ?></h3>
					<?php else: ?>
						<textarea type="text" name="item[<?php echo $item->id; ?>][title]" style="width:100%;height:100px;"><?php echo $item->get('title'); ?></textarea>
					<?php endif; ?>
				</td>
				<td>
					<?php if( !$item->exists ): ?>
					<textarea name="item[<?php echo $item->id; ?>][message]" style="width:100%;height:100px;"><?php
						$item->message = str_replace( '<br />' , '' , $item->message ) ;
						//$item->message = str_replace( "\t" , '1' , $item->message ) ;
						echo trim($item->message) ;
					?></textarea>
					<?php else: ?>
						<?php echo trim($item->message); ?>
					<?php endif; ?>
					<input type="hidden" name="item[<?php echo $item->id; ?>][type]" 	value="<?php echo $item->get('type'); ?>" />
					<input type="hidden" name="item[<?php echo $item->id; ?>][name]" 	value="<?php echo $item->get('name'); ?>" />
					<input type="hidden" name="item[<?php echo $item->id; ?>][picture]" value="<?php echo base64_encode($item->get('picture')); ?>" />
					<input type="hidden" name="item[<?php echo $item->id; ?>][link]" 	value="<?php echo base64_encode($item->get('link')); ?>" />
					<input type="hidden" name="item[<?php echo $item->id; ?>][source]" 	value="<?php echo base64_encode($item->get('source')); ?>" />
					<input type="hidden" name="item[<?php echo $item->id; ?>][likes]" 	value="<?php echo $likes; ?>" />
					<input type="hidden" name="item[<?php echo $item->id; ?>][created]" value="<?php echo $item->get('created_time'); ?>" />
				</td>
			</tr>
			<?php $i++; ?>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<p></p>
<p align="center"><?php echo JText::_('COM_FBIMPORTER_COPY_RIGHT'); ?></p>