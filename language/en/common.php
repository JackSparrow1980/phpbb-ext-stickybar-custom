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
	'ACP_STICKYBAR_CONFIG'				=> 'Sticky Bar',
	'ACP_STICKYBAR_CONFIG_EXPLAIN'		=> 'This is configuration page for the Sticky Bar extension.',

	'STICKYBAR_COLOUR'					=> 'Sticky Bar Background Colour',
	'STICKYBAR_COLOUR_JS'				=> 'Click box to select Sticky Bar Colour.',
	'STICKYBAR_COLOUR_EXPLAIN'			=> 'Select the Sticky Bar colour',

	'STICKYBAR_TEXT_COLOUR'				=> 'Sticky Bar Text Colour',
	'STICKYBAR_TEXT_COLOUR_JS'			=> 'Click box to select Sticky Bar Text Colour.',
	'STICKYBAR_TEXT_COLOUR_EXPLAIN'		=> 'Select the Sticky Text Bar colour',

	'STICKYBAR_SEARCH'					=> 'Sticky Bar Search',
	'STICKYBAR_SEARCH_EXPLAIN'			=> 'Show Search Bar in the Sticky Bar',

	'STICKYBAR_SELECT'					=> 'Enable Sticky Bar Logo',
	'STICKYBAR_SELECT_EXPLAIN'			=> 'Show Sticky Bar Logo',
	'STICKYBAR_LOGO'					=> 'Sticky Bar Logo',
	'STICKYBAR_LOGO_EXPLAIN'			=> 'Place your Logo in your forums root/images folder and enter its name here (eg mini_logo.gif)',

	'STICKYBAR_LEFT'					=> 'Logo Width',
	'STICKYBAR_LEFT_EXPLAIN'			=> 'How Wide is the Sticky Bar Logo in px?',

	'STICKYBAR_TOP'						=> 'Logo Height',
	'STICKYBAR_TOP_EXPLAIN'				=> 'How High is the Sticky Bar Logo in px?',

	'ACP_STICKYBAR_CONFIG_SET'			=> 'Configuration',
	'STICKYBAR_SAVED'					=> 'Sticky Bar settings saved',
));
