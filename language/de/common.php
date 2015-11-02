<?php
/**
*
* @package phpBB Extension - Paypal - German (Casual)
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
	'PAYPAL' 							=> 'Paypal',
	'ACP_PAYPAL_DEFAULT_ITEM'			=> 'Paypal-Beschreibung',
	'ACP_PAYPAL_DEFAULT_ITEM_EXPLAIN'	=> 'Ein zuordenbarer Text deiner Paypalabwicklung',
	'ACP_PAYPAL_EMAIL'					=> 'Paypal-E-Mail',
	'ACP_PAYPAL_EMAIL_EXPLAIN'			=> 'Gib deine Paypal-E-Mail-Adresse bitte hier ein - Beispiel: xxxx@xxx.tld',
	'ACP_PAYPAL_DESCRIPTION'			=> 'Texteingabe',
	'ACP_PAYPAL_DESCRIPTION_EXPLAIN'	=> 'Ein wenig Text, der im Forum auf der Paypalseite angezeigt werden wird.',
	'ACP_CURRENCY_CODE'					=> 'Währungen',
	'ACP_CURRENCY_CODE_EXPLAIN'			=> 'Wähle die Währung, die im Auswahlmenü auf der Paypalseite im Forum voreingestellt angezeigt wird. Währungen kannst du in der common.php einfügen oder entfernen. Bitte gehe sorgfältig und eigenverantwortlich mit den Einträgen um.',
	'ACP_SUBMIT'						=> 'Bestätigung deiner Angaben',
	'ACP_AMOUNT_LIST'					=> 'Zahlbeträge',
	'ACP_AMOUNT'						=> 'Deine Zahlbeträge',
	'ACP_ADD_AMOUNT'					=> 'Erfasse deine Zahlbeträge - Beispiel: 1000 ergibt 10.00',
	'ACP_SETTINGS'						=> 'Paypal-Angaben',
	'ACP_SAVED'							=> 'Deine Paypal-Angaben wurden gespeichert',
	'AMOUNT_DELETED'					=> 'Der Betrag wurde gelöscht',
	'PAYPAL_INFO' 						=> 'Mit PayPal online deinen Betrag anweisen',
	'PAYPAL_TEXT'						=> '- ist eine Website ohne jedes Gewinninteresse. Jeder, der dieses Projekt unterstützen möchte, kann dies mit einem Betrag gern tun.',
	'PAYPAL_MSG'						=> 'Klicke bitte auf das Auswahlmenü, um einen von dir gewählten Betrag anzuweisen.',
	'PAYPAL_DONATION'					=> 'Zahlbetrag anweisen',
	'DONATION_INFO'						=> 'Vielen Dank für deine freundliche Unterstützung.',

	'DONATION_TITLE'			=> 'Meinen Betrag zur Zahlung freiwillig spenden und anweisen',
	'PAYPALINFO_EXPLAIN'		=> 'Dieses Projekt unterstützen; Einen Betrag via PayPal zur Zahlung freiwillig anweisen',

	'DONATION_'					=> 'N/A',
	'DONATION_AUD'				=> 'Australische Dollar (AUD)',
	'DONATION_CAD'				=> 'Kanadische Dollar (CAD)',
	'DONATION_CHF'				=> 'Schweizer Franken (CHF)',
	'DONATION_CZK'				=> 'Tschechische Kronen (CZK)',
	'DONATION_DKK'				=> 'Dänische Kronen (DKK)',
	'DONATION_EUR'				=> 'Euro (EUR)',
	'DONATION_GBP'				=> 'Britische Pfund (GBP)',
	'DONATION_HKD'				=> 'Hongkong-Dollar (HKD)',
	'DONATION_HUF'				=> 'Ungarische Forint (HUF)',
	'DONATION_ILS'				=> 'Neue Israelische Schekel (ILS)',
	'DONATION_JPY'				=> 'Japanische Yen (JPY)',
	'DONATION_MXN'				=> 'Mexikanische Pesos (MXN)',
	'DONATION_NOK'				=> 'Norwegische Kronen (NOK)',
	'DONATION_NZD'				=> 'Neuseeland-Dollar (NZD)',
	'DONATION_PLN'				=> 'Polnische Zloty (PLN)',
	'DONATION_SEK'				=> 'Schwedische Kronen (SEK)',
	'DONATION_SGD'				=> 'Singapur-Dollar (SGD)',
	'DONATION_USD'				=> 'US-Dollar (USD)',

	'COPYRIGHT_PAYPALEXTENSION'	=> 'Paypal-Extension created by <a href="https://tas2580.net">tas2580</a> 2015',
	'PAYPALDESIGNANDINFO'		=> 'Paypalseite: <a href="http://www.ongray-design.de/">Design by Talk19Zehn</a> 2014-2015',
));
