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
 * Database Table for Clientel in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_clientel` (
 *   `id` int(20) NOT NULL AUTO_INCREMENT,
 *   `uid` int(13) NOT NULL DEFAULT '0',
 *   `hashkey` varchar(12) NOT NULL DEFAULT '',
 *   `name` varchar(64) NOT NULL DEFAULT '',
 *   `email` varchar(196) NOT NULL DEFAULT '',
 *   `phone` varchar(20) NOT NULL DEFAULT '',
 *   `created` int(11) NOT NULL DEFAULT '0',
 *   `emailed` int(11) NOT NULL DEFAULT '0',
 *   `response` int(11) NOT NULL DEFAULT '0',
 *   `undelivered` int(11) NOT NULL DEFAULT '0',
 *   `recovered` int(11) NOT NULL DEFAULT '0',
 *   `recovery-id` int(20) NOT NULL DEFAULT '0',
 *   `agreement-ids` longtext,
 *   `email-views` int(11) NOT NULL DEFAULT '0',
 *   `email-viewed` int(11) NOT NULL DEFAULT '0',
 *   PRIMARY KEY (`id`),
 *   KEY `SEARCH` (`hashkey`,`name`,`email`,`phone`) USING BTREE KEY_BLOCK_SIZE=32
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentClientel extends consentXoopsObject
{

	var $handler = 'consentClientelHandler';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('id', XOBJ_DTYPE_INT, null, false);
        self::initVar('uid', XOBJ_DTYPE_INT, null, false);
        self::initVar('hashkey', XOBJ_DTYPE_TXTBOX, null, false, 12);
        self::initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 64);
        self::initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 196);
        self::initVar('phone', XOBJ_DTYPE_TXTBOX, null, false, 20);
        self::initVar('created', XOBJ_DTYPE_INT, null, false);
        self::initVar('emailed', XOBJ_DTYPE_INT, null, false);
        self::initVar('response', XOBJ_DTYPE_INT, null, false);
        self::initVar('undelivered', XOBJ_DTYPE_INT, null, false);
        self::initVar('recovered', XOBJ_DTYPE_INT, null, false);
        self::initVar('recovery-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('agreement-ids', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('email-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-viewed', XOBJ_DTYPE_INT, null, false);
        
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for Clientel
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentClientelHandler extends consentXoopsObjectHandler
{
	

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_clientel';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentClientel';
	
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