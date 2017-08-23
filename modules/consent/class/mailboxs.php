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


if (!defined('_MI_CONSENT_MODULE_DIRNAME')) {
	return false;
}

//*
require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php');
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'objects.php');
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'mailboxs' . DIRECTORY_SEPARATOR . 'api.php');
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'mailboxs' . DIRECTORY_SEPARATOR . 'imap.php');

/**
 * Class for Mailboxs in consent email ticketer
 *
 * For Table:-
 * <code>
 * CREATE TABLE `consent_mailboxs` (
 *   `id` int(14) unsigned NOT NULL AUTO_INCREMENT,
 *   `email` varchar(196) DEFAULT '',
 *   `host-imap` varchar(300) DEFAULT '',
 *   `host-smtp` varchar(300) DEFAULT '',
 *   `username` varchar(198) DEFAULT '',
 *   `password` varchar(198) DEFAULT '',
 *   `port-imap` int(12) DEFAULT '993',
 *   `port-smtp` int(12) DEFAULT '25',
 *   `folders` mediumtext,
 *   `ssl` enum('Yes','No') DEFAULT 'Yes',
 *   `method` enum('IMAP+SMTP','API') DEFAULT 'IMAP+SMTP',
 *   `attachments` enum('Yes','No') DEFAULT 'Yes',
 *   `signature` enum('Both','Staff','Manager','Department','None') DEFAULT 'Both',
 *   `collect` enum('Yes','No') DEFAULT 'Yes',
 *   `images` enum('Yes','No') DEFAULT 'Yes',
 *   `uids` LONGTEXT,
 *   `agreements-id` LONGTEXT,
 *   `guardians-id` LONGTEXT,
 *   `clientels-id` LONGTEXT,
 *   `sent-emails-id` LONGTEXT,
 *   `mimetypes-id` LONGTEXT,
 *   `sent-emails` int(12) DEFAULT '0',
 *   `recieved-emails` int(12) DEFAULT '0',
 *   `errors` int(12) DEFAULT '0',
 *   `keywords` int(12) DEFAULT '0',
 *   `last-email-id` int(32) DEFAULT '0',
 *   `waiting` int(12) DEFAULT '540',
 *   `created` int(12) DEFAULT '0',
 *   `errored` int(12) DEFAULT '0',
 *   `action` int(12) DEFAULT '0',
 *   PRIMARY KEY (`id`),
 *   KEY `SEARCH` (`errored`,`action`,`waiting`,`uids`(18),`agreements-ids`(18),`guardians-ids`(18),`clientels-ids`(18),`last-emails-id`(24))
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </code>
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentMailboxs extends consentXoopsObject
{

	var $handler = '';
	
    function __construct($id = null)
    {   	
    	
        self::initVar('id', XOBJ_DTYPE_INT, null, false);
        self::initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 300);
        self::initVar('host-imap', XOBJ_DTYPE_TXTBOX, null, false, 300);
        self::initVar('host-smtp', XOBJ_DTYPE_TXTBOX, null, false, 300);
        self::initVar('username', XOBJ_DTYPE_TXTBOX, null, false, 198);
        self::initVar('password', XOBJ_DTYPE_TXTBOX, null, false, 198);
        self::initVar('port-imap', XOBJ_DTYPE_INT, 993, false);
        self::initVar('port-smtp', XOBJ_DTYPE_INT, 25, false);
        self::initVar('folders', XOBJ_DTYPE_ARRAY, array('INBOX'=>0), false);
        self::initVar('ssl', XOBJ_DTYPE_ENUM, 'Yes', false, false, false, consentEnumeratorValues(basename(__FILE__), 'ssl'));
        self::initVar('method', XOBJ_DTYPE_ENUM, 'IMAP', false, false, false, consentEnumeratorValues(basename(__FILE__), 'method'));
        self::initVar('attachments', XOBJ_DTYPE_ENUM, 'Yes', false, false, false, consentEnumeratorValues(basename(__FILE__), 'attachments'));
        self::initVar('signature', XOBJ_DTYPE_ENUM, 'Both', false, false, false, consentEnumeratorValues(basename(__FILE__), 'signature'));
        self::initVar('collect', XOBJ_DTYPE_ENUM, 'Yes', false, false, false, consentEnumeratorValues(basename(__FILE__), 'collect'));
        self::initVar('images', XOBJ_DTYPE_ENUM, 'Yes', false, false, false, consentEnumeratorValues(basename(__FILE__), 'images'));
        self::initVar('uids', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('agreements-id', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('guardians-id', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('clientels-id', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('last-emails-id', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('mimetypes-id', XOBJ_DTYPE_ARRAY, array(), false);
        self::initVar('sent-emails', XOBJ_DTYPE_INT, null, false);
        self::initVar('recieved-emails', XOBJ_DTYPE_INT, null, false);
        self::initVar('errors', XOBJ_DTYPE_INT, null, false);
        self::initVar('keywords', XOBJ_DTYPE_INT, null, false);
        self::initVar('last-email-id', XOBJ_DTYPE_INT, null, false);
        self::initVar('waiting', XOBJ_DTYPE_INT, $consentConfigsList['default-waiting'], false);
        self::initVar('created', XOBJ_DTYPE_INT, time(), false);
        self::initVar('errored', XOBJ_DTYPE_INT, null, false);
        self::initVar('action', XOBJ_DTYPE_INT, time(), false);
        
        $this->handler = __CLASS__ . 'Handler';
        if (!empty($id) && !is_null($id))
        {
        	$handler = new $this->handler;
        	self::assignVars($handler->get($id)->getValues(array_keys($this->vars)));
        }
        
    }

}


/**
 * Handler Class for Mailboxs in consent email ticketer
 * @author Simon Roberts (wishcraft@users.sourceforge.net)
 * @copyright copyright (c) 2015 labs.coop
 */
class consentMailboxsHandler extends consentXoopsObjectHandler
{
	

	/**
	 * Table Name without prefix used
	 * 
	 * @var string
	 */
	var $tbl = 'consent_mailboxs';
	
	/**
	 * Child Object Handling Class
	 *
	 * @var string
	 */
	var $child = 'consentMailboxs';
	
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
	var $envalued = 'last-email-id';
	
    function __construct(&$db) 
    {
    	if (!object($db))
    		$db = $GLOBAL["xoopsDB"];
        parent::__construct($db, self::$tbl, self::$child, self::$identity, self::$envalued);
    }
    
    /**
     * Checks Mailboxes for new Tickets or attach or reply further data
     * 
     * @return boolean
     */
    function getEmailTickets()
    {
    	$sql = "SELECT `id` FROM `" . $this->db->prefix($this->tbl) . "` WHERE `action` + `waiting` < ".time()." OR  `errored` + (`waiting`*5) < " . time();
    	$mailboxes=array();
    	$result = $this->db->queryF($sql);
    	while($row = $this->db->fetchArray($result))
    	{
    		$mailboxes[$row['id']] = $this->get($row['id']);
    	}
    	if (count($mailboxes)>0)
    	{
    		foreach($mailboxes as $mid => $mailbox)
    		{
    			try {
    				switch ($mailbox->getVar('method'))
    				{
    					case "IMAP":
    						$mapi = "consentMailImap";
    						break;
    					case "API":
    						$mapi = "consentMailApi";
    						break;
    				}
    				$folders = $mailbox->getVar('folders');
    				foreach($mailbox->getVar('folders') as $folder => $lastmessageid)
    				{
    					$mail = new $mapi($mailbox->getVar('host'), $mailbox->getVar('username'), $mailbox->getVar('password'), $mailbox->getVar('port'), ($mailbox->getVar('ssl')=='Yes'?true:false), $folder);
    					if (is_a($mail, $mapi) && is_object($mail))
    					{
    						foreach($mail->getMessageIds() as $msgid => $subject)
    						{
    							if ($lastmessageid<$msgid)
    							{
    								$folders[$folder] = $msgid;
    								$email = $mail->getMessage($msgid);
    								if (is_array($email) && !empty($email))
    								{
    									if ($mailbox->getVar('wammy')=='Yes')
    									{
    										$wammy = 	json_decode(	getURIData($mailbox->getVar('wammy-uri').'/v3/'.$mailbox->getVar('id').$msgid.'/test.api', 
    																	array(	'usernames' => array('sender'=>md5($email['from']), 'recipient' => md5($email['to'])),
    																			'emails' => array('sender'=>$email['from'], 'recipient' => $email['to']),
    																			'sender-ip' => gethostbyname($mailbox->getVar('host')), 'subject' => $subject,
    																			'message' => $email['body'], 'mimetype' => 'text/html', 'mode' => 'json'   																		
    													)));
    									} else 
    										$wammy = array('result'=>'unknown');
    									$newticket = true;
    									$ticketid = 0;
    									$subjectid = 0;
    									foreach(array_keys($ticketkeys) as $key => $ticket)
    									{
    										if ($ticketid == 0 && (strpos(strtolower($subject), strtolower($key))>0 || strpos(strtolower($email['body']), strtolower($key))>0))
    										{
    											$ticketid = $ticket->getVar('id');
    											$subjectid = $ticket->getVar('subject-id');
    											$newticket = false;
    											continue;
    										}
    									}
    									if ($subjectid==0)
    									{
    										$subject = $subjectsHandler->create();
    										$subject->setVar('subject', $subject);
    										$subjectid=$subjectsHandler->insert($subject);
    									}
    									$subject = $subjectsHandler->get($subjectid);
    									
    									switch($wammy['result'])
    									{
    										case "spam":
    											
    											if ($ticketid==0)
    											{
    												$newticket = true;
    												$ticket = $ticketsHandler->create();
    												$ticket->setVar('state', 'spam');
    												$ticket->setVar('created', time());
    												$ticket->setVar('subject-id', $subject->getVar('id'));
    												$ticketid = $ticketsHandler->insert($ticket, true);
    											}
    											break;
    									
    										default:
    											
    											
    											if ($ticketid==0)
    											{
    												$newticket = true;
    												$ticket = $ticketsHandler->create();
    												$ticket->setVar('state', 'new');
    												$ticket->setVar('created', time());
    												$ticket->setVar('subject-id', $subject->getVar('id'));
    												$ticketid = $ticketsHandler->insert($ticket, true);
    											}
    											$ticket = $ticketsHandler->get($ticketid);
    											break;
    											
    									}
    									if (count($email['attachments']))
    									{
    										foreach($email['attachments'] as $key => $attachment)
    										{
    											if (isset($attachment['mimetype']) && (strpos(' '.strtolower($attachment['mimetype']), 'image') || strpos(' '.strtolower($attachment['mimetype']), 'img')))
    											{
    												if ($imagesHandler->imageExists($attachment['md5'], false)==false)
    												{
    													$img = $imagesHandler->create();
    														
    												} else
    													$email['attachments'][$key]['object'] = $imagesHandler->imageExists($attachment['md5'], true);
    											}
    										}
    									}
    								}
    							}
    						}
    					} else {
    						if (count($folders)>0)
    							$mailbox->setVar('folders', $folders);
    						$mailbox->setVar('errors', $mailbox->getVar('errors')+1);
    						$mailbox->setVar('errored', time());
    						$this->insert($mailbox, true);
    					}
    				}
    				if (count($folders)>0)
    				{
	    				$mailbox->setVar('folders', $folders);
	    				$this->insert($mailbox, true);
    				}
    				
    			}
    			catch(Exception $e)
    			{
    				$mailbox->setVar('errors', $mailbox->getVar('errors')+1);
    				$mailbox->setVar('errored', time());
    				$this->insert($mailbox, true);
    			}
    		}
    	}
    	return false;
    }
}
?>