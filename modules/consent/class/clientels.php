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
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'xcp' . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'xcp.class.php');

/**
 * Database Table for Clientels in Legal Consent Module
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_clientels` (
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
class consentClientels extends consentXoopsObject
{

	var $handler = 'consentClientelsHandler';
	
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
 * Handler Class for Clientels
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentClientelsHandler extends consentXoopsObjectHandler
{
	
    /**
     *
     * @var integer
     */
    var $created = 0;
    
    /**
     *
     * @var integer
     */
    var $existing = 0;
    
	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_clientels';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentClientels';
	
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
    
    /**
     * Inserts a New Clientel
     *
     * @param consentClientels $object
     * @param string $force
     * @return unknown
     */
    public static function insert(consentClientels $object, $force = true)
    {
        if ($object->isNew())
        {
            $criteria = new CriteriaCompo(new Criteria('name', $object->getVar('name')));
            $criteria->add(new Criteria('email', $object->getVar('email')));
            $criteria->add(new Criteria('phone', $object->getVar('phone')));
            $criteria->add(new Criteria('uid', $object->getVar('uid')));
            if ($this->getCount($criteria)>0)
            {
                $objs = $this->getObjects($criteria);
                if (is_object($objs[0]) && isset($objs[0]))
                {
                    $this->existing++;
                    return $objs[0]->getVar($this->identity);
                }
            }
            $this->created++;
            $object->setVar('created', time());
            $crc = new xcp($data = $this->created.$object->getVar('uid').$object->getVar('created').$object->getVar('name').$object->getVar('email').$object->getVar('phone'), mt_rand(0,255), mt_rand(4,10));
            $object->setVar('hashkey', $crc->crc);
        }
        return parent::insert($object, $force);
    }
}
?>