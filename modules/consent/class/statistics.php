<?php
/**
 * Legal Consent is a module for obtain legal guardianship consent
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   	The XOOPS Project http://fonts2web.org.uk
 * @license     	General Public License version 3 (http://labs.coop/briefs/legal/general-public-licence/13,3.html)
 * @author      	Simon Roberts (wishcraft) <wishcraft@users.sourceforge.net>
 * @subpackage  	consent
 * @description 	Legal Consent is a module for obtain legal guardianship consent
 * @version		    1.0.1
 * @link			http://internetfounder.wordpress.com
 */

if (!defined('_MD_consent_MODULE_DIRNAME')) {
	return false;
}

//*
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'objects.php');

/**
 * Database Table for Statistics in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_statistics` (
 *   `id` mediumint(32) NOT NULL AUTO_INCREMENT,
 *   `key` varchar(64) NOT NULL DEFAULT '',
 *   `when` int(13) NOT NULL DEFAULT '0',
 *   `year` int(4) NOT NULL DEFAULT '0',
 *   `month` int(2) NOT NULL DEFAULT '0',
 *   `day` int(2) NOT NULL DEFAULT '0',
 *   `week` int(2) NOT NULL DEFAULT '0',
 *   `hour` int(2) NOT NULL DEFAULT '0',
 *   `minute` int(2) NOT NULL DEFAULT '0',
 *   `seconds` int(2) NOT NULL DEFAULT '0',
 *   `quarter` enum('0-15','15-30','30-45','45-60') NOT NULL DEFAULT '0-15',
 *   `day-name` enum('Sun','Sat','Mon','Tue','Wed','Thu','Fri') NOT NULL DEFAULT 'Sun',
 *   `stat` float(22,9) NOT NULL DEFAULT '0.000000000',
 *   `adverage` float(22,9) NOT NULL DEFAULT '0.000000000',
 *   `stdev` float(22,9) NOT NULL DEFAULT '0.000000000',
 *   PRIMARY KEY (`id`),
 *   KEY `SEARCH` (`key`,`year`,`month`,`day`,`week`,`hour`,`minute`,`quarter`,`day-name`) USING BTREE KEY_BLOCK_SIZE=32
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentStatistics extends consentXoopsObject
{

	var $handler = 'consentStatisticsHandler';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('id', XOBJ_DTYPE_INT, null, false);
        self::initVar('fontid', XOBJ_DTYPE_INT, null, false);
        self::initVar('value', XOBJ_DTYPE_INT, null, false);
        
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for Statistics
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentStatisticsHandler extends consentXoopsObjectHandler
{
	

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_statistics';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentStatistics';
	
	/**
	 * Child Object Identity Key
	 *
	 * @var string
	 */
	var $identity = 'id';
	
	/**
	 * Child Object Default Envaluing Costs
	 *
	 * @var string
	 */
	var $envalued = 'value';
	
    function __construct(&$db) 
    {
    	if (!is_object($db))
    		$db = $GLOBAL["xoopsDB"];
        parent::__construct($db, $this->tbl, $this->child, $this->identity, $this->envalued);
    }
}
?>