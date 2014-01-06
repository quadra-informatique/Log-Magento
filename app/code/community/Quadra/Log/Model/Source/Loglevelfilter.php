<?php

/**
 * 1997-2012 Quadra Informatique
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is available
 * through the world-wide-web at this URL: http://www.opensource.org/licenses/OSL-3.0
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to ecommerce@quadra-informatique.fr so we can send you a copy immediately.
 *
 *  @author Quadra Informatique <ecommerce@quadra-informatique.fr>
 *  @copyright 1997-2013 Quadra Informatique
 *  @version Release: $Revision: 1.0.1 $
 *  @license http://www.opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 */
class Quadra_Log_Model_Source_Loglevelfilter {

    public function toOptionArray() {
        return array(
            array('value' => 0, 'label' => 'EMERG (0) Emergency: system is unusablee'),
            array('value' => 1, 'label' => 'ALERT (1) Alert: action must be taken immediately'),
            array('value' => 2, 'label' => 'CRIT (2) Critical: critical conditions'),
            array('value' => 3, 'label' => 'ERR (3) Error: error conditions'),
            array('value' => 4, 'label' => 'WARN (4) Warning: warning conditions'),
            array('value' => 5, 'label' => 'NOTICE (5) Notice: normal but significant condition'),
            array('value' => 6, 'label' => 'INFO (6) Informational: informational messages'),
            array('value' => 7, 'label' => 'DEBUG (7) Debug: debug messages')
        );
    }
}