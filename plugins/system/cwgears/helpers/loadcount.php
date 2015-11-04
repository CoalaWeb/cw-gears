<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loadcount
 *
 * @author steve
 */
class CwGearsHelperLoadcount {

    /**
     * Get counts
     */
    public static function getCounts($url, $check) {
        //Start our database queries
        $db = JFactory::getDbo();
        
        //Now lets check the count
        $query = $db->getQuery(true);
        $query->select($check);
        $query->from($db->quoteName('#__cwgears'));
        $query->where('url = ' . $db->quote($url));
        $db->setQuery($query);
        
        //Get the result
        $count = $db->loadResult();

        // Lastly send back the count
        return $count;
    }

    /**
     * Get counts
     */
    public static function setUikitCount($url) {
        //Start our database queries
        $db = JFactory::getDbo();

        // Check if page already exists then update else insert
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwgears'));
        $query->where('url = ' . $db->quote($url));
        $db->setQuery($query);
        $current = $db->loadResult();

        if ($current) {// we are updating
            try {
                $query = $db->getQuery(true);

                $fields = array(
                    $db->quoteName('uikit') . ' = 1'
                );

                $conditions = array(
                    $db->quoteName('url') . ' = ' . $db->quote($url)
                );

                $query->update($db->quoteName('#__cwgears'))->set($fields)->where($conditions);

                $db->setQuery($query);
                $db->execute();
            } catch (Exception $e) {
                JLog::addLogger(array('text_file' => 'plg_cwgears.error.php'));
                JLog::add($e->getMessage());
            }
        } else {//we are inserting
            try {
                $query = $db->getQuery(true);
                $query->insert($db->quoteName('#__cwgears'));
                $query->columns(
                        'url, uikit ');
                $query->values(
                        $db->quote($url) . ','
                        . $db->quote('1'));

                $db->setQuery($query);
                $db->execute();
            } catch (Exception $e) {
                JLog::addLogger(array('text_file' => 'plg_cwgears.error.php'));
                JLog::add($e->getMessage());
            }
        }

        return $query;
    }

    public static function setUikitPlusCount($url) {
        //Start our database queries
        $db = JFactory::getDbo();

        // Check if page already exists then update else insert
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwgears'));
        $query->where('url = ' . $db->quote($url));
        $db->setQuery($query);
        $current = $db->loadResult();

        if ($current) {// we are updating
            try {
                $query = $db->getQuery(true);

                $fields = array(
                    $db->quoteName('uikit_plus') . ' = 1'
                );

                $conditions = array(
                    $db->quoteName('url') . ' = ' . $db->quote($url)
                );

                $query->update($db->quoteName('#__cwgears'))->set($fields)->where($conditions);

                $db->setQuery($query);
                $db->execute();
            } catch (Exception $e) {
                JLog::addLogger(array('text_file' => 'plg_cwgears.error.php'));
                JLog::add($e->getMessage());
            }
        } else {//we are inserting
            try {
                $query = $db->getQuery(true);
                $query->insert($db->quoteName('#__cwgears'));
                $query->columns(
                        'url, uikit_plus ');
                $query->values(
                        $db->quote($url) . ','
                        . $db->quote('1'));

                $db->setQuery($query);
                $db->execute();
            } catch (Exception $e) {
                JLog::addLogger(array('text_file' => 'plg_cwgears.error.php'));
                JLog::add($e->getMessage());
            }
        }

        return $query;
    }

    /**
     * Get counts
     */
    public static function setFacebookJsCount($url) {
        //Start our database queries
        $db = JFactory::getDbo();

        // Check if page already exists then update else insert
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwgears'));
        $query->where('url = ' . $db->quote($url));
        $db->setQuery($query);
        $current = $db->loadResult();

        if ($current) {// we are updating
            try {
                $query = $db->getQuery(true);

                $fields = array(
                    $db->quoteName('facebook_js') . ' = 1'
                );

                $conditions = array(
                    $db->quoteName('url') . ' = ' . $db->quote($url)
                );

                $query->update($db->quoteName('#__cwgears'))->set($fields)->where($conditions);

                $db->setQuery($query);
                $db->execute();
            } catch (Exception $e) {
                JLog::addLogger(array('text_file' => 'plg_cwgears.error.php'));
                JLog::add($e->getMessage());
            }
        } else {//we are inserting
            try {
                $query = $db->getQuery(true);
                $query->insert($db->quoteName('#__cwgears'));
                $query->columns(
                        'url, facebook_js ');
                $query->values(
                        $db->quote($url) . ','
                        . $db->quote('1'));

                $db->setQuery($query);
                $db->execute();
            } catch (Exception $e) {
                JLog::addLogger(array('text_file' => 'plg_cwgears.error.php'));
                JLog::add($e->getMessage());
            }
        }

        return $query;
    }

}
