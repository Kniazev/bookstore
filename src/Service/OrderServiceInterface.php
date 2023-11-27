<?php

namespace App\Service;

use App\Entity\Order;

interface OrderServiceInterface
{
    public function getById(int $id): ?Order;
    public function create(Order $order): Order;
    public function delete(int $id): bool;
    public function update(): void;
    public function getStatusList(): array;
}