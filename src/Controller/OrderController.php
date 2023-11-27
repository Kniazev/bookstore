<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\BookService;
use App\Service\BookServiceInterface;
use App\Service\OrderService;
use App\Service\OrderServiceInterface;
use PHPUnit\Util\Xml\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{

    /**
     * @var OrderServiceInterface $orderService
     */
    private OrderServiceInterface $orderService;

    /**
     * @var BookServiceInterface $bookService
     */
    private BookServiceInterface $bookService;

    /**
     * @param OrderServiceInterface $orderService
     */
    public function __construct(OrderServiceInterface $orderService, BookServiceInterface $bookService)
    {
        $this->orderService = $orderService;
        $this->bookService = $bookService;
    }


    /**
     * @Route("/order/statuses", name="app_order_statuses")
     */
    public function getOrderStatuses(): JsonResponse
    {
        return $this->json([
            $this->orderService->getStatusList(),
        ]);
    }

    /**
     * @Route("/order/{id}", name="app_order")
     */
    public function getOrder(int $id): JsonResponse
    {
        $order = $this->orderService->getById($id);

        return $this->json([
            !empty($order)
                ? $order
                : 'The order with that id does not exist.'
        ]);
    }

    /**
     * @Route("/order/create", name="order_create", methods={"POST"})
     */
    public function createOrder(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);

        $order = new Order();
        $order->setAddress($parameters['address']);
        $order->setOwner($parameters['owner']);
        $order->setTelephoneNumber($parameters['telephone']);
        $order->setDate(new \DateTime());
        $order->setStatus(Order::STATUS_PENDING);

        if (!empty($parameters['item_ids'])) {
            foreach ($parameters['item_ids'] as $itemId) {
                if ($book = $this->bookService->getById($itemId)) {
                    $order->addItem($book);
                }
            }
        }

        $errors = $validator->validate($order);

        if (!empty($errors)) {
            return $this->json(
                [
                    'Something went wrong',
                ]
            );
        }

        $this->orderService->create($order);

        return $this->json([
            $order,
        ]);
    }
}
