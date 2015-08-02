<?php
/**
*
* @package phpBB Extension - Paypal
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tas2580\paypal\controller;
class main
{
	/* @var \phpbb\config\config */
	protected $config;
	/* @var \phpbb\controller\helper */
	protected $helper;
	/* @var \phpbb\template\template */
	protected $template;
	/* @var \phpbb\user */
	protected $user;
	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\controller\helper	$helper
	* @param \phpbb\template\template	$template
	* @param \phpbb\user				$user
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
	}
	/**
	* Controller for route /paypal
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function handle()
	{
		$this->user->add_lang_ext('tas2580/paypal', 'common');
		$amounts = array(

			'5,00',
			'10.00',

		);
		$amount_list = '';
		foreach($amounts as $amount)
		{
			$amount_list .= '<option value="' . $amount . '">' . $amount . '</option>';
		}

		$this->template->assign_block_vars('amount', array(
			'VALUE'		=> '',
			'TITLE'		=> '',
		));

		$this->template->assign_vars(array(
			'PAYPAL_DESCRIPTION'		=> isset($this->config['paypal_description']) ? $this->config['paypal_description'] : '',
			'PAYPAL_DEFAULT_ITEM'		=> isset($this->config['paypal_default_item']) ? $this->config['paypal_default_item'] : '',
			'PAYPAL_EMAIL'				=> isset($this->config['paypal_email']) ? $this->config['paypal_email'] : '',
			'AMOUNT_LIST'				=> $amount_list,
		));
		return $this->helper->render('paypal_body.html', $this->user->lang['PAYPAL']);
	}
}
