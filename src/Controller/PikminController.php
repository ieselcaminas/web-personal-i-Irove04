<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;

final class PikminController extends AbstractController
{
    private $contactos = [
        1 => ["nombre" => "Pikmin1", "color" => "rojo"],
        2 => ["nombre" => "Pikmin2","color" => "amarillo"],
        5 => ["nombre" => "Pikmin3","color" => "azul"],
    ];

    #[Route('/pikmins/{codigo}', name: 'ficha_contacto')]
    public function ficha($codigo): Response
    {
        $resultado = ($this->contactos[$codigo] ?? null);

        return $this->render('ficha_pikmin.html.twig', [
            'contacto' => $resultado
        ]);
    }
}