<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SendMoneyController extends AbstractController
{
    /**
     * @Route("/send/money", name="send_money")
     */
    public function index()
    {
        return $this->render('send_money/index.html.twig', [
            'controller_name' => 'SendMoneyController',
        ]);
    }
}
