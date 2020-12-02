<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Library
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL V3 or later; https://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (c) 2020 Steven Palmer All rights reserved.
 *
 * CoalaWeb Library is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

namespace CoalaWeb;

defined('_JEXEC') or die;

use Joomla\CMS\User\UserHelper as UHelp;
use Joomla\CMS\Crypt\Key;
use Joomla\CMS\Crypt\Cipher\SodiumCipher;

/**
 * Class Secure
 * @package CoalaWeb
 */
class Secure
{
    /**
     * Creates one or an array of (pseudo-)random strings
     *
     * @param integer $count
     *
     * @return mixed - if $count is 1, then string else array
     */
    public static function getRandom($count = 1)
    {
        $characters = range('a', 'z');
        $numbers = range(0, 9);
        $pwArray = array();

        for ($i = 0; $i < $count; $i++) {
            $pw = '';

            // first character has to be a letter
            $pw .= $characters[mt_rand(0, 25)];

            // other characters arbitrarily
            $characters = array_merge($characters, $numbers);

            $pwLength = mt_rand(4, 12);

            for ($a = 0; $a < $pwLength; $a++) {
                $pw .= $characters[mt_rand(0, 35)];
            }

            $pwArray[] = $pw;
        }

        if ($count == 1) {
            $pwArray = $pwArray[0];
        }

        return $pwArray;
    }

    /**
     * @param $value
     * @return string
     */
    public static function encrypt($value)
    {
        return base64_encode($value);
    }

    /**
     * @param $value
     * @return false|string
     */
    public static function decrypt($value)
    {
        return base64_decode($value);
    }

    /**
     * @param $length
     * @return mixed
     */
    public static function generateToken($length)
    {
        return UHelp::genRandomPassword($length);
    }

    /**
     * @param $message
     * @param $extension
     * @return string
     */
    public static function letsEncrypt($message, $extension){

        $cipher = new SodiumCipher;

        $key = $cipher->generateKey();
        $nonce = \Sodium\randombytes_buf(\Sodium\CRYPTO_BOX_NONCEBYTES);

        $parts = [
            'extension' => $extension,
            'key_private' => base64_encode($key->private),
            'key_public' => base64_encode($key->public),
            'nonce' => base64_encode($nonce)
        ];
        self::setCipher($parts);

        $stored = self::getCipher($extension);

        $customKey = new Key('sodium');
        $customKey->public = base64_decode($stored->everyone);
        $customKey->private =  base64_decode($stored->shh);

        $cipher->setNonce(base64_decode($stored->nonce));

        $encrypted = base64_encode($cipher->encrypt($message, $customKey));

        // Store the encrypted text
        self::storeEncrypted($encrypted, $extension);

        return $encrypted;

    }

    /**
     * @param $encrypted
     * @param $extension
     * @return mixed
     */
    public static function letsDecrypt($encrypted, $extension)
    {
        $stored = self::getCipher($extension);
        $cipher = new SodiumCipher;
        $customKey = new Key('sodium');
        $customKey->public = base64_decode($stored->everyone);
        $customKey->private =  base64_decode($stored->shh);

        $cipher->setNonce(base64_decode($stored->nonce));
        $foo = base64_decode($encrypted);

        $decrypted = $cipher->decrypt($foo, $customKey);

        return $decrypted;


    }

    /**
     *
     *
     * @param $extension
     * @return  array  The dependencies
     */
    public static function getCipher($extension)
    {
        $cipher = null;

        $db = \JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select(['everyone', 'shh', 'nonce', 'extra_info'])
            ->from($db->qn('#__coalaweb_cipher'))
            ->where($db->qn('extension') . ' = ' . $db->q($extension));
        $db->setQuery($query);

        try {
            // If it fails, it will throw a RuntimeException
            $cipher = $db->loadObject();
        } catch (JDatabaseExceptionExecuting $e) {
        }

        return $cipher;
    }

    /**
     * @param $details
     * @return bool
     */
    public static function setCipher($details)
    {
        if(!$details['key_private'] || !$details['nonce']|| !$details['extension']){
            return false;
        }

        $db = \JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->update($db->qn('#__coalaweb_cipher'));
        $query->set('everyone = ' . $db->q($details['key_public']));
        $query->set('shh = ' . $db->q($details['key_private']));
        $query->set('nonce = ' . $db->q($details['nonce']));
        $query->where('extension = ' . $db->q($details['extension']));

        $db->setQuery($query);

        try {
            $db->execute();
            $extensionUpdated = $db->getAffectedRows();
        } catch (JDatabaseExceptionExecuting $e) {
            return false;

        }

        if (!$extensionUpdated) {
            $query = $db->getQuery(true);

            $columns = array(
                'extension',
                'everyone',
                'shh',
                'nonce'
            );

            $values = array(
                $db->q($details['extension']),
                $db->q($details['key_public']),
                $db->q($details['key_private']),
                $db->q($details['nonce'])
            );

            $query
                ->insert($db->qn('#__coalaweb_cipher'))
                ->columns($db->qn($columns))
                ->values(implode(',', $values));

            $db->setQuery($query);

            try {
                $db->execute();
            } catch (JDatabaseExceptionExecuting $e) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $encrypted
     * @param $extension
     * @return bool
     */
    public static function storeEncrypted($encrypted, $extension)
    {
        if(!$encrypted){
            return false;
        }

        $db = \JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->update($db->qn('#__coalaweb_cipher'));
        $query->set('extra_info = ' . $db->q($encrypted));
        $query->where('extension = ' . $db->q($extension));

        $db->setQuery($query);

        try {
            $db->execute();
            $extensionUpdated = $db->getAffectedRows();
        } catch (JDatabaseExceptionExecuting $e) {
            return false;

        }

        if (!$extensionUpdated) {
            $query = $db->getQuery(true);

            $columns = array(
                'extra_info'
            );

            $values = array(
                $db->q($encrypted)
            );

            $query
                ->insert($db->qn('#__coalaweb_cipher'))
                ->columns($db->qn($columns))
                ->values(implode(',', $values));

            $db->setQuery($query);

            try {
                $db->execute();
            } catch (JDatabaseExceptionExecuting $e) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $extension
     * @return bool
     */
    public static function clearEncrypted($extension)
    {
        $db = \JFactory::getDbo();

        $query = $db->getQuery(true)
            ->delete('#__coalaweb_cipher')
            ->where($db->qn('extension') . ' = ' . $db->q($extension));
        try {
            $db->setQuery($query)->execute();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

}