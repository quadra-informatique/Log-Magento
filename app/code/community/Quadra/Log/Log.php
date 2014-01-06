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
/**
 *  Rappel des niveaux de debug Zend
 *
 *  Log::EMERG (0) Emergency: system is unusable
 *  Log::ALERT (1) Alert: action must be taken immediately
 *  Log::CRIT (2) Critical: critical conditions
 *  Log::ERR (3) Error: error conditions
 *  Log::WARN (4) Warning: warning conditions
 *  Log::NOTICE (5) Notice: normal but significant condition
 *  Log::INFO (6) Informational: informational messages
 *  Log::DEBUG (7) Debug: debug messages
 */
// Pour PHPUnit & Cron :
require_once(BP . '/lib/Zend/Log.php');
require_once(BP . '/lib/Zend/Log/Formatter/Interface.php');
require_once(BP . '/lib/Zend/Log/Formatter/Simple.php');
require_once(BP . '/lib/Zend/Log/FactoryInterface.php');
require_once(BP . '/lib/Zend/Log/Writer/Abstract.php');
require_once(BP . '/lib/Zend/Log/Writer/Stream.php');

class Log extends Zend_Log {

    protected static $_isInDebugMode = null;
    protected static $_day = null;

    /**
     * Usefull to disable some debuging code
     *
     * @return bool
     * @author arossetti
     */
    public static function isInDebugMode() {
        if (!isset(self::$_isInDebugMode)) {
            self::$_isInDebugMode =
                    Mage::getStoreConfig('dev/log/active') && (int) Mage::getStoreConfig('dev/log/level_filter') >= self::DEBUG ?
                    true : false;
        }
        return self::$_isInDebugMode;
    }

    /**
     * log facility with level filter
     *
     * @param string $message
     * @param integer $level
     * @param string $file
     * @param bool $forceLog (optional)
     * @param integer $btLvl (optional : Backtrace Level )
     * @author arossetti
     */
    public static function l($message, $level = self::DEBUG, $file = '', $forceLog = false, $btLvl = 1) {
        if (!$forceLog && !Mage::getStoreConfig('dev/log/active'))
            return;
        $levelFilter = (int) Mage::getStoreConfig('dev/log/level_filter');
        if (!$forceLog && (int) $level > $levelFilter)
            return;
        if (is_array($message) || is_object($message))
            $message = print_r($message, true);
        if ($levelFilter == self::DEBUG) {
            $dBT = debug_backtrace(false);
            if (isset($dBT[$btLvl])) {
                $dBT = array_merge(array('class' => '', 'function' => ''), $dBT[$btLvl]);
                $message = $dBT['class'] . ' ' . $dBT['function'] . ': ' . $message;
            }
        }
        Mage::log(trim($message), $level, $file, $forceLog);
    }

    /**
     * log by day facility with level filter
     *
     * @param string $message
     * @param integer $level
     * @param string $fileRoot
     * @param bool $forceLog (optional)
     * @param integer $btLvl (optional : Backtrace Level )
     * @author mpasquin
     */
    public static function lbd($message, $level = self::DEBUG, $fileRoot = '', $forceLog = false, $btLvl = 1) {
        if (!self::$_day)
            self::$_day = date('Y-m-d');

        $file = ($fileRoot) ? $fileRoot : 'log';
        $file .= '_' . self::$_day . '.log';

        return self::l($message, $level, $file, $forceLog, $btLvl+1);
    }

}

class Quadra {

    public static function log($message, $level = Log::DEBUG, $file = '', $forceLog = false) {
        Log::l($message, $level, $file, $forceLog, 2);
    }

}
