<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\PikminFormType as PikminType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pikmin;

final class PikminController extends AbstractController
{
    #[Route('/pikmins/nuevo', name: 'nuevo')]
    public function nuevo(ManagerRegistry $doctrine, Request $request) {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $pikmin = new Pikmin();
        $formulario = $this->createForm(PikminType::class, $pikmin);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $pikmin = $formulario->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($pikmin);
            $entityManager->flush();
            return $this->redirectToRoute('ficha_pikmin', ["codigo" => $pikmin->getId()]);
        }
        return $this->render('nuevo.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }

    #[Route('/pikmins/eliminar/{id}', name: 'eliminar_pikmin', requirements:["id"=>"\d+"])]
    public function eliminar(ManagerRegistry $doctrine, int $id): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Pikmin::class);
        $pikmin = $repositorio->find($id);

        if ($pikmin) {
            try {
                $entityManager->remove($pikmin);
                $entityManager->flush();

                // Redirigir al listado tras eliminar
                return $this->redirectToRoute('inicio');
            } catch (\Exception $e) {
                return new Response("Error eliminando Pikmin: " . $e->getMessage());
            }
        } else {
            return new Response("Pikmin no encontrado");
        }
    }


    #[Route('/pikmins/editar/{codigo}', name: 'editar', requirements:["codigo"=>"\d+"])]
    public function editar(ManagerRegistry $doctrine, Request $request, int $codigo) {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $repositorio = $doctrine->getRepository(Pikmin::class);
        $pikmin = $repositorio->find($codigo);

        if ($pikmin){
            $formulario = $this->createForm(PIkminType::class, $pikmin);
            $formulario->handleRequest($request);

            if ($formulario->isSubmitted() && $formulario->isValid()) {
                //Esta parte es igual que en la ruta para insertar
                $pikmin = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($pikmin);
                $entityManager->flush();
                return $this->redirectToRoute('ficha_pikmin', ["codigo" => $pikmin->getId()]);
            }
            return $this->render('nuevo.html.twig', array(
                'formulario' => $formulario->createView()
            ));

        }else{
            return $this->render('ficha_pikmin.html.twig', [
                'pikmin' => NULL
            ]);
        }
    }

    #[Route('/pikmins/buscar/{texto}', name: 'buscar_pikmin')]
    public function buscar(ManagerRegistry $doctrine, $texto): Response
    {
        $repositorio = $doctrine->getRepository(Pikmin::class);

        $pikmins = $repositorio->findByName($texto);

        return $this->render('lista_pikmin.html.twig', [
            'pikmins' => $pikmins
        ]);
    }
    #[Route('/pikmins/{codigo}', name: 'ficha_pikmin')]
    public function ficha_pikmin(ManagerRegistry $doctrine, $codigo): Response
    {
        $repositorio = $doctrine->getRepository(Pikmin::class);

        $pikmin = $repositorio->find($codigo);

        return $this->render('ficha_pikmin.html.twig', [
            'pikmin' => $pikmin
        ]);
    }

    #[Route('/', name: 'inicio')]
    public function inicio(ManagerRegistry $doctrine): Response
    {
        $repositorio = $doctrine->getRepository(Pikmin::class);
        $pikmins = $repositorio->findAll();
        return $this->render("inicio.html.twig", ["pikmins" => $pikmins]);
    }


    #[Route('/pikmins/insertar', name: 'insertar_pikmin')]
    public function insertar(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        foreach($this->pikmins as $c){
            $pikmin = new Pikmin();
            $pikmin->setNombre($c["nombre"]);
            $entityManager->persist($pikmin);
        }

        try
        {
            $entityManager->flush();
            return new Response("Pikmin insertados");
        } catch (\Exception $e) {
            return new Response("Error insertando Pikmin");
        }
    }
    private $pikmins = [
        1 => ["nombre" => "Pikmin1", "color" => "rojo"],
        2 => ["nombre" => "Pikmin2","color" => "amarillo"],
        5 => ["nombre" => "Pikmin3","color" => "azul"],
    ];

}