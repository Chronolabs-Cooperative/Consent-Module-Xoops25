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
 *   `batches` int(11) NOT NULL DEFAULT '0',
 *   `gardians-created` int(11) NOT NULL DEFAULT '0',
 *   `clientel-created` int(11) NOT NULL DEFAULT '0',
 *   `gardians-existed` int(11) NOT NULL DEFAULT '0',
 *   `clientel-existed` int(11) NOT NULL DEFAULT '0',
 *   `batches-failed` int(11) NOT NULL DEFAULT '0',
 *   `gardians-failed` int(11) NOT NULL DEFAULT '0',
 *   `clientel-failed` int(11) NOT NULL DEFAULT '0',
 *   `batches-approved` int(11) NOT NULL DEFAULT '0',
 *   `gardians-approved` int(11) NOT NULL DEFAULT '0',
 *   `clientel-approved` int(11) NOT NULL DEFAULT '0',
 *   `batches-unapproved` int(11) NOT NULL DEFAULT '0',
 *   `gardians-unapproved` int(11) NOT NULL DEFAULT '0',
 *   `clientel-unapproved` int(11) NOT NULL DEFAULT '0',
 *   `batches-recovery` int(11) NOT NULL DEFAULT '0',
 *   `gardians-recovery` int(11) NOT NULL DEFAULT '0',
 *   `clientel-recovery` int(11) NOT NULL DEFAULT '0',
 *   `batches-recovered` int(11) NOT NULL DEFAULT '0',
 *   `gardians-recovered` int(11) NOT NULL DEFAULT '0',
 *   `clientel-recovered` int(11) NOT NULL DEFAULT '0',
 *   `approvals` int(11) NOT NULL DEFAULT '0',
 *   `reminders` int(11) NOT NULL DEFAULT '0',
 *   `recovery` int(11) NOT NULL DEFAULT '0',
 *   `created` int(11) NOT NULL DEFAULT '0',
 *   `timeout` int(11) NOT NULL DEFAULT '0',
 *   `reported` int(11) NOT NULL DEFAULT '0',
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