<?php
/**
 * @package UID 
 * Zen Cart German Specific 
 * based on VAT4EU plugin by Cindy Merkin a.k.a. lat9 (cindy@vinosdefrutastropicales.com)
 * Copyright (c) 2017-2024 Vinos de Frutas Tropicales
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: init_vat4eu_admin.php 2024-03-01 20:27:16Z webchills $
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

define('VAT4EU_CURRENT_RELEASE', '3.2.0');
define('VAT4EU_CURRENT_UPDATE_DATE', '2024-03-01');

define('VAT4EU_CURRENT_VERSION', VAT4EU_CURRENT_RELEASE . ': ' . VAT4EU_CURRENT_UPDATE_DATE);

// -----
// Wait until an admin is logged in before seeing if any initialization steps need to be performed.
// That ensures that "someone" will see the plugin's installation/update messages!
//
if (!isset($_SESSION['admin_id']) || (defined('VAT4EU_MODULE_VERSION') && VAT4EU_MODULE_VERSION === VAT4EU_CURRENT_VERSION)) {
    return;
}
    // -----
    // Create the plugin's configuration-group, if it's not already there.  That way, we'll have the
    // configuration_group_id, if needed for future configuration updates.
    //
    $configurationGroupTitle = 'VAT4EU Plugin';    
    $configuration = $db->Execute(
        "SELECT configuration_group_id 
           FROM " . TABLE_CONFIGURATION_GROUP . " 
          WHERE configuration_group_title = '$configurationGroupTitle' 
          LIMIT 1"
    );
    if ($configuration->EOF) {
        $db->Execute( 
            "INSERT INTO " . TABLE_CONFIGURATION_GROUP . " 
                (configuration_group_title, configuration_group_description, language_id, sort_order, visible) 
             VALUES 
                ('$configurationGroupTitle', '$configurationGroupTitle Settings', 43, 1, 1);"
        );        
        $cgi = $db->Insert_ID(); 
        $db->Execute(
            "UPDATE " . TABLE_CONFIGURATION_GROUP . " 
                SET sort_order = $cgi 
              WHERE configuration_group_id = $cgi
              LIMIT 1"
        );
    } else {
        $cgi = $configuration->fields['configuration_group_id'];
    }

    // ----
    // Perform the plugin's initial install, if not currently present.
    //
    if (!defined('VAT4EU_MODULE_VERSION')) {
        // -----
        // Create configuration items that are new to this plugin version.
        //
        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function) 
             VALUES 
            ('Plugin Version and Release Date', 'VAT4EU_MODULE_VERSION', '" . VAT4EU_CURRENT_VERSION . "', 'The &quot;VAT for EU Countries (VAT4EU)&quot; current version and release date.', $cgi, 10, now(), 'zen_cfg_read_only(')"
        );       

        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
             VALUES 
                ('Enable storefront processing?', 'VAT4EU_ENABLED', 'false', 'The <em>VAT4EU</em> processing is enabled when this setting is &quot;true&quot; and you have also set <em>Configuration-&gt;Customer Details-&gt;Company</em> to <b>true</b>.', $cgi, 2, now(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),')"
        );

        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
             VALUES 
                ('VAT Number Required?', 'VAT4EU_REQUIRED', 'false', 'Should the <em>VAT Number</em> be a <b>required</b> field?', $cgi, 3, now(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),')"
        );

        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
             VALUES 
                ('Minimum VAT Number Length', 'VAT4EU_MIN_LENGTH', '10', 'Identify the minimum length of an entered VAT Number, used as a pre-check for any input value. Set the value to <em>0</em> to disable this check.', $cgi, 4, now(), NULL, NULL)"
        );

        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
             VALUES 
                ('<em>VAT Number</em> Validation', 'VAT4EU_VALIDATION', 'Customer', 'A <em>VAT Number</em> requires validation prior to granting the customer a VAT Refund. Choose the validation method to use for your store, one of:<br><br><b>Customer</b> ... validate on any customer update<br><b>Admin</b> ... only validated by admin action.<br>', $cgi, 5, now(), NULL, 'zen_cfg_select_option(array(\'Customer\', \'Admin\'),')"
        );

        $db->Execute(
           "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
            VALUES 
                ('VAT Number: Unvalidated Indicator', 'VAT4EU_UNVERIFIED', '*', 'Identify the indicator that you want to give your customers who have entered a <em>VAT Number</em> when that number is not yet validated.<br><br>Default: <b>*</b>', $cgi, 6, now(), NULL, NULL)"        
        );
        
        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
             VALUES 
                ('VAT Number of your store', 'VAT4EU_STORE_UID', 'ATU1234567', 'Enter your own VAT Number here to display it on invoices', $cgi, 7, now(), NULL, NULL)"
        );

        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
             VALUES 
                ('Enable debug?', 'VAT4EU_DEBUG', 'false', 'Should the plugin\'s <em>debug</em> mode be enabled?  When enabled, each VAT validation request and response is logged to /logs/VatValidate.log.', $cgi, 8, now(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),')"
        );
        
        // -----
        // Add German config
        //
        
        $db->Execute("REPLACE INTO ".TABLE_CONFIGURATION_LANGUAGE." (configuration_title, configuration_key, configuration_description, configuration_language_id) VALUES
       ('UID - Modul Version', 'VAT4EU_MODULE_VERSION', 'Version des derzeit installierten UID Moduls', 43),
       ('UID - Funktionalität im Frontend aktivieren?', 'VAT4EU_ENABLED', 'Die <em>UID</em>-Funktionalität ist aktiviert, wenn diese Einstellung &quot;true&quot; ist und Sie auch <em>Konfiguration-&gt;Kundendetails-&gt;Firma</em> auf <b>true</b> gesetzt haben.', 43),
       ('UID - Pflichtfeld?', 'VAT4EU_REQUIRED', 'Soll die Eingabe einer UID in Ihrem Shop ein Pflichtfeld sein?', 43),
       ('UID - Minimale Länge', 'VAT4EU_MIN_LENGTH', 'Geben Sie die Mindestlänge einer eingegebenen UID an, die als Vorprüfung für jeden Eingabewert verwendet wird. Setzen Sie den Wert auf <em>0</em>, um diese Prüfung zu deaktivieren.', 43),
       ('UID - Überprüfungsmodus', 'VAT4EU_VALIDATION', 'Eine <em>UID</em> muss validiert werden, bevor dem Kunden eine Mehrwertsteuererstattung gewährt werden kann. Wählen Sie die Überprüfungsmethode für Ihren Shop, entweder:<br><br><b>Kunde (Customer)</b><br>Bedeutet: Wenn ein Kunde eine UID im Shop eingibt oder aktualisiert, verwendet das Modul die Validierung bei VIES, um sofort festzustellen, ob diese UID gültig ist. Wenn sie gültig ist und der Kunde diese Adresse als Rechnungsadresse für eine Bestellung verwendet, erhält er eine Mehrwertsteuerrückerstattung für qualifizierte Bestellungen. Andernfalls ist vor einer Rückerstattung eine Admin-Validierung erforderlich.<br><b>Admin</b><br>Bedeutet: Die gesamte Überprüfung der UID erfolgt unter der Kontrolle des Administrators. Wenn ein Kunde die UID einer seiner Adressen hinzufügt oder aktualisiert, ist diese Adresse nicht sofort für eine Mehrwertsteuerrückerstattung qualifiziert. Die UID muss erst vom Administrator via Shopadministration nochmals geprüft werden.<br>', 43),
       ('UID - Indikator für ungeprüfte UIDs', 'VAT4EU_UNVERIFIED', 'Geben Sie das Zeichen an, das Sie Ihren Kunden anzeigen möchten, die eine <em>UID</em> eingegeben haben, wenn diese UID noch nicht validiert ist.<br><br>Standard: <b>*</b>', 43),
       ('UID - UID des Shops', 'VAT4EU_STORE_UID', 'Geben Sie hier Ihre eigene UID ein, sie wird dann z.B. in den Hinweistexten auf der Rechnung angezeigt', 43),
       ('UID - Debug Modus aktivieren?', 'VAT4EU_DEBUG','Soll der <em>Debug</em>-Modus des Plugins aktiviert werden?  Wenn dieser Modus aktiviert ist, wird jede Anfrage und jede Antwort zur Prüfung der UID in /logs/VatValidate.log protokolliert.', 43)");

        // -----
        // Add an entry to the address_book table that will hold the VAT Number associated with the address
        // and an indication as to whether that value is valid.
        //
        $db->Execute(
            "ALTER TABLE " . TABLE_ADDRESS_BOOK . "
               ADD entry_vat_number varchar(32) DEFAULT NULL AFTER entry_company,
               ADD entry_vat_validated tinyint(1) NOT NULL default 0 AFTER entry_vat_number"
        );

        // -----
        // Add entries to the orders table that will hold the VAT Number associated with the order and its
        // validation status.
        //
        $db->Execute(
            "ALTER TABLE " . TABLE_ORDERS . "
               ADD billing_vat_number varchar(32) NOT NULL DEFAULT '' AFTER billing_company,
               ADD billing_vat_validated tinyint(1) NOT NULL default 0 AFTER billing_vat_number"
        );

        // -----
        // Display a message to the current admin, letting them know that the plugin's been installed.
        //
        $messageStack->add(sprintf(VAT4EU_TEXT_MESSAGE_INSTALLED, VAT4EU_CURRENT_VERSION), 'success');

        define('VAT4EU_MODULE_VERSION', '0.0.0');

        // -----
        // Register the plugin's configuration group with the admin menus.
        //
        zen_register_admin_page('configVat4Eu', 'BOX_CONFIG_VAT4EU', 'FILENAME_CONFIGURATION', "gID=$cgi", 'configuration', 'Y', $cgi);
    }

    

// -----
// Perform version-specific updates/additions.
//
switch (true) {
    // -----
    // v3.2.0:
    //
    // - Use zen_cfg_read_only instead of trim for module's version-setting.
    //
    case version_compare(VAT4EU_MODULE_VERSION, '3.2.0', '<'):
        $db->Execute(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET set_function = 'zen_cfg_read_only('
              WHERE configuration_key = 'VAT4EU_MODULE_VERSION'
              LIMIT 1"
        );

    default:                //- Fall through from above
        break;
}

// -----
// Update the configuration table to reflect the current version, if it's not already set.
//
$db->Execute(
    "UPDATE " . TABLE_CONFIGURATION . " 
        SET configuration_value = '" . VAT4EU_CURRENT_VERSION . "',
            set_function = 'zen_cfg_read_only('
      WHERE configuration_key = 'VAT4EU_MODULE_VERSION'
      LIMIT 1"
);
if (VAT4EU_MODULE_VERSION !== '0.0.0') {
    $messageStack->add(sprintf(VAT4EU_TEXT_MESSAGE_UPDATED, VAT4EU_MODULE_VERSION, VAT4EU_CURRENT_VERSION), 'success');
}
