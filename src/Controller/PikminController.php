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
    public function ficha(ManagerRegistry $doctrine, $codigo):Response{
       $resultado = ($this->pikmins[$codigo] ?? null);

       if($resultado){
       $html = "<ul>";
           $html = "<li>" . $codigo . "</li>";
           $html = "<li>" . $resultado['nombre'] . "</li>";
           $html = "<li>". $resultado['color'] . "</li>";
       $html = "</ul>";
       return new Response("<$html><body>$html<body>");
       }
       return new Response("<html><body>Pikmin $codigo no encontrado</body>");
    }
}