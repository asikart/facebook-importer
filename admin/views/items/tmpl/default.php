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
FMHelper::_('include.core');



// Init some API objects
// ================================================================================
$app 	= JFactory::getApplication() ;
$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
$doc 	= JFactory::getDocument();
$uri 	= JFactory::getURI() ;
$user	= JFactory::getUser();
$userId	= $user->get('id');



// List Control
// ================================================================================
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$originalOrders = array();


// For Joomla!3.0
// ================================================================================
if( JVERSION >= 3 ) {
	JHtml::_('bootstrap.tooltip');
	JHtml::_('dropdown.init');
	JHtml::_('formbehavior.chosen', 'select');

}else{
	
}
?>
<form action="<?php echo JRoute::_('index.php?option=com_fbimporter&view=items'); ?>" method="post" name="adminForm" id="adminForm">

	<?php if(!empty( $this->sidebar) && $app->isAdmin()): ?>
		
		<!-- Sidebar -->
		<div id="j-sidebar-container" class="span2">
			<h4 class="page-header"><?php echo JText::_('JOPTION_MENUS'); ?></h4>
			<?php echo $this->sidebar; ?>
			
			<?php if( count($this->filter['filter']->getFieldset('filter')) > 0 ): ?>
			<hr />
			<div class="filter-select hidden-phone">
				<h4 class="page-header"><?php echo JText::_('JSEARCH_FILTER_LABEL');?></h4>
				
				<?php foreach( $this->filter['filter']->getFieldset('filter') as $filter ): ?>
				<label for="<?php echo $filter->id ; ?>" class="element-invisible"><?php echo $filter->title; ?></label>
				<?php echo $filter->input; ?>
				<hr class="hr-condensed" />
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else : ?>
		<div id="j-main-container">
	<?php endif;?>
	
		<fieldset id="filter-bar">
			<div class="filter-search fltlft ">
				<label class="import-num-lbl pull-left" for="import_num"><?php echo JText::_('COM_FBIMPORTER_CACHE_NUM') ; ?></label>
				<?php echo JHtml::_('select.integerlist', 50, 1000, 50 , 'import_num', array('onchange'=>"Joomla.submitbutton('items.refresh');", 'class' => 'pull-left'), $this->state->get('import_num') ); ?>
				
			</div>
			
			<!--<div class="filter-select fltrt">
					<select name="filter_published" class="inputbox" onchange="this.form.submit()">
						<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
						<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true);?>
					</select>
			</div>-->
		</fieldset>
		<div class="clr"> </div>
	
		<table class="adminlist table table table-striped">
			<thead>
				<tr>
					<th width="1%">
						<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
					</th>
					<th width="3%"><?php echo JText::_('COM_FBIMPORTER_IMAGE') ; ?></th>
					<th width="10%"><?php echo JText::_('COM_FBIMPORTER_TIME') ; ?></th>
					<th width="14%"><?php echo JText::_('COM_FBIMPORTER_CATEGORY') ; ?></th>
					<th width="20%"><?php echo JText::_('COM_FBIMPORTER_TITLE') ; ?></th>
					<th><?php echo JText::_('COM_FBIMPORTER_FULLTEXT') ; ?></th>
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
			
			$format_form = null ;
			$app->triggerEvent( 'onGetFormatForm', array( 'com_fbimporter.items', &$format_form ) );
			
			foreach ($this->items as $item ) :
			
				if( $item->continue ) continue ;
				
				$likes = isset($item->likes->count) ? $item->likes->count : 0;
				?>
				<tr class="row<?php echo $i % 2; ?>">
					
					<!--CHECKBOX-->
					<td class="center" style="padding: 0;">
						<input style="width:100%; height:100%; <?php //echo $item->exists ? 'visibility: hidden ;' : null; ?>" type="checkbox" id="cb<?php echo $i; ?>" <?php //echo $item->exists ? 'disabled="true"' : null; ?>
								name="cid[<?php echo $item->likes->count; ?>]" value="<?php echo $item->id; ?>" onclick="Joomla.isChecked(this.checked);" title="<?php echo JText::sprintf('COM_FBIMPORTER_ROW %s COM_FBIMPORTER_CHECKBOX', $i+1);?>" />
					</td>
					
					<!--IMAGE-->
					<td class="center" style="vertical-align: middle;">
						<a target="_blank" href="http://www.facebook.com/<?php echo $params->get('fb_uid'); ?>/posts/<?php echo $item->id; ?>">
							<img class="img-polaroid" src="<?php echo $item->get('picture', 'components/com_fbimporter/images/facebook-default.png'); ?>" style="max-width:150px;max-height: 150px;" onerror="this.src='components/com_fbimporter/images/facebook-default.png';" alt="<?php echo $item->get('title'); ?>" />
						</a>
					</td>
					
					<!--TIME-->
					<td class="center">
						<p>
							<?php echo $item->date->format('Y-m-d', true) ; ?>
							<br />
							<?php echo $item->date->format('H:i:s', true) ; ?>
							(<?php echo $item->date->format('D', true); ?>)	
						</p>
						<p>
							<?php echo JText::_('COM_FBIMPORTER_FB_LIKE') ;?>：<span style="color: blue;"><?php echo $likes; ?></span>
							<br />
							<?php echo JText::_('COM_FBIMPORTER_TYPE') ;?>：<span style="color: red;"><?php echo $item->get('type'); ?></span>
						</p>
						<p>
							<?php if( JVERSION >= 3 ): ?>
							<a class="btn btn-info" target="_blank" href="http://www.facebook.com/<?php echo $params->get('fb_uid'); ?>/posts/<?php echo $item->id; ?>"><?php echo JText::_('COM_FBIMPORTER_ORIGIN_LINK');?></a>
							<?php else: ?>
							<a target="_blank" href="http://www.facebook.com/<?php echo $params->get('fb_uid'); ?>/posts/<?php echo $item->id; ?>">[<?php echo JText::_('COM_FBIMPORTER_ORIGIN_LINK');?>]</a>
							<?php endif; ?>
						</p>
					</td>
					
					<!--CAREGORY & FORMAT-->
					<td align="">
						<?php if( !$item->exists ): ?>
							
							<!--CATEGORY-->
							<?php if( $item->catid && !$params->get('select_category_when_exists', 1) ): ?>
								<?php echo $item->cat_name; ?>
								<input type="hidden" name="item[<?php echo $item->id; ?>][catid]" 	value="<?php echo $item->catid; ?>" />
							<?php else: ?>
								<?php
								if(!$item->catid){
									$item->catid = $params->get('catid') ;
								}
								
								
								echo JHtml::_(
									'select.genericlist', JHtml::_('category.options', 'com_content'), "item[{$item->id}][catid]", 'class="inputbox"', 'value', 'text',
									$item->catid
								);
								?>
								
								
								<?php if( $item->cat_matched ): ?>
									<?php if( JVERSION >= 3 ): ?>
									<span class="label label-info"><?php echo JText::_('COM_FBIMPORTER_CATEGORY_AUTO_MATCHED'); ?></span>
									<?php else: ?>
									<span style="color:blue;">(<?php echo JText::_('COM_FBIMPORTER_CATEGORY_AUTO_MATCHED'); ?>)</span>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
							
							<!--FORMAT-->
							<?php if( $params->get('can_select_format', 0) && $format_form && FbimporterHelper::_('plugin.get', 'pro') ): ?>
								
								<br />
								<br />
								<hr />
								<?php echo JText::_('COM_FBIMPORTER_CHOOSE_FORMAT'); ?>：
								<?php
								$format_form->name = "item[{$item->id}][format]" ;
								echo $format_form->input ;
								?>						
							<?php endif; ?>
						<?php else: ?>
							<div align="center" style="color:#C00;">(<?php echo JText::_('COM_FBIMPORTER_HAVE_IMPORTED'); ?>)</div>
						<?php endif; ?>
					</td>
					
					
					<!--TITLE-->
					<td>
						<?php if( $item->exists ): ?>
							<h3><?php echo $item->title; ?></h3>
						<?php else: ?>
							<textarea type="text" name="item[<?php echo $item->id; ?>][title]" style="width:100%;height:100px;"><?php echo $item->get('title'); ?></textarea>
						<?php endif; ?>
					</td>
					
					
					<!--TEXT-->
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
		</div>
</form>
<p></p>
<p align="center"><?php echo JText::_('COM_FBIMPORTER_COPY_RIGHT'); ?></p>