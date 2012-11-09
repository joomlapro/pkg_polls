<?php
/**
 * @package     Polls
 * @subpackage  com_polls
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

JHtml::stylesheet('com_polls/jquery.miniColors.css', false, true, false);
JHtml::script('com_polls/jquery.miniColors.min.js', false, true);
?>
<script type="text/javascript">
	Joomla.submitbutton = function (task) {
		if (task == 'poll.cancel' || document.formvalidator.isValid(document.id('poll-form'))) {
			<?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task, document.getElementById('poll-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
		}
	}
</script>
<script type="text/javascript">
jQuery.noConflict();

(function ($) {
	$(function () {
		var i = $('#answers .control-group').size();

		$('#add').live('click', function () {
			if (i <= 10) {
				var field = '';

				field += '<div class="control-group">';
				field += '	<div class="control-label"><label class="required" for="jform_name" id="jform_name-lbl" aria-invalid="false"><?php echo JText::_('COM_POLLS_OPTION'); ?> ' + i + '</label></div>';
				field += '	<div class="controls">';
				field += '		<input type="text" class="inputbox input-large required" value="" name="jform[answers][' + i + '][name]" aria-required="true" required="required" aria-invalid="false" rel="tooltip" data-placement="top" title="<?php echo JText::_('COM_POLLS_ANSWER'); ?>" />';
				field += '		<input type="text" class="inputbox input-mini color" value="" name="jform[answers][' + i + '][color]" aria-invalid="false" rel="tooltip" data-placement="top" title="<?php echo JText::_('COM_POLLS_COLOR'); ?>" />';
				field += '		<input type="text" class="inputbox input-mini" value="' + i + '" name="jform[answers][' + i + '][ordering]" aria-invalid="false" rel="tooltip" data-placement="top" title="<?php echo JText::_('JGRID_HEADING_ORDERING'); ?>" />';
				field += '		<input type="text" class="inputbox input-mini" value="0" name="jform[answers][' + i + '][votes]" aria-invalid="false" rel="tooltip" data-placement="top" title="<?php echo JText::_('COM_POLLS_VOTES'); ?>" />';
				field += '		<a href="#" class="btn remove"><?php echo JText::_('JACTION_DELETE'); ?></a>';
				field += '	</div>';
				field += '</div>';

				$(field).fadeIn('slow').appendTo('#answers');
				i++;

				$('.color').miniColors();
			};

			return false;
		});

		$('#reset').click(function () {
			while (i > 2) {
				$('#answers .control-group:last').remove();
				i--;
			}
		});

		$('.remove').live('click', function () {
			if (i > 2) {
				$(this).parents('.control-group').remove();
				i--;
			}

			return false;
		});

		$('.color').miniColors();
	});
})(jQuery);
</script>
<form action="<?php echo JRoute::_('index.php?option=com_polls&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="poll-form" class="form-validate">
	<div class="row-fluid">
		<!-- Begin Polls -->
		<div class="span10 form-horizontal">
			<fieldset>
				<ul class="nav nav-tabs">
					<li class="active"><a href="#details" data-toggle="tab"><?php echo empty($this->item->id) ? JText::_('COM_POLLS_NEW_POLL') : JText::sprintf('COM_POLLS_EDIT_POLL', $this->item->id); ?></a></li>
					<li><a href="#answers" data-toggle="tab"><?php echo JText::_('COM_POLLS_FIELDSET_ANSWERS'); ?></a></li>
					<li><a href="#publishing" data-toggle="tab"><?php echo JText::_('JGLOBAL_FIELDSET_PUBLISHING'); ?></a></li>
					<?php $fieldSets = $this->form->getFieldsets('params');
					foreach ($fieldSets as $name => $fieldSet): ?>
					<li><a href="#params-<?php echo $name; ?>" data-toggle="tab"><?php echo JText::_($fieldSet->label); ?></a></li>
					<?php endforeach; ?>
					<?php $fieldSets = $this->form->getFieldsets('metadata');
					foreach ($fieldSets as $name => $fieldSet): ?>
					<li><a href="#metadata-<?php echo $name; ?>" data-toggle="tab"><?php echo JText::_($fieldSet->label); ?></a></li>
					<?php endforeach; ?>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="details">
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
						</div>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
						</div>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('ordering'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('ordering'); ?></div>
						</div>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
						</div>
					</div>
					<div class="tab-pane" id="answers">
						<div class="control-group">
							<div class="control-label"></div>
							<div class="controls">
								<a id="add" href="#" class="btn btn-primary"><?php echo JText::_('COM_POLLS_ADD'); ?></a>
								<a id="reset" href="#" class="btn"><?php echo JText::_('JCLEAR'); ?></a>
							</div>
						</div>
						<?php foreach ($this->answers as $i => $answer):
						$i++; ?>
						<div class="control-group">
							<div class="control-label"><label class="required" for="jform_name" id="jform_name-lbl" aria-invalid="false"><?php echo JText::_('COM_POLLS_OPTION'); ?> <?php echo $i; ?></label></div>
							<div class="controls">
								<input type="text" class="inputbox input-large required" value="<?php echo $answer->name; ?>" name="jform[answers][<?php echo $i; ?>][name]" aria-required="true" required="required" aria-invalid="false" rel="tooltip" data-placement="top" title="<?php echo JText::_('COM_POLLS_ANSWER'); ?>" />
								<input type="text" class="inputbox input-mini color" value="<?php echo $answer->color; ?>" name="jform[answers][<?php echo $i; ?>][color]" aria-invalid="false" rel="tooltip" data-placement="top" title="<?php echo JText::_('COM_POLLS_COLOR'); ?>" />
								<input type="text" class="inputbox input-mini" value="<?php echo $answer->ordering; ?>" name="jform[answers][<?php echo $i; ?>][ordering]" aria-invalid="false" rel="tooltip" data-placement="top" title="<?php echo JText::_('JGRID_HEADING_ORDERING'); ?>" />
								<input type="text" class="inputbox input-mini" value="<?php echo $answer->votes ? $answer->votes : '0'; ?>" name="jform[answers][<?php echo $i; ?>][votes]" aria-invalid="false" rel="tooltip" data-placement="top" title="<?php echo JText::_('COM_POLLS_VOTES'); ?>" />
								<a href="#" class="btn remove"><?php echo JText::_('JACTION_DELETE'); ?></a>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<div class="tab-pane" id="publishing">
						<div class="row-fluid">
							<div class="span6">
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
								</div>
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
								</div>
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
								</div>
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('created_by_alias'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('created_by_alias'); ?></div>
								</div>
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('created'); ?></div>
								</div>
							</div>
							<div class="span6">
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('publish_up'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('publish_up'); ?></div>
								</div>
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('publish_down'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('publish_down'); ?></div>
								</div>
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('version'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('version'); ?></div>
								</div>
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
								</div>
								<div class="control-group">
									<div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
									<div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
								</div>
								<?php if ($this->item->hits): ?>
									<div class="control-group">
										<div class="control-label"><?php echo $this->form->getLabel('hits'); ?></div>
										<div class="controls"><?php echo $this->form->getInput('hits'); ?></div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php echo $this->loadTemplate('params'); ?>
					<?php echo $this->loadTemplate('metadata'); ?>
				</div>
			</fieldset>
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
		<!-- End Polls -->
		<!-- Begin Sidebar -->
		<div class="span2">
			<h4><?php echo JText::_('JDETAILS'); ?></h4>
			<hr />
			<fieldset class="form-vertical">
				<div class="control-group">
					<div class="controls"><?php echo $this->form->getValue('name'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('access'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('access'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('featured'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('featured'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('language'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('language'); ?></div>
				</div>
			</fieldset>
		</div>
		<!-- End Sidebar -->
	</div>
</form>
