<?php

namespace App\Models;

class Product extends ProductBase
{
    private int $stockQuantity;
    private float $unitPrice;
    private int $categoryId;

    public function __construct(int $id, string $name, string $sku, int $stockQuantity, float $unitPrice, int $categoryId)
    {
        parent::__construct($id, $name, $sku);
        $this->stockQuantity = $stockQuantity;
        $this->unitPrice = $unitPrice;
        $this->categoryId = $categoryId;
    }

    public function getStockStatus(): string
    {
        return $this->stockQuantity > 0 ? "Tersedia ({$this->stockQuantity} unit)" : "Habis";
    }

    public function updateStock(int $amount): void
    {
        $this->stockQuantity += $amount;
    }

    public function calculateStockValue(): float
    {
        return $this->stockQuantity * $this->unitPrice;
    }
}