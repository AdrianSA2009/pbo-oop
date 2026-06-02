<?php

namespace App\Models;

interface Identifiable
{
    public function getIdentity(): string;
}