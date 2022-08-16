<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/order/view', name: 'order_view')]
    public function orderView()
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->findAll();
        return $this->render('order/view.html.twig', ['order' => $order]);
    }

    #[Route('/cart/info', name: 'add_to_cart')]
    public function addToCart(Request $request)
    {
        $session = $request->getSession();
        $id = $request->get('id');
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $quantity = $request->get('quantity');
        $datetime = date('Y/m/d H:i:s');
        $user = $this->getUser();
        $productprice = $product->getPrice();
        $totalprice = $productprice * $quantity;
        $session->set('product', $product);
        $session->set('user', $user);
        $session->set('quantity', $quantity);
        $session->set('totalprice', $totalprice);
        $session->set('datetime', $datetime);
        return $this->render('order/index.html.twig');
    }

    #[Route('/order/make/', name: 'make_order')]
    public function orderMake(Request $request, ProductRepository $productRepository)
    {
        // $order = new Order();
        // $session = $request->getSession();
        // $product = new Product;
        // $id = $request->get('id');
        // $user = $this->getUser();
        // // $product = $productRepository->find($session->getId());
        // $session->get('product', $product);
        // // $datetime = date('YYYY-MM-DD hh:mm:ss');
        // $quantity = $product->getQuantity();
        // $price = $product->getPrice();
        // $totalprice = $price * $quantity;

        // $user = $session->get('user', $user);
        // $quantity = $session->get('quantity', $quantity);
        // // $datetime = $session->get('datetime', $datetime);
        // $totalprice = $session->get('totalprice', $totalprice);

        // $order->setUser($user);
        // $order->setProduct($product);
        // $order->setQuantity($quantity);
        // $order->setTotalprice($totalprice);
        // // $order->setDatetime($datetime);

        // $manager = $this->getDoctrine()->getManager();
        // $manager->merge($order);
        // $manager->flush();
        $this->addFlash('Info', 'Order succed !');
        return $this->redirectToRoute('product_list');
    }
}
