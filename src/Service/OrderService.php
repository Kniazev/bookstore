<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;


class OrderService implements OrderServiceInterface
{
    /**
     * @var OrderRepository|BookRepository
     */
    private OrderRepository $orderRepository;

    /**
     * @param OrderRepository $bookRepository
     */
    public function __construct(OrderRepository $bookRepository)
    {
        $this->orderRepository = $bookRepository;
    }

    /**
     * @param int $id
     * @return Order|null
     */
    public function getById(int $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    /**
     * @param Order $order
     * @return Order
     */
    public function create(Order $order): Order
    {
        $this->orderRepository->add($order, true);

        return $order;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            return false;
        }

        $this->orderRepository->removeAndCommit($order);

        return true;
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->orderRepository->commit();
    }

    /**
     * @return array
     */
    public function getStatusList(): array
    {
        return [
            Order::STATUS_DELIVERED,
            Order::STATUS_PENDING,
            Order::STATUS_PROCESSED,

        ];
    }
}