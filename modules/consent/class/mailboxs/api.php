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

class ConsentMailApi {

  private $host;
  private $user;
  private $pass;
  private $port;
  private $folder;
  private $ssl;

  private $baseAddress;
  private $address;
  private $mailbox;

  /**
   * Called when the Imap object is created.
   *
   * Sample of a complete address: {imap.gmail.com:993/imap/ssl}INBOX
   *
   * @param $host (string)
   *   The IMAP hostname. Example: imap.gmail.com
   * @param $port (int)
   *   Example: 933
   * @param $ssl (bool)
   *   TRUE to use SSL, FALSE for no SSL.
   * @param $folder (string)
   *   IMAP Folder to open.
   * @param $user (string)
   *   Username used for connection. Gmail uses full username@gmail.com, but
   *   many providers simply use username.
   * @param $pass (string)
   *   Account password.
   *
   * @return (empty)
   */
  public function __construct($host, $user, $pass, $port, $ssl = true, $folder = 'INBOX') {
    if ((!isset($host)) || (!isset($user)) || (!isset($pass)) || (!isset($port))) {
      throw new Exception("Error: All Constructor values require a non NULL input.");
    }

    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
    $this->port = $port;
    $this->folder = $folder;
    $this->ssl = $ssl;

    $this->changeLoginInfo($host, $user, $pass, $port, $ssl, $folder);
  }

  /**
   * Change IMAP folders and reconnect to the server.
   *
   * @param $folderName
   *   The name of the folder to change to.
   *
   * @return (empty)
   */
  public function changeFolder($folderName) {
   
  }

  /**
   * Log into an IMAP server.
   *
   * This method is called on the initialization of the class (see
   * __construct()), and whenever you need to log into a different account.
   *
   * Consent see __construct() for parameter info.
   *
   * @return (empty)
   *
   * @throws Exception when IMAP can't connect.
   */
  public function changeLoginInfo($host, $user, $pass, $port, $ssl, $folder) {
    
  }

  /**
   * Returns an associative array with detailed information about a given
   * message.
   *
   * @param $messageId (int)
   *   Message id.
   *
   * @return Associative array with keys (strings unless otherwise noted):
   *   raw_header
   *   to
   *   from
   *   cc
   *   bcc
   *   reply_to
   *   sender
   *   date_sent
   *   subject
   *   deleted (bool)
   *   answered (bool)
   *   draft (bool)
   *   body
   *   original_encoding
   *   size (int)
   *   auto_response (bool)
   *
   * @throws Exception when message with given id can't be found.
   */
  public function getMessage($messageId) {
   
  }

  /**
   * Deletes an email matching the specified $messageId.
   *
   * @param $messageId (int)
   *   Message id.
   * @param $immediate (bool)
   *   Set TRUE if message should be deleted immediately. Otherwise, message
   *   will not be deleted until disconnect() is called. Normally, this is a
   *   bad idea, as other message ids will change if a message is deleted.
   *
   * @return (empty)
   *
   * @throws Exception when message can't be deleted.
   */
  public function deleteMessage($messageId, $immediate = FALSE) {
   
  }

  /**
   * Moves an email into the given mailbox.
   *
   * @param $messageId (int)
   *   Message id.
   * @param $folder (string)
   *   The name of the folder (mailbox) into which messages should be moved.
   *   $folder could either be the folder name or 'INBOX.foldername'.
   *
   * @return (bool)
   *   Returns TRUE on success, FALSE on failure.
   */
  public function moveMessage($messageId, $folder) {
    
  }

  /**
   * Returns an associative array with email subjects and message ids for all
   * messages in the active $folder.
   *
   * @return Associative array with message id as key and subject as value.
   */
  public function getMessageIds() {
   
  }

  /**
   * Return an associative array containing the number of recent, unread, and
   * total messages.
   *
   * @return Associative array with keys:
   *   unread
   *   recent
   *   total
   */
  public function getCurrentMailboxInfo() {
   
  }

  /**
   * Return an array of objects containing mailbox information.
   *
   * @return Array of mailbox names.
   */
  public function getMailboxInfo() {
   
  }


}
