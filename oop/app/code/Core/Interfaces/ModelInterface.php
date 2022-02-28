<?php

namespace Core\Interfaces;

interface ModelInterface
{
    public function load($id);

    public function assignData();
}