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

use Joomla\CMS\Language\Text as JText;

/**
 * Class Github
 * @package CoalaWeb
 */
class Github
{

    /**
     * Retrieve a copy of a GitHub file.
     *
     * @param string $url The URL of the file to retrieve (needs to be in raw format).
     *
     * @param string $useCache Do we cache this?
     *
     * @return bool|mixed
     */
    public static function getGitHubFile($url, $useCache = '')
    {
        /* Example Use:
        $lang = JFactory::getLanguage();
        $joomla = JFactory::getApplication();

        use Michelf\MarkdownExtra;
        use CoalaWeb\Github as CW_Github;

        $github = CW_Github::getGitHubFile('https://raw.githubusercontent.com');

        if ($github['ok']) {
            $my_html = MarkdownExtra::defaultTransform($github['output']);
            echo $my_html;
        } else {
            $joomla->enqueueMessage($github['msg'], $github['type']);
        }*/


        // Is cURL installed yet?
        if (!function_exists('curl_init')) {
            $result = [
                'ok' => false,
                'output' => '',
                'type' => 'notice',
                'msg' => JText::_('PLG_CWGEARS_MSG_CURL_NOT_INSTALLED')
            ];
            return $result;
        }

        $codeURL = curl_init($url);

        // Include header in result?
        curl_setopt($codeURL, CURLOPT_HEADER, 0);

        // We want the data returned not printed
        curl_setopt($codeURL, CURLOPT_RETURNTRANSFER, 1);

        // Timeout in seconds
        curl_setopt($codeURL, CURLOPT_TIMEOUT, 10);

        // Download the given URL
        $output = curl_exec($codeURL);

        if (!$output) {
            $result = [
                'ok' => false,
                'output' => '',
                'type' => 'notice',
                'msg' => JText::_('PLG_CWGEARS_MSG_CURL_NO_URL')
            ];
            return $result;
        }

        // Close the cURL resource, and free system resources
        curl_close($codeURL);

        // Set up our response array
        $result = [
            'ok' => true,
            'output' => $output,
            'type' => '',
            'msg' => ''
        ];

        // Return our result
        return $result;

    }

}