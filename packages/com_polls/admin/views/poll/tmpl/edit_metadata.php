<?php
/**
 * @package     Polls
 * @subpackage  com_polls
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

$fieldSets = $this->form->getFieldsets('metadata');

foreach ($fieldSets as $name => $fieldSet): ?>
	<div class="tab-pane" id="metadata-<?php echo $name; ?>">
	<?php if (isset($fieldSet->description) && trim($fieldSet->description)):
		echo '<p class="alert alert-info">' . $this->escape(JText::_($fieldSet->description)) . '</p>';
	endif; ?>
		<?php if ($name == 'jmetadata'): // Include the real fields in this panel. ?>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('metadesc'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('metadesc'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('metakey'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('metakey'); ?></div>
			</div>
		<?php endif; ?>
		<?php foreach ($this->form->getFieldset($name) as $field): ?>
			<div class="control-group">
				<div class="control-label"><?php echo $field->label; ?></div>
				<div class="controls"><?php echo $field->input; ?></div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endforeach;
