<?php

namespace Helper;

class FormHelper
{
    private $form;

    public function __construct($action, $method)
    {
        $this->form = '<form action="' . BASE_URL . $action . '" method="' . $method . '">';
    }

    public function input($data, $br = '<br>')
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . '="' . $value . '" ';
        }
        $this->form .= '>' . $br;
    }

    public function select($data)
    {
        $this->form .= '<select name="' . $data['name'] . '">';
        foreach ($data['options'] as $key => $option) {
            $this->form .= '<option';
            if (isset($data['selected'])) {
                if ($data['selected'] == $key) {
                    $this->form .= ' selected ';
                }
            }
            $this->form .= ' value ="' . $key . '">' . $option . '</option>';
        }
        $this->form .= '</select><br>';
    }

    public function textArea($name, $value = null, $placeholder = null)
    {
        $this->form .= '<textarea name ="' . $name . '"';
        if (isset($placeholder)) {
            $this->form .= ' placeholder = "' . $placeholder . '"';
        }
        $this->form .= '>' . $value . '</textarea><br>';
    }

    public function addText($text)
    {
        $this->form .= $text;
    }

    public function getForm()
    {
        $this->form .= '</form>';
        return $this->form;
    }
}