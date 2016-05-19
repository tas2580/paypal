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
			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_PAYPAL_TITLE'
			)),
			array('module.add', array('acp', 'ACP_PAYPAL_TITLE', array(
					'module_basename'	=> '\tas2580\paypal\acp\paypal_module',
					'modes'				=> array('settings'),
				),
			)),
			// Add ACP module
			array('module.add', array('acp', 'ACP_PAYPAL_TITLE', array(
					'module_basename'	=> '\tas2580\paypal\acp\paypal_module',
					'modes'				=> array('items'),
				),
			)),
			array('module.add', array('acp', 'ACP_PAYPAL_TITLE', array(
					'module_basename'	=> '\tas2580\paypal\acp\paypal_module',
					'modes'				=> array('donations'),
				),
			)),
			array('custom', array(array($this, 'add_config_values'))),
		);
	}
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'paypal_amount'	=> array(
					'COLUMNS'	=> array(
						'amount_id'			=> array('UINT', null, 'auto_increment'),
						'amount_value'		=> array('UINT', '0'),
					),
					'PRIMARY_KEY'	=> 'amount_id',
				),
				$this->table_prefix . 'paypal_config'	=> array(
					'COLUMNS'	=> array(
						'paypal_email'			=> array('VCHAR:255', ''),
						'paypal_title'			=> array('VCHAR:255', ''),
						'paypal_currency'		=> array('VCHAR:255', ''),
						'paypal_text'			=> array('MTEXT_UNI', ''),
						'bbcode_uid'			=> array('VCHAR:10', ''),
						'bbcode_bitfield'		=> array('VCHAR:32', ''),
						'paypal_sandbox'		=> array('BOOL', 0),
					),
				),
				$this->table_prefix . 'paypal_donations'	=> array(
					'COLUMNS'	=> array(
						'donation_id'			=> array('UINT', null, 'auto_increment'),
						'user_id'				=> array('UINT', 0),
						'item_id'				=> array('UINT', 0),
						'item_name'				=> array('VCHAR:255', ''),
						'donation_time'			=> array('VCHAR:14', ''),
						'donation_amount'		=> array('VCHAR:255', ''),
					),
					'PRIMARY_KEY'	=> 'donation_id',
				),
				$this->table_prefix . 'paypal_items'	=> array(
					'COLUMNS'	=> array(
						'item_id'				=> array('UINT', null, 'auto_increment'),
						'item_name'				=> array('VCHAR:255', ''),
						'item_text'				=> array('MTEXT_UNI', ''),
						'bbcode_uid'			=> array('VCHAR:10', ''),
						'bbcode_bitfield'		=> array('VCHAR:32', ''),
					),
					'PRIMARY_KEY'	=> 'item_id',
				),
			),
		);
	}
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'paypal_config',
				$this->table_prefix . 'paypal_amount',
				$this->table_prefix . 'paypal_items',
			),
		);
	}

	public function add_config_values()
	{

		$sql_data = array(
			'paypal_email'				=> '',
			'paypal_title'				=> '',
			'paypal_currency'			=> '',
			'paypal_text'				=> '',
			'bbcode_uid'				=> '',
			'bbcode_bitfield'			=> '',
			'paypal_sandbox'			=> 0,
		);
		$sql = 'INSERT INTO ' . $this->table_prefix . 'paypal_config
			' . $this->db->sql_build_array('INSERT', $sql_data);
		$this->db->sql_query($sql);

	}

}
