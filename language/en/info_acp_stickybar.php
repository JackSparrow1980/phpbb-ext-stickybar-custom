<?php
/**
*
* @package phpBB Extension - Sticky Bar
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_STICKYBAR'			=> 'Sticky Bar',
	'STICKYBAR_CONFIG'		=> 'Sticky Bar Settings',

	'LOG_STICKYBAR_SAVE'	=> 'Sticky Bar Settings Saved',
));
