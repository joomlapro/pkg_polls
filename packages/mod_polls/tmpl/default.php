<?php
/**
 * @package     Polls
 * @subpackage  mod_polls
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Add JavaScript Frameworks.
JHtml::_('jquery.framework');

JHtml::script('mod_polls/jquery.cookie.js', false, true);
JHtml::script('mod_polls/jquery.custom.js', false, true);
?>
<h2><?php echo htmlspecialchars($poll->name); ?></h2>
<div class="polls<?php echo $moduleclass_sfx; ?>">
	<div id="polls_answers" style="display: none;">
		<form id="searchForm" action="<?php echo JRoute::_(''); ?>" method="get">
			<?php foreach ($answers as $answer): ?>
			<label class="radio">
				<input type="radio" name="answers" id="answer<?php echo $answer->id; ?>" value="<?php echo $answer->id; ?>">
				<?php echo htmlspecialchars($answer->name); ?>
			</label>
			<?php endforeach; ?>
			<input id="poll_id" type="hidden" value="<?php echo $poll->id; ?>" />
			<br>
			<a href="#" class="btn polls-vote btn-success disabled"><i class="icon-ok"></i> <?php echo JText::_('MOD_POLLS_VOTE'); ?></a>
			<a href="#" class="btn polls-results"><i class="icon-repeat"></i> <?php echo JText::_('MOD_POLLS_VIEW_RESULTS'); ?></a>
		</form>
	</div>
	<div id="polls_results" style="display: none;">
		<div id="result-list">
		<?php foreach ($answers as $answer): ?>
			<label><?php echo htmlspecialchars($answer->name); ?></label>
			<div class="progress">
				<div class="bar" style="width: <?php echo $answer->votes ? (($answer->votes / $total) * 100) : 0; ?>%; background-color: <?php echo $answer->color; ?>; background-image: none;"></div>
			</div>
		<?php endforeach; ?>
		</div>
		<div class="polls-answers">
			<br>
			<a href="#" class="btn"><i class="icon-repeat"></i> <?php echo JText::_('MOD_POLLS_VIEW_ANSWERS'); ?></a>
		</div>
	</div>
</div>
