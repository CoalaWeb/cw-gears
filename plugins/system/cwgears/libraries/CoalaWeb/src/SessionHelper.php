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
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

namespace CoalaWeb;

defined('_JEXEC') or die;

/**
 * Class SessionHelper
 * @package CoalaWeb
 */
class SessionHelper
{
    private $session;

    public function __construct()
    {
        $this->session = JFactory::getSession();
    }

    /**
     * Sets a session variable
     *
     * @param string $name
     * @param string|array $value
     */
    private function setSession($name, $value)
    {
        $this->session->set($name, $value, $this->pluginId);
    }

    /**
     * Gets a session variable
     *
     * @param $name
     * @param $default
     *
     * @return mixed
     */
    private function getSession($name, $default = null)
    {
        return $this->session->get($name, $default, $this->pluginId);
    }

    /**
     * Clears a session variable
     *
     * @param string $name
     */
    private function clearSession($name)
    {
        $this->session->clear($name, $this->pluginId);
    }

}