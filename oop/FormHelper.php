<?php

class FormHelper
{
    private $form;

    public function __construct($action, $method)
    {
        $this->form = '<form action="' . $action . '" method="' . $method . '">';
    }

    public function input($data)
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . '="' . $value . '" ';
        }
        $this->form .= '>';
    }

    public function select($data)
    {
        $this->form .= '<select name="' . $data['name'] . '">';
        foreach ($data['options'] as $key => $option) {
            $this->form .= '<option value ="' . $key . '">' . $option . '</option>';
        }
        $this->form .= '</select>';
    }

    public function textArea($name, $placeholder = '')
    {
        $this->form .= '<textarea name ="' . $name . '">' . $placeholder . '</textarea>';
    }

    public function getForm()
    {
        $this->form .= '</form>';
        return $this->form;
    }
}