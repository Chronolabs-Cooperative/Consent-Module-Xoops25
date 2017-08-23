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

// Index Consent Subscription Form
define('_MN_CONSENT_INDEX_H1','Subcription to Consent for Gardian + Clientel');
define('_MN_CONSENT_INDEX_P1','Below is a form that you will be able to subscribe to the guardian consent agreements on this site, you will be able to fill this form out per youth or young adult you are getting or giving consent for the adult based workshops, classes or roles in this agreement, fill out the subscription form below as you see fit!');
define('_MN_CONSENT_INDEX_H2','Errors made on Form');
define('_MN_CONSENT_INDEX_P2','Make sure you have all the details above correct before you submit this form, it will email you the consent forms one of each for the guardian and one for the clientel to return either by email or the upload link...');

// Guardian+Clientel Consent Single Subscription Form
define('_MN_CONSENT_FORM_SUBCRIPTION','New Consent Agreement Subscription');
define('_MN_CONSENT_FORM_GUARDIAN_NAME','Guardian\'s Name');
define('_MN_CONSENT_FORM_GUARDIAN_NAME_DESC','This is at least first + last name of the guardian representing the client');
define('_MN_CONSENT_FORM_GUARDIAN_EMAIL','Guardian\'s eMail');
define('_MN_CONSENT_FORM_GUARDIAN_EMAIL_DESC','This is the eMail for the guardian');
define('_MN_CONSENT_FORM_GUARDIAN_PHONE','Guardian\'s Phone');
define('_MN_CONSENT_FORM_GUARDIAN_PHONE_DESC','This is the phone number for the guardian (min. 10 numbers)');
define('_MN_CONSENT_FORM_CLIENTEL_NAME','Clientel\'s Name');
define('_MN_CONSENT_FORM_CLIENTEL_NAME_DESC','This is at least first + last name of the client repesented by the guardian');
define('_MN_CONSENT_FORM_CLIENTEL_EMAIL','Clientel\'s eMail');
define('_MN_CONSENT_FORM_CLIENTEL_EMAIL_DESC','This is the eMail for the client that is the youth consentee');
define('_MN_CONSENT_FORM_CLIENTEL_PHONE','Clientel\'s Phone');
define('_MN_CONSENT_FORM_CLIENTEL_PHONE_DESC','This is the phone number for the clientel (min. 10 numbers)');
define('_MN_CONSENT_FORM_TIMEOUT','Event Consent Timeout');
define('_MN_CONSENT_FORM_TIMEOUT_DESC','This is the absolute date all consent forms must be returned by');
define('_MN_CONSENT_FORM_CALLBACK_URL','URL recieving API callback notifications');
define('_MN_CONSENT_FORM_CALLBACK_URL_DESC','This is a URL which recieves peroidically api calls for notifications to do with this agreement.<br /><br />You can see the example of the callbacks recieved with the following example: <a href="%s" target="_blank">callback-examples.php</a>!');