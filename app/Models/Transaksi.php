<?php

namespace App\Models;

use DateTime;

abstract class Transaksi
{
    protected string $transactionId;
    protected DateTime $timestamp;
    protected int $userId;

    public function __construct(string $transactionId, int $userId)
    {
        $this->transactionId = $transactionId;
        $this->timestamp = new DateTime();
        $this->userId = $userId;
    }

    public function getTransactionDetails(): string
    {
        return "Transaksi ID: {$this->transactionId} pada {$this->timestamp->format('Y-m-d H:i:s')}";
    }

    abstract public function processTransaction(Product $product, int $amount): string;
}