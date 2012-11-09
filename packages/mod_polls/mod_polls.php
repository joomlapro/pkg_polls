<?php
/**
 * @package     Polls
 * @subpackage  mod_polls
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Include the polls functions only once.
require_once __DIR__ . '/helper.php';

// Get the poll and answers.
$poll = modPollsHelper::getPoll($params);
$answers = modPollsHelper::getAnswers($params);
$total = modPollsHelper::getTotal($params);

// Initialise variables.
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_polls', $params->get('layout', 'default'));
