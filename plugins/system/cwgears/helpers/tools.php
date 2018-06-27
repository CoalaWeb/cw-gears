<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Gears
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL, see /assets/en-GB.license.txt
 * @copyright   Copyright (c) 2018 Steven Palmer All rights reserved.
 *
 * CoalaWeb Gears is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/gpl.html>.
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.log.log');

/**
 * Class CwGearsHelperTools
 */
class CwGearsHelperTools
{

    /**
     * @param $text
     * @param bool $stripHtml
     * @param $limit
     * @return null|string|string[]|Tidy
     */
    public static function textClean($text, $stripHtml = true, $limit)
    {
        // Now decoded the text
        $decoded = html_entity_decode($text);

        // Remove any HTML based on module settings
        $notags = $stripHtml ? strip_tags($decoded) : $decoded;

        // Remove brackets such as plugin code
        $nobrackets = preg_replace("/\{[^}]+\}/", " ", $notags);

        //Now reduce the text length if needed
        $chars = strlen($notags);
        if ($chars <= $limit) {
            $description = $nobrackets;
        } else {
            $description = JString::substr($nobrackets, 0, $limit) . "...";
        }

        // One last little clean up
        $cleanText = preg_replace("/\s+/", " ", $description);

        // Lastly repair any HTML that got cut off if Tidy is installed
        if (extension_loaded('tidy') && !$stripHtml) {
            $tidy = new Tidy();
            $config = array(
                'output-xml' => true,
                'input-xml' => true,
                'clean' => false
            );
            $tidy->parseString($cleanText, $config, 'utf8');
            $tidy->cleanRepair();
            $cleanText = $tidy;
        }

        return $cleanText;
    }

    /**
     * Clean and minimize code
     *
     * @param string $code
     * @return string
     */
    public static function codeClean($code) {

        // Remove comments.
        $pass1 = preg_replace('~//<!\[CDATA\[\s*|\s*//\]\]>~', '', $code);
        $pass2 = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\)\/\/[^"\'].*))/', '', $pass1);

        // Minimize.
        $pass3 = str_replace(array("\r\n", "\r", "\n", "\t"), '', $pass2);
        $pass4 = preg_replace('/ +/', ' ', $pass3); // Replace multiple spaces with single space.
        $codeClean = trim($pass4);  // Trim the string of leading and trailing space.

        return $codeClean;
    }

    /**
     * Checks if multiple keys exist in an array
     *
     * @param array $array
     * @param array|string $keys
     *
     * @return bool
     */
    public static function keysExist( array $array, $keys ) {
        $count = 0;
        if ( ! is_array( $keys ) ) {
            $keys = func_get_args();
            array_shift( $keys );
        }
        foreach ( $keys as $key ) {
            if ( array_key_exists( $key, $array ) ) {
                $count ++;
            }
        }

        return count( $keys ) === $count;
    }

    /**
     * Check if array is empty
     *
     * @param array $arr
     *
     * @return boolean
     */
    function isEmptyArr($arr = array()) {
        if (!empty($arr)) {
            $count = count($arr);
            $check = 0;
            foreach ($arr as $id => $item) {
                if (empty($item)) {
                    $check++;
                }
            }
            if ($check != $count) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if certain files/folders currently exist
     *
     * @param $filesAndFolders - files and folders lists
     * @param $langRoot
     * @return array
     */
    public static function checkFilesAndFolders($filesAndFolders, $langRoot)
    {

        // Check files exist
        jimport('joomla.filesystem.file');

        // Loop through files
        if (!empty($filesAndFolders['files'])) {
            foreach ($filesAndFolders['files'] as $file) {
                $f = JPATH_ROOT . '/' . $file;
                if (!JFile::exists($f)) {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::_($langRoot . '_FILE_MISSING_MESSAGE')
                    ];
                    return $result;
                } else {
                    continue;
                }
            }
        }
        // Check folders exist
        jimport('joomla.filesystem.folder');

        // Lopp through folders
        if (!empty($filesAndFolders['folders'])) {
            foreach ($filesAndFolders['folders'] as $folder) {
                $f = JPATH_ROOT . '/' . $folder;
                if (!JFolder::exists($f)) {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::_($langRoot . '_FOLDER_MISSING_MESSAGE')
                    ];
                    return $result;
                } else {
                    continue;
                }
            }
        }

        // Set up our response array
        $result = [
            'ok' => true,
            'type' => '',
            'msg' => ''
        ];

        // Return our result
        return $result;

    }

    /**
     * Check certain extensions are enabled
     *
     * @param $extensions
     * @param $langRoot
     * @return array
     */
    public static function checkExtensions($extensions, $langRoot)
    {
        // Loop through and check components are enabled
        if (!empty($extensions['components'])) {
            foreach ($extensions['components'] as $component) {
                if (!JComponentHelper::isEnabled($component)) {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::sprintf($langRoot . '_NOEXT_CHECK_MESSAGE', $component)
                    ];
                    return $result;
                } else {
                    continue;
                }
            }
        }

        // Loop through and check modules are enabled
        if (!empty($extensions['modules'])) {
            foreach ($extensions['modules'] as $module) {
                if (!JModuleHelper::isEnabled($module)) {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::sprintf($langRoot . '_NOEXT_CHECK_MESSAGE', $module)
                    ];
                    return $result;
                } else {
                    continue;
                }
            }
        }

        // Loop through and check plugins are enabled
        if (!empty($extensions['plugins'])) {
            foreach ($extensions['plugins'] as $plugin) {
                $parts = explode('_', $plugin);
                if (!JPluginHelper::isEnabled($parts[1], $parts[2])) {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::sprintf($langRoot . '_NOEXT_CHECK_MESSAGE', $plugin)
                    ];
                    return $result;
                } else {
                    continue;
                }
            }
        }

        // Set up our response array
        $result = [
            'ok' => true,
            'type' => '',
            'msg' => ''
        ];

        // Return our result
        return $result;

    }

    /**
     * Format messages
     *
     * @param $type
     * @param $msg
     * @param array $sprint
     * @return string
     */
    public static function getMessage($type, $msg, $sprint = array())
    {
        $returnStatus= null;
        $sprintCheck = array_filter($sprint);

        if (!empty($sprintCheck)) {
            $foo = JText::_($msg);
            $msg = vsprintf($foo, $sprint);
        } else {
            $msg = JText::_($msg);
        }

        switch ($type) {
            case 'info':
                $output[] = '<div class="alert alert-info">';
                $output[] = '<span class="icon-info-circle"></span>';
                $output[] = $msg;
                $output[] = '</div>';

                $returnStatus = implode("\n", $output);
                break;
            case 'danger':
                $output[] = '<div class="alert alert-danger">';
                $output[] = '<span class="icon-warning"></span>';
                $output[] = $msg;
                $output[] = '</div>';

                $returnStatus = implode("\n", $output);
                break;
            case 'warning':
                $output[] = '<div class="alert alert-warning">';
                $output[] = '<span class="icon-notification"></span>';
                $output[] = $msg;
                $output[] = '</div>';

                $returnStatus = implode("\n", $output);
                break;

            case 'success':
                $output[] = '<div class="alert alert-success">';
                $output[] = '<span class="icon-checkmark"></span>';
                $output[] = $msg;
                $output[] = '</div>';

                $returnStatus = implode("\n", $output);
                break;

        }

        return $returnStatus;
    }
}