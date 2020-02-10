<?php

/*
 * This file is part of the ecommerce-symfony package.
 *
 * (c) Matthieu Mota <matthieu@boxydev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add/{id}/{qty}", name="cart_add")
     */
    public function add(Product $product, SessionInterface $session, $qty = 1)
    {
        $products = $session->get('products', []);

        $products[] = [
            'quantity' => $qty,
            'product' => $product,
        ];

        $session->set('products', $products);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/cart/delete/{id}", name="cart_delete")
     */
    public function delete(Product $product, SessionInterface $session)
    {
        $products = $session->get('products', []);

        foreach ($products as $key => $cartItem) {
            // Si le produit est en session, on le supprime
            if ($cartItem['product']->getId() === $product->getId()) {
                unset($products[$key]);
            }
        }

        $session->set('products', $products);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session)
    {
        $products = $session->get('products', []);
        // dump($products);

        return $this->render('cart/index.html.twig', [
            'products' => $products,
        ]);
    }
}
