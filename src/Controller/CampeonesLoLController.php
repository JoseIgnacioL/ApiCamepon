<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Attribute\Route;

class CampeonesLoLController extends AbstractController
{
    #[Route('api/campeones', name: 'campeones')]
    public function getChamps(): JsonResponse
    {
        $conexion = HttpClient::create();

        $respuesta = $conexion->request("GET", 'https://ddragon.leagueoflegends.com/cdn/14.22.1/data/es_ES/champion.json');

        $datos = $respuesta->toArray();

        $campeones = [];

        foreach($datos['data'] as $campeon) {
            $campeones[] = [
                'nombre' => $campeon['name'],
                'frase' => $campeon['title'],
            ];
        }


        $idCampeonAleatorio = array_rand($campeones);

        return $this->json($campeones[$idCampeonAleatorio]);
    }
}
