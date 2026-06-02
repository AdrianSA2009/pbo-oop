<?php

namespace App\Models;

class Barang_Keluar extends Transaksi
{
    private string $destination;

    public function __construct(string $transactionId, int $userId, string $destination)
    {
        parent::__construct($transactionId, $userId);
        $this->destination = $destination;
    }

    public function processTransaction(Product $product, int $amount): string
    {
        $product->updateStock(-$amount);
        return "StockOut diproses: Mengirim {$amount} unit {$product->getName()} ke tujuan: {$this->destination}.";
    }
}