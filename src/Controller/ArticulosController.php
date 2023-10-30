<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Entity\Consola;
use App\Entity\Articulo;
use App\Entity\Dispositivomovil;
use App\Entity\Plataforma;
use App\Entity\Videojuego;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticulosController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/articulos', name: 'app_articulos')]
    public function index(Request $request): Response
    {
        $error = $request->getContent();
        $parametros['error'] = false;
        if ($error) {
            $parametros['error'] = $error;
        }

        $parametros['titulo'] = 'Articulos';

        $articulos = $this->entityManager->getRepository(Articulo::class)->findAll();

        $parametros['articulos'] = $articulos;

        return $this->render('articulos/index.html.twig', $parametros);
    }

    #[Route('/articulos/add', name: 'app_articulos_add', methods:['GET', 'POST'])]
    public function addArticulos(): Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = false;
            $articulo = new Articulo();
                    empty($_POST['nombre']) ? $error = true : $articulo->setNombre($_POST['nombre']);
                    empty($_POST['precio']) ? $error = true : $articulo->setPrecio($_POST['precio']);
                    empty($_POST['stock']) ? $error = true : $articulo->setStock($_POST['stock']);
                    //Implementar codigo de subida de fotos
                    empty($_FILES['foto']['name']) ? $error = true : $articulo->setFoto($_FILES['foto']['name']);
                    empty($_POST['idMarca']) ? $error = true : $articulo->setIdmarca($this->entityManager->getRepository(Marca::class)->findOneby(array('idmarca' => $_POST['idMarca'])));
            switch ($_POST['tipo']) {
                
                case 'Consola':
                    if (!$error) {
                        
                        $this->entityManager->persist($articulo);
                        $this->entityManager->flush();
                        
                        $consola = new Consola();
                        $consola->setIdarticulo($articulo);
                        empty($_POST['modelo']) ? $error = true : $consola->setModelo($_POST['modelo']);
                        empty($_POST['cant_mandos']) ? $error = true : $consola->setCantmandos($_POST['cant_mandos']);
                        empty($_POST['almacenamientoConsola']) ? $error = true : $consola->setAlmacenamiento($_POST['almacenamientoConsola']);
                        if (!$error) {
                            $this->entityManager->persist($consola);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulos');
                        } else {
                            $this->entityManager->remove($articulo);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulos', ['error' => 'fallo al crear la consola']);
                        }
                    } else {
                        return $this->redirectToRoute('app_articulos', ['error' => 'fallo al crear el producto']);
                    }
                    break;
                case 'Dispositivo Movil':
                    if (!$error) {
                        
                        $this->entityManager->persist($articulo);
                        $this->entityManager->flush();
                        
                        $dispMovil = new Dispositivomovil();
                        $dispMovil->setIdarticulo($articulo);
                        empty($_POST['almacenamiento']) ? $error = true : $dispMovil->setAlmacenamiento($_POST['almacenamiento']);
                        empty($_POST['ram']) ? $error = true : $dispMovil->setRam($_POST['ram']);
                        empty($_POST['pantalla']) ? $error = true : $dispMovil->setTamanoPantalla($_POST['pantalla']);
                        if (!$error) {
                            $this->entityManager->persist($dispMovil);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulos');
                        } else {
                            
                            $this->entityManager->remove($articulo);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulos', ['error' => 'fallo al crear el dispositivo']);
                        }
                    } else {
                        return $this->redirectToRoute('app_articulos', ['error' => 'fallo al crear el producto']);
                    }
                    break;
                case 'VideoJuego':
                    if (!$error) {
                        
                        $this->entityManager->persist($articulo);
                        $this->entityManager->flush();
                        
                        $videoJuego = new Videojuego();
                        $videoJuego->setIdarticulo($articulo);
                        empty($_POST['plataforma']) ? $error = true : $videoJuego->setIdplataforma($this->entityManager->getRepository(Plataforma::class)->findOneby(array('idplataforma' => $_POST['plataforma'])));
                        if (!$error) {
                            $this->entityManager->persist($videoJuego);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulos');
                        } else {
                            $this->entityManager->remove($articulo);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulos', ['error' => 'fallo al crear el videojuego']);
                        }
                    } else {
                        return $this->redirectToRoute('app_articulos', ['error' => 'fallo al crear el producto']);
                    }
                    break;
                default:

                    break;
            }
            return $this->redirectToRoute('app_articulos');
        } else {
            $marcas = $this->entityManager->getRepository(Marca::class)->findAll();
            $parametros['marcas'] = $marcas;
            $plataformas = $this->entityManager->getRepository(Plataforma::class)->findAll();
            $parametros['plataformas'] = $plataformas;
        }
        return $this->render('articulos/add.html.twig', $parametros);
    }

    #[Route('/articulos/delete/{id}', name: 'app_articulos_delete')]
    public function delete(Int $id): Response
    {
        return $this->render('articulos/index.html.twig');
    }

    #[Route('/articulos/edit/{id}', name: 'app_articulos_edit')]
    public function edit(Int $id): Response
    {
        return $this->render('articulos/index.html.twig');
    }
}
