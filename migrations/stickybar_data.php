<?php
/**
*
* @package phpBB Extension - Sticky Bar
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\stickybar\migrations;

class stickybar_data extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
		// Add configs
			array('config.add', array('stickybar_colour', '#CADCEB')),
			array('config.add', array('stickybar_select', '0')),
			array('config.add', array('stickybar_search', '0')),
			array('config.add', array('stickybar_logo', '0')),
			array('config.add', array('stickybar_text_colour', '#105289')),
			array('config.add', array('stickybar_left', '0')),
			array('config.add', array('stickybar_top', '0')),

		// Add ACP modules
			array('module.add', array('acp', 'ACP_BOARD_CONFIGURATION', array(
				'module_basename'	=> '\hifikabin\stickybar\acp\stickybar_module',
				'module_langname'	=> 'ACP_STICKYBAR',
				'module_mode'		=> 'settings',
				'module_auth'		=> 'ext_hifikabin/stickybar && acl_a_board',
			))),
		);
	}
}
