<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository): Response
    {
        $product = $productRepository->findAll();
        return $this->render(
            'home/homepage.html.twig',
            [
                'product' => $product,
            ]
        );
    }

    #[Route('/home/checkout', name: 'checkout')]
    public function checkout(ProductRepository $productRepository, Request $request)
    {
        $order = new Order();
        $user = $this->getUser();
        $id = $request->get('id');
        $product = $productRepository->find($id);
        $quantity = $product->getQuantity('quantity');
        $price = $product->getPrice();
        $totalprice = $price * $quantity;
        $datetime = $order->getDatetime();

        $order->setUser($user);
        $order->setProduct($product);
        $order->setQuantity($quantity);
        $order->setTotalprice($totalprice);
        $order->setDatetime($datetime);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($order);
        $manager->flush();
        $this->addFlash('Success', 'Order succed');
        return $this->render(
            'home/checkout.html.twig',
            [
                'user' => $user,
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'totalprice' => $totalprice,
                'datetime' => $datetime,
            ]
        );
    }
}
