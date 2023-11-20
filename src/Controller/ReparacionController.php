<?php

namespace App\Controller;

use App\Entity\Estadoreparacion;
use App\Entity\Reparacion;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReparacionController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reparacion', name: 'app_reparacion')]
    public function index(): Response
    {
        $reparaciones = $this->entityManager->getRepository(Reparacion::class)->findAll();
        $parametros['reparaciones'] = $reparaciones;

        return $this->render('reparacion/index.html.twig', $parametros);
    }

    #[Route('/reparacion/estado/{id}', name: 'app_reparacion_estado', methods: ['GET', 'POST'])]
    public function edit(int $id): Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $empleado = $this->getUser();
            $reparacion = $this->entityManager->getRepository(Reparacion::class)->find($id);
            $reparacion->setIdestadoReparacion($this->entityManager->getRepository(Estadoreparacion::class)->find($_POST['estado']));
            switch ($_POST['estado']) {
                case '1':
                    $reparacion->setfechaInicio(null);
                    $reparacion->setfechaFin(null);
                    $reparacion->setComentarioReparacion(null);
                    $reparacion->setPrecio(null);
                    $reparacion->setIdempleado(null);
                    break;
                case '2':
                    empty($_POST['fecha_inicio']) ?  : $reparacion->setfechaInicio(DateTime::createFromFormat('Y-m-d', $_POST['fecha_inicio']));
                    empty($_POST['comentario_reparacion']) ?  : $reparacion->setComentarioReparacion($_POST['comentario_reparacion']);
                    $reparacion->setIdempleado($empleado);
                    break;
                case '3':
                    empty($_POST['fecha_inicio']) ?  : $reparacion->setfechaInicio(DateTime::createFromFormat('Y-m-d', $_POST['fecha_inicio']));
                    empty($_POST['fecha_fin']) ?  : $reparacion->setfechaFin(DateTime::createFromFormat('Y-m-d', $_POST['fecha_fin']));
                    empty($_POST['comentario_reparacion']) ?  : $reparacion->setComentarioReparacion($_POST['comentario_reparacion']);
                    empty($_POST['precio']) ?  : $reparacion->setPrecio($_POST['precio']);
                    $reparacion->setIdempleado($empleado);
                    break;
            }
            
            $this->entityManager->flush();
            return $this->redirectToRoute('app_reparacion');
        } else {
        $reparacion = $this->entityManager->getRepository(Reparacion::class)->findOneBy(array('idreparacion' => $id));
        $parametros['reparacion'] = $reparacion;
        $estados = $this->entityManager->getRepository(Estadoreparacion::class)->findAll();
        $parametros['estados'] = $estados;

        return $this->render('reparacion/edit.html.twig', $parametros);
        }
        
    }
}
