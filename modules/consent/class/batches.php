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
 * Database Table for Batches in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_batches` (
 *   `id` int(20) NOT NULL AUTO_INCREMENT,
 *   `type` enum('Collect','CSV','None') NOT NULL DEFAULT 'None',
 *   `mailbox-id` int(13) NOT NULL DEFAULT '0',
 *   `uid` int(13) NOT NULL DEFAULT '0',
 *   `hashkey` varchar(12) NOT NULL DEFAULT '',
 *   `referee` varchar(18) NOT NULL DEFAULT '',
 *   `org` varchar(64) NOT NULL DEFAULT '',
 *   `name` varchar(64) NOT NULL DEFAULT '',
 *   `email` varchar(196) NOT NULL DEFAULT '',
 *   `phone` varchar(20) NOT NULL DEFAULT '',
 *   `message` mediumtext,
 *   `event` mediumtext,
 *   `cc` mediumtext,
 *   `bcc` mediumtext,
 *   `callback-url` varchar(255) NOT NULL DEFAULT '',
 *   `email-agreement-type` enum('Gardian','Clientel','Both') NOT NULL DEFAULT 'Both',
 *   `csv-lines` int(11) NOT NULL DEFAULT '0',
 *   `csv-bytes` int(11) NOT NULL DEFAULT '0',
 *   `csv-md5` varchar(32) NOT NULL DEFAULT ',',
 *   `csv-field` varchar(8) NOT NULL DEFAULT ',',
 *   `csv-terminated` varchar(8) NOT NULL DEFAULT '\n',
 *   `csv-string` varchar(8) NOT NULL DEFAULT '"',
 *   `response-weight` int(11) NOT NULL DEFAULT '0',
 *   `response-gardian-weight` int(11) NOT NULL DEFAULT '0',
 *   `response-clientel-weight` int(11) NOT NULL DEFAULT '0',
 *   `email-from` varchar(64) NOT NULL DEFAULT '',
 *   `email-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-views` int(11) NOT NULL DEFAULT '0',
 *   `email-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-gardian-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-gardian-views` int(11) NOT NULL DEFAULT '0',
 *   `email-gardian-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-clientel-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-clientel-views` int(11) NOT NULL DEFAULT '0',
 *   `email-clientel-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-remiders-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-remiders-views` int(11) NOT NULL DEFAULT '0',
 *   `email-remiders-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-progress-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-progress-views` int(11) NOT NULL DEFAULT '0',
 *   `email-progress-viewed` int(11) NOT NULL DEFAULT '0',
 *   `email-recovery-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-recovery-views` int(11) NOT NULL DEFAULT '0',
 *   `email-recovery-viewed` int(11) NOT NULL DEFAULT '0',
 *   `agreements-created` int(11) NOT NULL DEFAULT '0',
 *   `gardians-created` int(11) NOT NULL DEFAULT '0',
 *   `clientel-created` int(11) NOT NULL DEFAULT '0',
 *   `gardians-existed` int(11) NOT NULL DEFAULT '0',
 *   `clientel-existed` int(11) NOT NULL DEFAULT '0',
 *   `agreements-failed` int(11) NOT NULL DEFAULT '0',
 *   `gardians-failed` int(11) NOT NULL DEFAULT '0',
 *   `clientel-failed` int(11) NOT NULL DEFAULT '0',
 *   `agreements-approved` int(11) NOT NULL DEFAULT '0',
 *   `gardians-approved` int(11) NOT NULL DEFAULT '0',
 *   `clientel-approved` int(11) NOT NULL DEFAULT '0',
 *   `agreements-unapproved` int(11) NOT NULL DEFAULT '0',
 *   `gardians-unapproved` int(11) NOT NULL DEFAULT '0',
 *   `clientel-unapproved` int(11) NOT NULL DEFAULT '0',
 *   `agreements-recovery` int(11) NOT NULL DEFAULT '0',
 *   `gardians-recovery` int(11) NOT NULL DEFAULT '0',
 *   `clientel-recovery` int(11) NOT NULL DEFAULT '0',
 *   `agreements-recovered` int(11) NOT NULL DEFAULT '0',
 *   `gardians-recovered` int(11) NOT NULL DEFAULT '0',
 *   `clientel-recovered` int(11) NOT NULL DEFAULT '0',
 *   `approvals` int(11) NOT NULL DEFAULT '0',
 *   `reminders` int(11) NOT NULL DEFAULT '0',
 *   `recovery` int(11) NOT NULL DEFAULT '0',
 *   `created` int(11) NOT NULL DEFAULT '0',
 *   `timeout` int(11) NOT NULL DEFAULT '0',
 *   `reported` int(11) NOT NULL DEFAULT '0',
 *   `reporting` int(11) NOT NULL DEFAULT '0',
 *   PRIMARY KEY (`id`),
 *   KEY `SEARCH` (`hashkey`,`email`,`timeout`) USING BTREE KEY_BLOCK_SIZE=32
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentBatches extends consentXoopsObject
{

	var $handler = 'consentBatchesHandler';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('id', XOBJ_DTYPE_INT, null, false);
        self::initVar('type', XOBJ_DTYPE_ENUM, 'Waiting', false, false, false, consentEnumeratorValues(basename(__FILE__), 'type'));
        self::initVar('mailbox-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('uid', XOBJ_DTYPE_INT, null, false);
        self::initVar('hashkey', XOBJ_DTYPE_TXTBOX, null, false, 12);
        self::initVar('referee', XOBJ_DTYPE_TXTBOX, null, false, 18);
        self::initVar('org', XOBJ_DTYPE_TXTBOX, null, false, 64);
        self::initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 64);
        self::initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 12);
        self::initVar('phone', XOBJ_DTYPE_TXTBOX, null, false, 18);
        self::initVar('message', XOBJ_DTYPE_ARRAY, null, false);
        self::initVar('event', XOBJ_DTYPE_OTHER, null, false);
        self::initVar('cc', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('bcc', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('callback-url', XOBJ_DTYPE_TXTBOX, null, false, 255);
        self::initVar('email-agreement-type', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'email-agreement-type'));
        self::initVar('csv-lines', XOBJ_DTYPE_INT, null, false);
        self::initVar('csv-bytes', XOBJ_DTYPE_INT, null, false);
        self::initVar('csv-md5', XOBJ_DTYPE_TXTBOX, null, false, 32);
        self::initVar('csv-field', XOBJ_DTYPE_TXTBOX, ",", false, 8);
        self::initVar('csv-terminated', XOBJ_DTYPE_TXTBOX, "\n", false, 8);
        self::initVar('csv-string', XOBJ_DTYPE_TXTBOX, '"', false, 8);
        self::initVar('response-weight', XOBJ_DTYPE_INT, null, false);
        self::initVar('response-gardian-weight', XOBJ_DTYPE_INT, null, false);
        self::initVar('response-clientel-weight', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-from', XOBJ_DTYPE_TXTBOX, null, false, 64);
        self::initVar('email-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-gardian-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-gardian-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-gardian-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-clientel-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-clientel-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-clientel-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-remiders-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-remiders-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-remiders-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-progress-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-progress-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-progress-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-recovery-sent', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-recovery-views', XOBJ_DTYPE_INT, null, false);
        self::initVar('email-recovery-viewed', XOBJ_DTYPE_INT, null, false);
        self::initVar('agreements-created', XOBJ_DTYPE_INT, null, false);
        self::initVar('gardians-created', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-created', XOBJ_DTYPE_INT, null, false);
        self::initVar('gardians-existed', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-existed', XOBJ_DTYPE_INT, null, false);
        self::initVar('agreements-failed', XOBJ_DTYPE_INT, null, false);
        self::initVar('gardians-failed', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-failed', XOBJ_DTYPE_INT, null, false);
        self::initVar('agreements-approved', XOBJ_DTYPE_INT, null, false);
        self::initVar('gardians-approved', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-approved', XOBJ_DTYPE_INT, null, false);
        self::initVar('agreements-unapproved', XOBJ_DTYPE_INT, null, false);
        self::initVar('gardians-unapproved', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-unapproved', XOBJ_DTYPE_INT, null, false);
        self::initVar('agreements-recovery', XOBJ_DTYPE_INT, null, false);
        self::initVar('gardians-recovery', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-recovery', XOBJ_DTYPE_INT, null, false);
        self::initVar('agreements-recovered', XOBJ_DTYPE_INT, null, false);
        self::initVar('gardians-recovered', XOBJ_DTYPE_INT, null, false);
        self::initVar('clientel-recovered', XOBJ_DTYPE_INT, null, false);
        self::initVar('approvals', XOBJ_DTYPE_INT, null, false);
        self::initVar('reminders', XOBJ_DTYPE_INT, null, false);
        self::initVar('recovery', XOBJ_DTYPE_INT, null, false);
        self::initVar('created', XOBJ_DTYPE_INT, null, false);
        self::initVar('timeout', XOBJ_DTYPE_INT, null, false);
        self::initVar('reported', XOBJ_DTYPE_INT, null, false);
        self::initVar('reporting', XOBJ_DTYPE_INT, null, false);
        
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for Batches
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentBatchesHandler extends consentXoopsObjectHandler
{
	

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_batches';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentBatches';
	
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