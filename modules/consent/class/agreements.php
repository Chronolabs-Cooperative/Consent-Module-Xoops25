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
 * Database Table for Agreements in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_agreements` (
 *   `id` int(32) NOT NULL AUTO_INCREMENT,
 *   `uid` int(13) NOT NULL DEFAULT '0',
 *   `approval` enum('Waiting','Approved','Unapproved') NOT NULL DEFAULT 'Waiting',
 *   `batch-id` int(20) NOT NULL DEFAULT '0',
 *   `gardian-id` int(20) NOT NULL DEFAULT '0',
 *   `clientel-id` int(20) NOT NULL DEFAULT '0',
 *   `hashkey` varchar(12) NOT NULL DEFAULT '',
 *   `referee` varchar(18) NOT NULL DEFAULT '',
 *   `callback-url` varchar(255) NOT NULL DEFAULT '',
 *   `svn-path` varchar(255) NOT NULL DEFAULT '',
 *   `gardian-filename-pdf` varchar(128) NOT NULL DEFAULT '',
 *   `clientel-filename-pdf` varchar(128) NOT NULL DEFAULT '',
 *   `gardian-response-file` varchar(128) NOT NULL DEFAULT '',
 *   `clientel-response-file` varchar(128) NOT NULL DEFAULT '',
 *   `response-waiting` enum('Gardian','Clientel','Both') NOT NULL DEFAULT 'Both',
 *   `response-sourced` enum('Gardian','Clientel','Both') NOT NULL DEFAULT 'Both',
 *   `response-comment` mediumtext,
 *   `response-network` mediumtext,
 *   `response-notified` int(11) NOT NULL DEFAULT '0',
 *   `response-weight` int(11) NOT NULL DEFAULT '0',
 *   `response-gardian-weight` int(11) NOT NULL DEFAULT '0',
 *   `response-clientel-weight` int(11) NOT NULL DEFAULT '0',
 *   `email-ids` mediumtext,
 *   `email-agreement-type` enum('None','Gardian','Clientel','Both') NOT NULL DEFAULT 'Both',
 *   `email-recovery-type` enum('None','Gardian','Clientel','Batch') NOT NULL DEFAULT 'None',
 *   `email-recovery-guardian-sent` int(11) NOT NULL DEFAULT '0',
 *   `email-recovery-clientel-sent` int(11) NOT NULL DEFAULT '0',
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
 *   `created` int(11) NOT NULL DEFAULT '0',
 *   `emailed` int(11) NOT NULL DEFAULT '0',
 *   `response` int(11) NOT NULL DEFAULT '0',
 *   `recovery` int(11) NOT NULL DEFAULT '0',
 *   `reminde` int(11) NOT NULL DEFAULT '0',
 *   `timeout` int(11) NOT NULL DEFAULT '0',
 *   PRIMARY KEY (`id`),
 *   KEY `SEARCH` (`approval`,`batch-id`,`gardian-id`,`clientel-id`,`hashkey`,`email-agreement-type`,`created`,`emailed`,`response`,`reminde`,`timeout`) USING BTREE KEY_BLOCK_SIZE=32
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentAgreements extends consentXoopsObject
{

	var $handler = 'consentAgreementsHandler';
	
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
 * Handler Class for Agreements
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentAgreementsHandler extends consentXoopsObjectHandler
{
	

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_agreements';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentAgreements';
	
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