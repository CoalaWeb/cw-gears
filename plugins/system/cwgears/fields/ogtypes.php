<?phpdefined('_JEXEC') or die('Restricted access');/** * @package             Joomla * @subpackage          CoalaWeb OG Types Field * @author              Steven Palmer * @author url          http://coalaweb.com * @author email        support@coalaweb.com * @license             GNU/GPL, see /assets/en-GB.license.txt * @copyright           Copyright (c) 2014 Steven Palmer All rights reserved. * * CoalaWeb Contact is free software: you can redistribute it and/or modify * it under the terms of the GNU General Public License as published by * the Free Software Foundation, either version 3 of the License, or * (at your option) any later version. * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the * GNU General Public License for more details. * You should have received a copy of the GNU General Public License * along with this program.  If not, see <http://www.gnu.org/licenses/>. */jimport('joomla.form.formfield');class JFormFieldOgtypes extends JFormField {    protected $type = 'ogtypes';    // getLabel() left out    public function getInput() {        return '<select id="' . $this->id . '" name="' . $this->name . '">' .                '<optgroup label="' . JText::_('COM_CWSOCIALLINKS_FIELD_OG_TYPE_H1') . '">' .                '<option value="article">' . JText::_('COM_CWSOCIALLINKS_FIELD_OG_TYPE_H1_OPT1') . '</option>' .                '<option value="blog">' . JText::_('COM_CWSOCIALLINKS_FIELD_OG_TYPE_H1_OPT2') . '</option>' .                '<option value="website">' . JText::_('COM_CWSOCIALLINKS_FIELD_OG_TYPE_H1_OPT3') . '</option>' .                '</optgroup>' .                '</select>';    }}