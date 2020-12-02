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

use Joomla\Registry\Registry;
use \stdClass;


/**
 * Class SubExtensions
 * @package CoalaWeb
 */
class SubExtensions
{

    /**
     * @var \JDatabaseDriver
     * @since 2.9.2
     */
    private $db;

    public function __construct()
    {
        $this->db = \JFactory::getDbo();
    }

    public function checkSubextensions($check_related, $oldPluginNames = null)
    {
        $status = new \stdClass();
        $status->modules = array();
        $status->plugins = array();

        // Modules uninstallation
        if (count($check_related['modules'])) {
            foreach ($check_related['modules'] as $folder => $modules) {
                if (count($modules)) {
                    foreach ($modules as $module) {
                        if (empty($folder)) {
                            $folder = 'site';
                        }
                        // Find the module details
                        $query = $this->db->getQuery(true);

                        $query
                            ->select($this->db->qn(array('enabled', 'extension_id')))
                            ->from($this->db->qn('#__extensions'))
                            ->where($this->db->qn('element') . ' = ' . $this->db->q('mod_' . $module))
                            ->where($this->db->qn('type') . ' = ' . $this->db->q('module'));

                        $this->db->setQuery($query);
                        $modEnabled = $this->db->loadObject();

                        if ($error = $this->db->getErrorMsg()) {
                            JError::raiseWarning(500, $error);
                            return false;
                        }

                        if ($modEnabled) {
                            $status->modules[] = array(
                                'installed' => '1',
                                'name' => 'mod_' . $module,
                                'client' => $folder,
                                'enabled' => $modEnabled->enabled,
                                'id' => $modEnabled->extension_id
                            );
                        } else {
                            $status->modules[] = array(
                                'installed' => '0',
                                'name' => 'mod_' . $module,
                                'client' => $folder,
                                'enabled' => null,
                                'id' => null
                            );
                        }

                    }
                }
            }
        }

        // Plugins uninstallation
        if (count($check_related['plugins'])) {
            foreach ($check_related['plugins'] as $folder => $plugins) {
                if (count($plugins)) {
                    foreach ($plugins as $plugin) {
                        $query = $this->db->getQuery(true);

                        $query
                            ->select($this->db->qn(array('enabled', 'extension_id')))
                            ->from($this->db->qn('#__extensions'))
                            ->where($this->db->qn('type') . ' = ' . $this->db->q('plugin'))
                            ->where($this->db->qn('element') . ' = ' . $this->db->q($plugin))
                            ->where($this->db->qn('folder') . ' = ' . $this->db->q($folder));

                        $this->db->setQuery($query);
                        $plgEnabled = $this->db->loadObject();

                        if ($error = $this->db->getErrorMsg()) {
                            JError::raiseWarning(500, $error);
                            return false;
                        }

                        if (in_array($plugin, $oldPluginNames)) {
                            if ($plgEnabled) {
                                $status->plugins[] = array(
                                    'installed' => '1',
                                    'name' => 'plg_' . $plugin,
                                    'group' => $folder,
                                    'enabled' => $plgEnabled->enabled,
                                    'id' => $plgEnabled->extension_id
                                );
                            } else {
                                $status->plugins[] = array(
                                    'installed' => '0',
                                    'name' => 'plg_' . $plugin,
                                    'group' => $folder,
                                    'enabled' => null,
                                    'id' => null
                                );
                            }
                        } else {
                            if ($plgEnabled) {
                                $status->plugins[] = array(
                                    'installed' => '1',
                                    'name' => 'plg_' . $folder . '_' . $plugin,
                                    'group' => $folder,
                                    'enabled' => $plgEnabled->enabled,
                                    'id' => $plgEnabled->extension_id
                                );
                            } else {
                                $status->plugins[] = array(
                                    'installed' => '0',
                                    'name' => 'plg_' . $folder . '_' . $plugin,
                                    'group' => $folder,
                                    'enabled' => null,
                                    'id' => null
                                );
                            }
                        }
                    }
                }
            }
        }

        return $status;
    }
}