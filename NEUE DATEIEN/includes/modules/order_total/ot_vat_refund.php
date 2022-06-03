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
 * @version $Id: ot_vat_refund.php 2022-06-03 08:29:16Z webchills $
 */
 
if (!defined('IS_ADMIN_FLAG')) {
    die('Invalid access.');
}

class ot_vat_refund extends base
{
    public    $title;
    public    $output;
    protected $_check;
    protected $isEnabled = false;

    public function __construct() 
    {
        $this->code = 'ot_vat_refund';
        $this->title = MODULE_ORDER_TOTAL_VAT_REFUND_TITLE;
        $this->description = MODULE_ORDER_TOTAL_VAT_REFUND_DESCRIPTION;
        $this->sort_order = defined('MODULE_ORDER_TOTAL_VAT_REFUND_SORT_ORDER') ? (int)MODULE_ORDER_TOTAL_VAT_REFUND_SORT_ORDER : null;
        if ($this->sort_order === null) {
            return false;
        }
        
        $this->isEnabled = (defined('VAT4EU_ENABLED') && VAT4EU_ENABLED == 'true');

        $this->output = array();
    }

    public function process() 
    {
        $is_refundable = false;
        if ($this->isEnabled) {
            if (IS_ADMIN_FLAG === false && is_object($GLOBALS['zcObserverVatForEuCountries'])) {
                $is_refundable = $GLOBALS['zcObserverVatForEuCountries']->isVatRefundable();
            } elseif (IS_ADMIN_FLAG == true && is_object($GLOBALS['vat4EuAdmin'])) {
                $is_refundable = $GLOBALS['vat4EuAdmin']->isVatRefundable();
            }
        }
        if ($is_refundable) {
            $order = $GLOBALS['order'];
            $vat_refund = $order->info['tax'];
            $GLOBALS['order']->info['total'] -= $vat_refund;
            if ($vat_refund != 0) {
                $this->output[] = array(
                    'title' => $this->title . ':',
                    'text' => '-' . $GLOBALS['currencies']->format($vat_refund, true, $order->info['currency'], $order->info['currency_value']),
                    'value' => -$vat_refund
                );
            }
        }
    }

    public function check() 
    {
        if (!isset($this->_check)) {
            $check = $GLOBALS['db']->Execute(
                "SELECT configuration_value
                   FROM " . TABLE_CONFIGURATION . "
                  WHERE configuration_key = 'MODULE_ORDER_TOTAL_VAT_REFUND_STATUS'
                  LIMIT 1"
            );
            $this->_check = $check->RecordCount();
        }
        return $this->_check;
    }

    public function keys() 
    {
        return array(
            'MODULE_ORDER_TOTAL_VAT_REFUND_STATUS', 
            'MODULE_ORDER_TOTAL_VAT_REFUND_SORT_ORDER', 
        );
    }

    public function install() 
    {
        $GLOBALS['db']->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . " 
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) 
             VALUES 
                ('This module is installed', 'MODULE_ORDER_TOTAL_VAT_REFUND_STATUS', 'true', '', '6', '1','zen_cfg_select_option(array(\'true\'), ', now())"
        );
        $GLOBALS['db']->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . " 
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) 
             VALUES 
                ('Sort Order', 'MODULE_ORDER_TOTAL_VAT_REFUND_SORT_ORDER', '900', 'Sort order of display.<br /><br /><b>Note:</b> Make sure that the value is larger than the sort-order for the <em>Tax</em> total\'s display!', '6', '2', now())"
        );
        $GLOBALS['db']->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION_LANGUAGE . " 
                (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) 
             VALUES 
                ('Dieses Modul ist installiert', 'MODULE_ORDER_TOTAL_VAT_REFUND_STATUS', '43', '', now())"
        ); 
        
        $GLOBALS['db']->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION_LANGUAGE . " 
                (configuration_title, configuration_key, configuration_language_id, configuration_description, date_added) 
             VALUES 
                ('Sortierreihenfolge', 'MODULE_ORDER_TOTAL_VAT_REFUND_SORT_ORDER', '43', 'Sortierreihenfolge in der Bestellzusammenfassung<br><br><b>Hinweis:</b> Achten Sie darauf, dass der Wert größer ist als die Sortierreihenfolge für die Anzeige der <em>Steuer</em><br><br>Voreisntellung: 900', now())"
        );   
    }

    public function remove() 
    {
        $GLOBALS['db']->Execute(
            "DELETE FROM " . TABLE_CONFIGURATION . " 
              WHERE configuration_key IN ('" . implode("', '", $this->keys()) . "')"
        );
        
        $GLOBALS['db']->Execute(
            "DELETE FROM " . TABLE_CONFIGURATION_LANGUAGE . " 
              WHERE configuration_key IN ('" . implode("', '", $this->keys()) . "')"
        );
    }
}
