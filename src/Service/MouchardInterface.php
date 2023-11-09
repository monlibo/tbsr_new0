<?php

namespace App\Service;

interface MouchardInterface
{
    public function saveMouchard($entite, $idEntite, $libelleEntite, $action, $profil, $auteur, $observations);
}