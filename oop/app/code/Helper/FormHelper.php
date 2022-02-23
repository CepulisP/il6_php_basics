<?php

namespace Helper;

class FormHelper
{
    private $form;

    public function __construct($action, $method)
    {
        $this->form = '<form action="' . BASE_URL . $action . '" method="' . $method . '">';
    }

    public function input($data, $br = 1)
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . '="' . $value . '" ';
        }
        $this->form .= '>';
        if ($br) {
            $this->form .= '<br>';
        }
    }

    public function select($data, $br = 1)
    {
        $this->form .= '<select name="' . $data['name'] . '"';
        if (isset($data['id'])) {
            $this->form .= ' id="' . $data['id'] . '"';
        }
        $this->form .= '>';
        foreach ($data['options'] as $key => $option) {
            $this->form .= '<option';
            if (isset($data['selected'])) {
                if ($data['selected'] == $key) {
                    $this->form .= ' selected ';
                }
            }
            $this->form .= ' value ="' . $key . '">' . $option . '</option>';
        }
        $this->form .= '</select>';
        if ($br) {
            $this->form .= '<br>';
        }
    }

    public function textArea(
        $name,
        $value = null,
        $placeholder = null,
        $id = null,
        $limit = null,
        $br = 1
    )
    {
        $this->form .= '<textarea name ="' . $name . '"';
        if (isset($placeholder)) {
            $this->form .= ' placeholder="' . $placeholder . '"';
        }
        if (isset($id)) {
            $this->form .= ' id="' . $id . '"';
        }
        if (isset($limit)) {
            $this->form .= ' maxlength="' . $limit . '"';
        }
        $this->form .= '>' . $value . '</textarea>';
        if ($br) {
            $this->form .= '<br>';
        }
    }

    public function label($id, $label, $br = 1)
    {
        $this->form .= '<label for="' . $id . '">' . $label . '</label>';
        if ($br) {
            $this->form .= '<br>';
        }
    }

    public function getForm()
    {
        $this->form .= '</form>';
        return $this->form;
    }
}