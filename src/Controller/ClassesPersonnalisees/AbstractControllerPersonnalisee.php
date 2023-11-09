<?php

namespace App\Controller\ClassesPersonnalisees;

use App\Entity\Mouchard;
use App\Service\MouchardInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractControllerPersonnalisee extends AbstractController implements MouchardInterface
{

}