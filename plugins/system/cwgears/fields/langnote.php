<?php
/**
 * @subpackage  CoalaWeb Gears
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL V3 or later; https://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (c) 2021 Steven Palmer All rights reserved.
 *
 * CoalaWeb Gears is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a one line text field + current module ID.
 *
 */
class JFormFieldLangNote extends JFormField
{
    /**
     * The form field type.
     *
     * @var    string
     */
    protected $type = 'LangNote';

    /**
     * Method to get the field label markup.
     *
     * @return  string  The field label markup.
     *
     */
    protected function getLabel()
    {
        if (empty($this->element['label']) && empty($this->element['description']))
        {
            return '';
        }
        $currentId = JFactory::getApplication()->input->getInt('id');
        if(!$currentId){
            $currentId =  JText::_('PLG_CWGEARS_ERROR');
        }

        $title = $this->element['label'] ? (string) $this->element['label'] : ($this->element['title'] ? (string) $this->element['title'] : '');
        $heading = $this->element['heading'] ? (string) $this->element['heading'] : 'h4';
        $description = (string) $this->element['description'];
        $class = !empty($this->class) ? ' class="' . $this->class . '"' : '';
        $close = (string) $this->element['close'];

        $html = array();

        if ($close)
        {
            $close = $close == 'true' ? 'alert' : $close;
            $html[] = '<button type="button" class="close" data-dismiss="' . $close . '">&times;</button>';
        }

        $html[] = !empty($title) ? '<' . $heading . '>' . JText::sprintf($title, $currentId) . '</' . $heading . '>' : '';
        $html[] = !empty($description) ? JText::sprintf($description, $currentId)  : '';

        return '</div><div ' . $class . '>' . implode('', $html);
    }

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     */
    protected function getInput()
    {
        return '';
    }
}
