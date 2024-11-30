<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Http\Request;
use App\Http\Response;

class GetContactController extends AbstractController
{
    public function process(Request $request): Response
    {
        return $this->getMethod($request->getEmail());
    }

    // Methode GET pour récupérer les informations du fichier désigné par l'email
    private function getMethod($email): Response
    {
        // Choisit le dossier où chercher le fichier correspondant
        $directory = __DIR__ . '/../../var/contacts/';
        $pattern = $directory . '*_' . $email . '.json';
        $files = glob($pattern);

        // Vérification si aucun fichier n'a été trouvé
        if (!$files) {
            return new Response(json_encode(['error' => 'Contact not found']), http_response_code(404), ['Content-Type' => 'application/json']);
        }

        // Lecture du contenu du fichier trouvé
        $data = file_get_contents($files[0]);

        // Retourne une réponse avec les données du contact en format JSON
        return new Response($data, http_response_code(200), ['Content-Type' => 'application/json']);
    }
}
