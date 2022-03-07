<?php

declare(strict_types=1);

namespace Helper;

class FormHelper
{
    private string $form;

    public function __construct(string $action, string $method)
    {
        $this->form = '<form action="' . BASE_URL . $action . '" method="' . $method . '">';
    }

    public function input(array $data, bool $br = true): void
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

    public function select(array $data, bool $br = true): void
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
        string $name,
        ?string $value = null,
        ?string $placeholder = null,
        ?string $id = null,
        ?int $limit = null,
        bool $br = true
    ): void
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

    public function label(string $id, string $label, bool $br = true): void
    {
        $this->form .= '<label for="' . $id . '">' . $label . '</label>';
        if ($br) {
            $this->form .= '<br>';
        }
    }

    public function getForm(): string
    {
        $this->form .= '</form>';
        return $this->form;
    }
}