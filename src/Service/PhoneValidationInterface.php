<?php

namespace App\Service;

interface PhoneValidationInterface
{
    public function isValid(string $phone): bool;
}