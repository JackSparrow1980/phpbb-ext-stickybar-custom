<?php
/**
*
* @package phpBB Extension - Sticky Bar
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\stickybar\migrations;

class stickybar_ucp extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
	return array(
		'\hifikabin\stickybar\migrations\stickybar_data');
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_stickybar');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'stickybar'	=> array('BOOL', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'stickybar',
				),
			),
		);
	}
}
