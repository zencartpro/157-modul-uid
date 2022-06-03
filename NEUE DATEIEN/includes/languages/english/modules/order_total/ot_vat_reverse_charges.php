<?php
/**
 * @package UID 
 * Zen Cart German Specific 
 * based on VAT4EU plugin by Cindy Merkin a.k.a. lat9 (cindy@vinosdefrutastropicales.com)
 * Copyright (c) 2017-2022 Vinos de Frutas Tropicales
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: ot_vat_reverse_charges.php 2022-06-03 15:38:16Z webchills $
 */
// bof do not change
if (IS_ADMIN_FLAG === true) {
if (!defined('VAT4EU_STORE_UID')) define('VAT4EU_STORE_UID', '');
if (!defined('VAT4EU_ENABLED')) define('VAT4EU_ENABLED', 'false');
}
$storeuid = '';
$customeruid ='';
if (VAT4EU_ENABLED === 'true'){
global $db;
$storeuid = VAT4EU_STORE_UID;
$check_uid_query = "SELECT entry_country_id, entry_vat_number, entry_vat_validated
               FROM " . TABLE_ADDRESS_BOOK . "
              WHERE address_book_id = :addressBookID
                AND customers_id = :customersID
              LIMIT 1";
$check_uid_query = $db->bindVars($check_uid_query, ':customersID', $_SESSION['customer_id'], 'integer');
$check_uid_query = $db->bindVars($check_uid_query, ':addressBookID', $_SESSION['billto'], 'integer');
$check_uid = $db->Execute($check_uid_query);
        if (!$check_uid->EOF) {
        	$customeruid = $check_uid->fields['entry_vat_number'];
        }
}
// eof do not change
 
define('MODULE_ORDER_TOTAL_VAT_REVERSE_CHARGES_TITLE_ADMIN', 'Display VAT Reverse Charge Notification');
define('MODULE_ORDER_TOTAL_VAT_REVERSE_CHARGES_TITLE', 'Tax-free intra-Community delivery | Our VAT ID: '. $storeuid . ' | Your VAT ID: '. $customeruid . '');
define('MODULE_ORDER_TOTAL_VAT_REVERSE_CHARGES_DESCRIPTION', 'Part of the <em>UID</em> plugin.  When enabled, displays a disclaimer within the order when that order qualifies for a VAT refund.');
