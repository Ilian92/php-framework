<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class DeleteContactController extends AbstractController
{
    public function process(Request $request): Response
    {
        return $this->deleteMethod($request->getEmail());
    }

    public function deleteMethod($email): Response
    {
        // Choisit le dossier où chercher le fichier correspondant
        $directory = __DIR__ . '/../../var/contacts/';
        $pattern = $directory . '*_' . $email . '.json';
        $files = glob($pattern);

        // Vérification si aucun fichier n'a été trouvé
        if (!$files) {
            return new Response(json_encode(['error' => 'Contact not found']), http_response_code(404), ['Content-Type' => 'application/json']);
        }

        // Suppression de chaque fichier trouvé
        foreach ($files as $file) {
            unlink($file);
        }

        return new Response('', http_response_code(204), ['Content-Type' => 'application/json']);
    }
}
