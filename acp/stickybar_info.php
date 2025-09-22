<?php
/**
*
* @package phpBB Extension - Sticky Bar
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\stickybar\acp;

class stickybar_info
{
	function module()
	{
		return array(
			'filename'			=> '\hifikabin\stickybar\acp\stickybar_module',
			'title'				=> 'ACP_STICKYBAR',
			'modes'				=> array(
				'settings'		=> array(
					'title'		=> 'ACP_STICKYBAR_SETTINGS',
					'auth'		=> 'ext_hifikabin/stickybar && acl_a_board',
					'cat'		=> array('ACP_STICKYBAR')
				),
			),
		);
	}
}
