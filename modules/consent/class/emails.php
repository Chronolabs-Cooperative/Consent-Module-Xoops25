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

if (!defined('_MD_CONSENT_MODULE_DIRNAME')) {
	return false;
}

//*
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'objects.php');

/**
 * Database Table for Emails in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_emails` (
 *   `id` int(32) NOT NULL AUTO_INCREMENT,
 *   `approval` enum('Delivered','Undelivered','Unknown') NOT NULL DEFAULT 'Unknown',
 *   `email-type` enum('Agreement','Reminder','Recovery','Progress','Unknown') NOT NULL DEFAULT 'Unknown',
 *   `email-target` enum('Batch','Gardian','Clientel','Webmaster','Unknown') NOT NULL DEFAULT 'Unknown',
 *   `agreement-id` int(20) NOT NULL DEFAULT '0',
 *   `batch-id` int(20) NOT NULL DEFAULT '0',
 *   `gardian-id` int(20) NOT NULL DEFAULT '0',
 *   `clientel-id` int(20) NOT NULL DEFAULT '0',
 *   `email` varchar(196) NOT NULL DEFAULT '',
 *   `referee` varchar(18) NOT NULL DEFAULT '',
 *   `created` int(11) NOT NULL DEFAULT '0',
 *   `timeout` int(11) NOT NULL DEFAULT '0',
 *   `checked` int(11) NOT NULL DEFAULT '0',
 *   PRIMARY KEY (`id`),
 *   KEY `SEARCH` (`approval`,`email-type`,`email-target`,`email`) USING BTREE KEY_BLOCK_SIZE=32
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentEmails extends consentXoopsObject
{

	var $handler = 'consentEmailsHandler';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('id', XOBJ_DTYPE_INT, null, false);
        self::initVar('approval', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'approval'));
        self::initVar('email-type', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'email-type'));
        self::initVar('email-target', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'email-target'));
        self::initVar('agreement-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('batch-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('gardian-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 196);
        self::initVar('referee', XOBJ_DTYPE_TXTBOX, null, false, 18);
        self::initVar('created', XOBJ_DTYPE_INT, null, false);
        self::initVar('timeout', XOBJ_DTYPE_INT, null, false);
        self::initVar('checked', XOBJ_DTYPE_INT, null, false);
        
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for Emails
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentEmailsHandler extends consentXoopsObjectHandler
{
	

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_emails';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentEmails';
	
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