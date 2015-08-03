<?php
/**
*
* @package phpBB Extension - Paypal - Englisch
* @copyright (c) 2015 tas2580 (https://tas2580.net)
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
// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//
$lang = array_merge($lang, array(
	'PAYPAL'					=> 'Paypal Donation',
	'ACP_PAYPAL_TITLE' 			=> 'Paypal',
	'PAYPAL_INFO'				=> 'Instruct PayPal online with your amount',
	'PAYPAL_TEXT'				=> '- Everybody who wants to help this project could do it with a little donation.',
	'PAYPAL_MSG'				=> 'Click on the picture to donate. Please click on the drop down menu for instructing a selected amount of you.',

	'DONATION_INFO'				=> 'Thank you for your friendly assistance.',

	'PAYPAL_EMAIL'				=> 'xxxx@xxx.tld',
	'DONATION_TITLE'			=> 'Your donation title',
	'PAYPALINFO_EXPLAIN'		=> 'Support this project; Instruct an amount via PayPal to pay voluntarily.',

	'DONATION_USD'				=> '$ USD',
	'DONATION_EUR'				=> '€ EUR',
	'DONATION_GBP'				=> '£ GBP',
	'DONATION_JPY'				=> '¥ JPY',
	'DONATION_AUD'				=> '$ AUD',
	'DONATION_CAD'				=> '$ CAD',
	'DONATION_HKD'				=> '$ HKD',

	'COPYRIGHT_PAYPALEXTENSION'	=> 'Paypal-Extension created by <a href="https://tas2580.net">tas2580</a> 2015',
	'PAYPALDESIGNANDINFO'		=> 'Paypalsite: <a href="http://www.ongray-design.de/">Design by Talk19Zehn</a> 2014-2015',
));
