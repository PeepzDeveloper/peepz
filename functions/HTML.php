<?php

class HTML
{
    /**
     * @param $string
     * @param bool $escape
     */
    public static function out($string, $escape = true)
    {
        echo self::get($string, $escape);
    }

    /**
     * @param string $string
     * @return string
     */
    public static function stripJavascript($string)
    {
        return preg_replace(
            [
                '/<script\b[^>]*>(.*?)<\/script\s*>/is',
                '/href="javascript:[^"]+"/',
            ], [
            '',
            'href="#"',
        ],
            $string
        );
    }

    /**
     * @param $string
     * @param bool $escape
     * @return string
     */
    public static function get($string, $escape = true)
    {
        if ($escape === false) {
            return $string;
        } else {
            $string = self::convertToUtf8($string);
            return htmlspecialchars($string);
        }
    }

    /**
     * @param $string
     * @param bool $escape
     * @param bool $return
     * @return string
     */
    public static function property($string, $escape = true, $return = false)
    {
        $string = preg_replace('/[^A-Za-z0-9]/', '_', $string);
        $string = preg_replace('/_+/', '_', $string);

        if ($escape === true) {
            $string = htmlspecialchars($string);
        }

        if ($return) {
            return $string;
        } else {
            echo $string;
        }
    }

    /**
     * @param array $attributes
     * @param bool $return
     * @return null|string
     */
    public static function input(array $attributes = [], $return = false)
    {
        // Set a default name if one was not provided
        if (isset($attributes['name']) === false) {
            $attributes['name'] = 'input_' . str_pad(mt_rand(0, 10000), 5, 0, STR_PAD_LEFT);
        }

        // Set a default id if one was not provided
        if (isset($attributes['id']) === false) {
            $attributes['id'] = $attributes['name'];
        }

        $html = self::addAttributes('<input', $attributes) . ' />';

        return self::outputHtml($html, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function text($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'text';

        return self::textBasedInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function date($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'date';

        return self::textBasedInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function email($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'email';

        if (isset($attributes['placeholder']) === false) {
            $attributes['placeholder'] = 'example@domain.com';
        }

        return self::textBasedInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function number($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'number';

        return self::textBasedInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function password($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'password';

        return self::textBasedInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function search($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'search';

        if (isset($attributes['placeholder']) === false) {
            $attributes['placeholder'] = 'Search';
        }

        return self::textBasedInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function tel($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'tel';

        if (isset($attributes['placeholder']) === false) {
            $attributes['placeholder'] = '+27115551234';
        }

        return self::textBasedInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function url($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'url';

        if (isset($attributes['placeholder']) === false) {
            $attributes['placeholder'] = 'http://www.domain.com';
        }

        return self::textBasedInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param $value
     * @param bool $checked
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function checkbox($name, $value, $checked = false, array $attributes = [], $return = false)
    {
        $attributes['type'] = 'checkbox';

        if ($checked === true) {
            $attributes['checked'] = 'checked';
        }

        return self::formInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function hidden($name, $value = '', array $attributes = [], $return = false)
    {
        $attributes['type'] = 'hidden';

        return self::formInput($name, $value, $attributes, $return);
    }

    /**
     * @param string $name
     * @param array $options
     * @param string $selected
     * @param array $attributes
     * @param bool $return
     * @param bool $labelAsValue
     * @return string
     */
    public static function dropdown(
        $name,
        array $options,
        $selected = null,
        array $attributes = [],
        $return = false,
        $labelAsValue = false
    ) {
        $html = '<select';

        $attributes['name'] = $name;

        if (isset($attributes['id']) === false) {
            $attributes['id'] = htmlspecialchars($name);
        }

        $html = self::addAttributes($html, $attributes);
        $html .= '>';

        foreach ($options as $value => $label) {
            if ($labelAsValue === true) {
                $value = $label;
            }
            $html .= "\n" . '<option value="' . htmlspecialchars($value) . '"';

            if (is_array($selected) === true) {
                if (in_array((string)$value, $selected) === true) {
                    $html .= ' selected="selected"';
                }
            } else {
                if (((string)$value === (string)$selected)) {
                    $html .= ' selected="selected"';
                }
            }
            $html .= '>' . htmlspecialchars($label) . '</option>';
        }

        $html .= "\n</select>";

        if ($return === true) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * @param string $name
     * @param array $optionGroups
     * @param string $selected
     * @param array $attributes
     * @return string
     */
    public static function dropdownOptgroup($name, array $optionGroups, $selected = null, array $attributes = [])
    {
        $html = '<select';
        $html .= ' name="' . htmlspecialchars($name) . '"';
        $html .= ' id="' . htmlspecialchars($name) . '"';
        $html = self::addAttributes($html, $attributes);
        $html .= '>';

        foreach ($optionGroups as $optionGroup) {
            $html .= "\n" . '<optgroup style="font-style:normal;' .
                'padding-top:3px;padding-left:1px;" label="' .
                htmlspecialchars($optionGroup['label']) . '">';

            foreach ($optionGroup['options'] as $value => $label) {
                $html .= "\n" . '<option style="padding-top:2px;' .
                    'padding-left:8px;padding-bottom : 2px;" value="' .
                    htmlspecialchars($value) . '"';

                if ((string)$value === (string)$selected) {
                    $html .= ' selected="selected"';
                }

                $html .= '>' . htmlspecialchars($label) . '</option>';
            }

            $html .= "\n" . '</optgroup>';
        }

        $html .= "\n</select>";

        return $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $label
     * @param bool $checked
     * @param array $attributes
     * @param string $labelForInputId
     * @return string
     */
    public static function radio(
        $name,
        $value = '',
        $label = '',
        $checked = false,
        array $attributes = [],
        $labelForInputId = null
    ) {
        // Create the base HTML for the radio button
        $html = '<input type="radio"'
            . ' name="' . htmlspecialchars($name) . '"'
            . ' value="' . htmlspecialchars($value) . '"';

        if ($checked === true) {
            $html .= ' checked="checked"';
        }

        // Check if an ID was set, Not set, default to name
        if (empty($attributes['id']) === true) {
            $id = htmlspecialchars($name);
            $html .= ' id="' . $id . '"';
        } else {
            $id = $attributes['id'];
        }

        $html = self::addAttributes($html, $attributes);
        $html .= ' />';

        // Create the label if it was set
        if (trim($label) !== '') {
            if (is_null($labelForInputId) === true) {
                $html .= '<label for="' . $id . '" class="radio">' . htmlspecialchars($label) . '</label>';
            } else {
                $html = '<label class="radio">' . $html . ' ' . htmlspecialchars($label) . '</label>';
            }
        }

        return $html;
    }

    /**
     * @param string $name
     * @param array $options
     * @param string $selected
     * @param array $attributes
     * @param string $default
     * @return string
     */
    public static function radioGroup(
        $name,
        array $options,
        $selected = null,
        array $attributes = [],
        $default = ''
    ) {
        $html = '';
        $count = 0;

        // Loop through the option to create each radio button
        foreach ($options as $value => $label) {
            // Determine if the radio button should be checked
            if (empty($selected) === true && $count === 0
                && empty($default) === true
            ) {
                $checked = true;

            } elseif (empty($selected) === true && empty($default) === false) {
                $checked = ((string)$value === (string)$default)
                    ? true : false;
            } else {
                $checked = ((string)$value === (string)$selected)
                    ? true : false;
            }

            // Add an ID attribute, this will override previously set values
            $attributes['id'] = $name . '_' . $count;

            // Create the radio button
            $html .= "\n" . self::radio($name, $value, $label, $checked, $attributes);

            $count++;
        }

        return $html;
    }

    /**
     * @param string $name
     * @param array $options
     * @param string $selected
     * @param array $attributes
     * @param string $default
     * @param bool|false $return
     * @return string
     */
    public static function optionsGroup(
        $name,
        array $options,
        $selected = null,
        array $attributes = [],
        $default = '',
        $return = false
    ) {
        $html = '<table cellspacing="0" cellpadding="0" class="app-browse '
            . 'list option-group"><tbody>';

        $count = 0;

        // Loop through the option to create each radio button
        foreach ($options as $value => $label) {
            // Determine if the radio button should be checked
            if (empty($selected) === true && $count === 0
                && empty($default) === true
            ) {
                $checked = true;
            } elseif (empty($selected) === true && empty($default) === false) {
                $checked = ((string)$value === (string)$default)
                    ? true : false;
            } else {
                $checked = ((string)$value === (string)$selected)
                    ? true : false;
            }

            // Add an ID attribute, this will override previously set values
            $attributes['id'] = $name . '_' . $count;

            $even = (($count % 2) === 0) ? 'even' : 'odd';

            $selection_class = ((string)$value === (string)$selected)
                ? 'selected'
                : '';

            $classes = '';
            if ($even !== '' && $selection_class === '') {
                $classes .= $even;
            } else {
                $classes .= $even . ' ' . $selection_class;
            }

            // Create the radio button
            $html .= '<tr class="' . $classes . '">'
                . '<td class="first-child stretch">'
                . self::radio($name, $value, $label, $checked, $attributes)
                . '</td></tr>';

            $count++;
        }

        $html .= '</tbody></table>';

        if ($return === true) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * @param string $name
     * @param string $content
     * @param string $cols
     * @param string $rows
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function textarea(
        $name,
        $content = '',
        $cols = '22',
        $rows = '5',
        array $attributes = [],
        $return = false
    ) {
        $attributes['name'] = $name;

        // Set a default id if one was not provided
        if (isset($attributes['id']) === false) {
            $attributes['id'] = $attributes['name'];
        }

        $attributes['cols'] = $cols;
        $attributes['rows'] = $rows;

        $html = '<textarea';
        $html = self::addAttributes($html, $attributes);
        $html .= '>';
        $html .= htmlspecialchars($content);
        $html .= '</textarea>';

        if ($return === true) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * @param string $source
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function iframe($source, array $attributes = [], $return = false)
    {
        $html = '<iframe src="' . $source . '"';
        $html = self::addAttributes($html, $attributes);
        $html .= '></iframe>';

        if ($return === true) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * @param string $name
     * @param array $values
     * @param string $selected
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function valuesDropdown(
        $name,
        array $values,
        $selected = null,
        array $attributes = [],
        $return = false
    ) {
        $options = [];

        foreach ($values as $value) {
            $options[$value] = ucfirst($value);
        }

        return self::dropdown($name, $options, $selected, $attributes, $return);
    }

    /**
     * @param string $name
     * @param array $values
     * @param array $settings
     * @param string $selected
     * @param array $attributes
     * @param array $options
     * @param string $default
     * @param bool $return
     * @param string $blankValue
     * @return string
     */
    public static function iteratorDropdown(
        $name,
        array $values,
        array $settings = [],
        $selected = null,
        array $attributes = [],
        array $options = [],
        $default = '',
        $return = false,
        $blankValue = ''
    ) {
        if (empty($blankValue) === false) {
            $options['-1'] = $blankValue;
        }

        // There is no data in the database
        if (empty($values)) {
            return self::dropdown(
                $name,
                $options,
                $selected,
                $attributes,
                $default,
                $return
            );
        }

        foreach ($values as $item) {
            $options[$item[$settings['value']]] = $item[$settings['display']];
        }

        return self::dropdown(
            $name,
            $options,
            $selected,
            $attributes,
            $default,
            $return
        );
    }

    /**
     * @param string $name
     * @param array $values
     * @param array $settings
     * @param string $selected
     * @param array $attributes
     * @param array $prepend_options
     * @param bool|false $return
     * @param string $ungrouped_translation
     * @return string
     */
    public static function iteratorGroupDropdown(
        $name,
        array $values,
        array $settings = [],
        $selected = null,
        array $attributes = [],
        array $prepend_options = array(),
        $return = false,
        $ungrouped_translation = 'Ungrouped'
    ) {
        $options = $prepend_options;

        foreach ($values as $item) {
            $options[] = array(
                'value' => $item[$settings['value']],
                'label' => strip_tags($item[$settings['display']]),
                'optgroup' => strip_tags($item[$settings['optgroup']]),
            );
        }

        return self::groupDropdown(
            $name,
            $options,
            $selected,
            $attributes,
            $return,
            $ungrouped_translation
        );
    }

    /**
     * @param string $name
     * @param array $options
     * @param string $selected
     * @param array $attributes
     * @param bool $return
     * @param string $ungrouped_translation
     * @return string
     */
    public static function groupDropdown(
        $name,
        array $options,
        $selected = null,
        array $attributes = [],
        $return = false,
        $ungrouped_translation = 'Ungrouped'
    ) {
        $html = '<select';

        $attributes['name'] = $name;

        // Set the "id" to the field name if no id was given
        if (isset($attributes['id']) === false) {
            $attributes['id'] = htmlspecialchars($name);
        }

        $html = self::addAttributes($html, $attributes);
        $html .= '>';

        $previous_grp_opt = '';
        foreach ($options as $option) {
            // Assign vars:
            $group_option = $option['optgroup'];
            $value = $option['value'];
            $label = $option['label'];

            if ($group_option !== $previous_grp_opt) {
                if (empty($group_option) === true) {
                    $html .= '<optgroup label="' . $ungrouped_translation . '">';
                } else {
                    $html .= '<optgroup label="' . $group_option . '">';
                }

            }

            $html .= "\n" . '<option value="' . htmlspecialchars($value)
                . '"';

            if (is_array($selected) === true) {
                if (in_array((string)$value, $selected) === true) {
                    $html .= ' selected="selected"';
                }
            } else {
                if ((string)$value === (string)$selected) {
                    $html .= ' selected="selected"';
                }
            }

            $html .= '>' . htmlspecialchars($label) . '&nbsp;</option>';

            $previous_grp_opt = $group_option;

            if ($group_option !== $previous_grp_opt) {
                $html .= '</optgroup>';
            }
        }

        $html .= "\n</select>";

        if ($return === true) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * @param string $name
     * @param array $options
     * @param array $selected
     * @param array $attributes
     * @param array $group_startup_options
     * @param bool $return
     * @return string
     */
    public static function groupMultipleSelect(
        $name,
        array $options,
        array $selected = array(),
        array $attributes = [],
        array $group_startup_options = array(),
        $return = false
    ) {
        $html = '<select multiple="multiple" class="multiselect"';

        $attributes['name'] = $name;

        // Set the "id" to the field name if no id was given
        if (isset($attributes['id']) === false) {
            $attributes['id'] = htmlspecialchars($name);
        }

        $html = self::addAttributes($html, $attributes);
        $html .= '>';

        // Put startup options in if they exist.
        if (empty($group_startup_options) === false) {
            $html .= "\n" . '<option value="'
                . htmlspecialchars(key($group_startup_options)) . '"';

            if (in_array($group_startup_options, $selected) === true) {
                $html .= ' selected="selected"';
            }

            $html .= '>'
                . htmlspecialchars(current($group_startup_options))
                . '&nbsp;</option>';
        }
        $previous_grp_opt = '';
        foreach ($options as $option) {
            // Assign vars:
            $group_option = $option['optgroup'];
            $value = $option['value'];
            $label = $option['label'];

            if ($group_option !== $previous_grp_opt) {
                $html .= '<optgroup label="' . $group_option . '">';
            }

            $html .= "\n" . '<option value="' . htmlspecialchars($value)
                . '"';

            if (in_array($value, $selected) === true) {
                $html .= ' selected="selected"';
            }

            $html .= '>' . htmlspecialchars($label) . '&nbsp;</option>';

            $previous_grp_opt = $group_option;

            if ($group_option !== $previous_grp_opt) {
                $html .= '</optgroup>';
            }
        }

        $html .= "\n</select>";

        if ($return === true) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * @param string $text
     * @param string $for
     * @param bool $escape
     * @param bool $return
     * @return string
     */
    public static function label($text, $for = '', $escape = true, $return = false)
    {
        if ($escape === true) {
            $text = htmlspecialchars($text);
        }
        $attributes = array('for' => $for);

        $html = self::addAttributes('<label', $attributes) . '>' . $text . '</label>';

        return self::outputHtml($html, $return);
    }

    /**
     * @param string $name
     * @param stdClass $pages
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function paginationDropdown($name, stdClass $pages, array $attributes = [], $return = false)
    {
        $options = array($pages->current => $pages->current);

        /*
         * Get the decending staggered pages if the current page is not the
         * first
         */
        if ($pages->current !== $pages->first) {
            $down = array();

            self::staggerPages($down, $pages, $pages->current, -1);

            $options = array_reverse($down, true) + $options;
        }

        // Get the ascending staggered pages if the current page is not the last
        if ($pages->current !== $pages->last) {
            $up = array();

            self::staggerPages($up, $pages, $pages->current, 1);

            $options = $options + $up;
        }

        return self::dropdown(
            $name,
            $options,
            $pages->current,
            $attributes,
            $return
        );

    }

    /**
     * @param \Illuminate\Pagination\Paginator $paginator
     * @return string
     */
    public static function paginationEloquent($paginator){
        $presenter = new EloquentPaginatorPresenter($paginator);

        echo $presenter->render();
    }

    /**
     * @param string $name
     * @param $onChange
     * @param string $value
     * @param string $inputID
     * @param string $colorBlockID
     * @return string
     */
    public static function colorPicker(
        $name,
        $onChange,
        $value = 'FFFFFF',
        $inputID = 'color_field',
        $colorBlockID = 'color_block'
    ) {
        $html = '<input name="' . $name . '" id="' . $inputID . '" class="color ';
        $html .= '{styleElement:\'' . $colorBlockID . '\', hash:true, ';
        $html .= 'pickerMode:\'HSV\'}" ';
        $html .= 'onchange="' . $onChange . '" value="' . $value . '" />';
        $html .= '<div id="' . $colorBlockID . '" class="color_block">&nbsp;</div>';

        return $html;

    }

    /**
     * @param string $text
     * @param string $placement
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function tooltip($text, $placement = 'right', array $attributes = [], $return = false)
    {
        $html = '<i data-toggle="tooltip" data-placement="' . $placement
            . '" title="' . $text . '" class="bootstrap-tooltip"';
        $html = self::addAttributes($html, $attributes);
        $html .= '><span class="seve-icon-information-circle text-info"></span></i>';

        if ($return === true) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * @param string $text
     * @param string $placement
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    public static function tooltipsg($text, $placement = 'right', array $attributes = [], $return = false)
    {
        $html = '<i data-toggle="tooltip" data-placement="' . $placement . '" title="' . $text
            . '" class="seve-icon-information-circle"' . 'data-original-title="' . $text . '"';
        $html = self::addAttributes($html, $attributes);
        $html .= '></i>';

        if ($return === true) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * @param string $html
     * @param array $attributes
     * @return string
     */
    private static function addAttributes($html, array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $html .= ' ' . htmlspecialchars($attribute) . '="' . htmlspecialchars($value) . '"';
        }

        return $html;
    }

    /**
     * @param string $name
     * @param array $titles
     * @param int $stars
     * @param int $rating
     * @param array $attributes
     * @return string
     */
    public static function starRating(
        $name,
        array $titles,
        $stars = 5,
        $rating = 3,
        array $attributes = array('id' => 'rating')
    ) {
        $html = '<form id="' . $attributes['id'] . '" style="width: 200px" title="' . $titles[$rating - 1] . '">';

        for ($i = 1; $i <= $stars; $i++) {
            $html .= '<input type="radio" name="' . $name . '" value="' . $i
                . '" title="' . $titles[$i - 1] . '" disabled="disabled"';
            if ((int)$rating === $i) {
                $html .= ' checked="checked"';
            }
            $html .= ' />';
        }

        $html .= '</form>';

        return $html;
    }

    /**
     * @param object $user
     * @param int $size
     * @param array $attributes
     * @param bool $return
     * @return null|string
     */
    public static function profilePicture($user, $size, array $attributes = [], $return = false)
    {
        if (($output = self::userAvatar($user->user_id, $size, $attributes, $return)) !== false) {
            return $output;
        } else {
            return self::gravatar($user->user_email, $size, $attributes, $return);
        }
    }

    /**
     * @param string $email
     * @param integer $imageSize
     * @param array $htmlAttributes
     * @param bool $return
     * @return null|string
     */
    public static function gravatar($email, $imageSize, array $htmlAttributes = array(), $return = false)
    {
        return self::image(
            Gravatar::getGravatarUrl($email, $imageSize),
            $imageSize,
            $htmlAttributes,
            $return
        );
    }

    /**
     * @param integer $userId
     * @param integer $size
     * @param array $attributes
     * @param bool $return
     * @return bool|null|string
     */
    public static function userAvatar($userId, $size, array $attributes = [], $return = false)
    {
        $avatarImageUrl = UserProfileAvatar::getImageUrl($userId);
        if ($avatarImageUrl === false) {
            return false;
        }

        return self::image(
            UserProfileAvatar::getImageUrl($userId),
            $size,
            $attributes,
            $return
        );
    }

    /**
     * @param string $src
     * @param integer $size
     * @param array $attributes
     * @param bool $return
     * @return null|string
     */
    public static function image($src, $size, array $attributes = [], $return = false)
    {
        $attributes['src'] = $src;
        $attributes['width'] = $size;
        $attributes['height'] = $size;

        $html = self::addAttributes('<img ', $attributes) . ' />';

        return self::outputHtml($html, $return);
    }

    /**
     * @param string $html
     * @param boolean $return
     * @return string|null
     */
    private static function outputHtml($html, $return = false)
    {
        return ($return === false) ? self::out($html, false) : $html;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    private static function formInput($name, $value, array $attributes, $return)
    {
        $attributes['name'] = $name;
        $attributes['value'] = $value;

        return self::input($attributes, $return);

    }

    /**
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @param bool $return
     * @return string
     */
    private static function textBasedInput($name, $value, array $attributes, $return)
    {
        if (array_key_exists('size', $attributes) === false) {
            $attributes['size'] = '40';
        }

        return self::formInput($name, $value, $attributes, $return);

    }

    /**
     * @param array $list
     * @param stdClass $pages
     * @param int $current
     * @param int $step
     */
    public static function staggerPages(array &$list, stdClass $pages, $current, $step)
    {
        /*
         * If the step is less than -1 the modulus deals with getting the
         * correct next step. If the step were to be subtracted here the modulus
         * will just too far.
         */
        if ($step < -1) {
            $next = $current;
        } else {
            $next = $current + $step;
        }

        /*
         * Subtract the modulus of the next page and the step from the next page
         * to ensure proper rounding
         */
        $next -= $next % $step;

        // Generate the page number range
        $range = range($next, $next + ($step * 4), $step);

        foreach ($range as $current) {
            // Stop if the beginning or end is reached
            if ($step < 0 && $current <= $pages->first) {
                $list[$pages->first] = $pages->first;
                return;
            } elseif ($step > 0 && $current >= $pages->last) {
                $list[$pages->last] = $pages->last;
                return;
            } else {
                $list[$current] = $current;
            }
        }

        // Keep going until the 1000 stepping is complete
        if ($step !== 1000) {
            self::staggerPages($list, $pages, $current, $step * 10);
        }
    }

    /**
     * @param $string
     * @param bool $return_as_array
     * @return mixed
     */
    public function jsonDecode($string, $return_as_array = false)
    {
        return json_decode($string, $return_as_array);
    }

    /**
     * @param $string
     * @return string
     */
    private static function convertToUtf8($string)
    {
        $encoding = mb_detect_encoding($string, 'ASCII,UTF-8', true);

        if ($encoding === 'UTF-8' && mb_check_encoding($string, 'UTF-8') === true) {
            return $string;
        } elseif ($encoding === false) {
            return mb_convert_encoding($string, 'UTF-8');
        } else {
            return mb_convert_encoding($string, 'UTF-8', $encoding);
        }
    }
}
