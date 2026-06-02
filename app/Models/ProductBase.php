<?php

namespace App\Models;

abstract class ProductBase implements Identifiable
{
    protected int $id;
    protected string $name;
    protected string $sku;

    public function __construct(int $id, string $name, string $sku)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sku = $sku;
    }

    public function getIdentity(): string
    {
        return "SKU: " . $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function calculateStockValue(): float;
}