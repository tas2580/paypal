<?php
/**
*
* @package phpBB Extension - tas2580 Mobile Notifier
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tas2580\paypal\migrations;

class initial_module extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('paypal_email', '')),
			array('config.add', array('paypal_default_item', '')),
			array('config.add', array('paypal_description', '')),

			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_PAYPAL_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_PAYPAL_TITLE',
				array(
					'module_basename'	=> '\tas2580\paypal\acp\paypal_module',
					'modes'				=> array('settings'),
				),
			)),
			array('module.add', array(
				'acp',
				'ACP_PAYPAL_TITLE',
				array(
					'module_basename'	=> '\tas2580\paypal\acp\paypal_module',
					'modes'				=> array('items'),
				),
			)),
		);
	}
}
