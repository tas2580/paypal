<?php
/**
*
* @package phpBB Extension - tas2580 Paypal
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tas2580\paypal\acp;

class paypal_info
{
	function module()
	{
		return array(
			'filename'		=> '\tas2580\paypal\paypal_module',
			'title'			=> 'ACP_PAYPAL_TITLE',
			'version'		=> '0.1.0',
			'modes'		=> array(
				'settings'		=> array(
					'title'		=> 'ACP_PAYPAL_SETTINGS',
					'auth'		=> 'ext_tas2580/paypal && acl_a_board',
					'cat'		=> array('ACP_PAYPAL_TITLE')
				),
				'items'		=> array(
					'title'		=> 'ACP_PAYPAL_ITEMS',
					'auth'		=> 'ext_tas2580/paypal && acl_a_board',
					'cat'		=> array('ACP_PAYPAL_TITLE')
				),
				'donations'		=> array(
					'title'		=> 'ACP_PAYPAL_DONATIONS',
					'auth'		=> 'ext_tas2580/paypal && acl_a_board',
					'cat'		=> array('ACP_PAYPAL_TITLE')
				),
			),
		);
	}
}
