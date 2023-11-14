<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Entity\Consola;
use App\Entity\Articulo;
use App\Entity\Etiqueta;
use App\Entity\Plataforma;
use App\Entity\Videojuego;
use App\Entity\VistaEntity;
use App\Entity\Dispositivomovil;
use App\Entity\Plataformaconsola;
use App\Entity\Etiquetavideojuego;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ArticuloController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/articulos', name: 'app_articulo')]
    public function index(Request $request): Response
    {
        $error = $request->getContent();
        $parametros['error'] = false;
        if ($error) {
            $parametros['error'] = $error;
        }

        $parametros['titulo'] = 'Articulos';

        $articulos = $this->entityManager->getRepository(VistaEntity::class)->findAll();


        $parametros['articulos'] = $articulos;

        return $this->render('articulos/index.html.twig', $parametros);
    }



    #[Route('/articulos/add', name: 'app_articulo_add', methods:['GET', 'POST'])]
    public function addArticulos(Request $request, SluggerInterface $sluggerInterface): Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = false;
            $nombreFoto = '';
            $articulo = new Articulo();
            empty($_POST['nombre']) ? $error = true : $articulo->setNombre($_POST['nombre']);
            empty($_POST['precio']) ? $error = true : $articulo->setPrecio($_POST['precio']);
            empty($_POST['stock']) ? $error = true : $articulo->setStock($_POST['stock']);
            empty($_POST['stock_alquiler']) ? $error = true : $articulo->setStockalquiler($_POST['stock_alquiler']);

            if (empty($_FILES['foto']['name'])) {
                $error = true;
            } else {
                if (pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpg' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'png' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpeg' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'webp') 
                {
                    $error = true;
                } else
                {
                    $nombreFoto = $sluggerInterface->slug(pathinfo($_FILES['foto']['name'], PATHINFO_FILENAME));
                    $nombreFoto = $nombreFoto . '-' . uniqid() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                    try {
                        /** @var UploadedFile $uploadedFile */
                        $uploadedFile = $request->files->get('foto');

                        $uploadedFile->move(
                            $this->getParameter('images_directory'),
                            $nombreFoto
                        );
                        $articulo->setFoto($nombreFoto);
                        
                    } catch (FileException $e) {
                        $error = true;
                    }
                }
            }
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

                            for ($i=0; $i < sizeof($_POST['plataformas']); $i++) { 
                                $paltaformaConsola = new Plataformaconsola();
                                $paltaformaConsola->setIdconsola($consola);
                                $paltaforma = $this->entityManager->getRepository(Plataforma::class)->findOneby(array('idplataforma' => $_POST['plataformas'][$i]));
                                if (is_null($paltaforma)) {
                                    return $this->redirectToRoute('app_articulo');
                                } else {
                                    $paltaformaConsola->setIdplataforma($paltaforma);
                                    $this->entityManager->persist($paltaformaConsola);
                                    $this->entityManager->flush();
                                }
                                
                            }

                            return $this->redirectToRoute('app_articulo');
                        } else {
                            $this->entityManager->remove($articulo);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear la consola']);
                        }
                    } else {
                        return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear el producto']);
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
                            return $this->redirectToRoute('app_articulo');
                        } else {
                            
                            $this->entityManager->remove($articulo);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear el dispositivo']);
                        }
                    } else {
                        return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear el producto']);
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

                            for ($i=0; $i < sizeof($_POST['etiquetas']); $i++) { 
                                $etiquetavideojuego = new Etiquetavideojuego();
                                var_dump([$i]);
                                $etiqueta = $this->entityManager->getRepository(Etiqueta::class)->findOneBy(array('idetiqueta' => $_POST['etiquetas'][$i]));
                                $etiquetavideojuego->setIdetiqueta($etiqueta);
                                $etiquetavideojuego->setIdvideojuego($videoJuego);
                                if (is_null($etiqueta)) {
                                    return $this->redirectToRoute('app_articulo');
                                } else {
                                    $this->entityManager->persist($etiquetavideojuego);
                                    $this->entityManager->flush();
                                }
                            }
                            return $this->redirectToRoute('app_articulo');
                        } else {
                            $this->entityManager->remove($articulo);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear el videojuego']);
                        }
                    } else {
                        return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear el producto']);
                    }
                    break;
                default:

                    break;
            }
            return $this->redirectToRoute('app_articulo');
        } else {
            $etiqueta = $this->entityManager->getRepository(Etiqueta::class)->findAll();
            $parametros['etiquetas'] = $etiqueta;
            $marcas = $this->entityManager->getRepository(Marca::class)->findAll();
            $parametros['marcas'] = $marcas;
            $plataformas = $this->entityManager->getRepository(Plataforma::class)->findAll();
            $parametros['plataformas'] = $plataformas;
        }
        return $this->render('articulos/add.html.twig', $parametros);
    }

    #[Route('/articulos/delete/{id}', name: 'app_articulo_delete', methods:['POST'])]
    public function delete(int $id): Response
    {

        $articulo = $this->entityManager->getRepository(Articulo::class)->findOneBy(array('idarticulo' => $id));

        $vistaTipo = $this->entityManager->getRepository(VistaEntity::class)->findOneBy(array('idarticulo' => $id));

        switch ($vistaTipo->getTipoarticulo()) {
            case 'Consola':
                $this->entityManager->getRepository(Plataformaconsola::class)->removeByConsola($vistaTipo->getIdtipoClase());
                $this->entityManager->remove($this->entityManager->getRepository(Consola::class)->findOneBy(array('idarticulo' => $id)));
                $this->entityManager->flush();
                break;
            case 'DispositivoMovil':
                $this->entityManager->remove($this->entityManager->getRepository(Dispositivomovil::class)->findOneBy(array('idarticulo' => $id)));
                $this->entityManager->flush();
                break;
            case 'Videojuego':
                $this->entityManager->remove($this->entityManager->getRepository(Videojuego::class)->findOneBy(array('idarticulo' => $id)));
                $this->entityManager->getRepository(Etiquetavideojuego::class)->removeByVideojuego($vistaTipo->getIdtipoClase());
                $this->entityManager->flush();
                break;
            default:
                # code...
                break;
        }

        $this->entityManager->remove($articulo);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_articulo');
    }

    #[Route('/articulos/edit/{id}', name: 'app_articulo_edit', methods:['GET', 'POST'])]
    public function edit(int $id, SluggerInterface $sluggerInterface, Request $request): Response
    {

        $articulo = $this->entityManager->getRepository(Articulo::class)->findOneBy(array('idarticulo' => $id));

        $parametros['articulo'] = $articulo;
    
        $vistaTipo = $this->entityManager->getRepository(VistaEntity::class)->findOneBy(array('idarticulo' => $id));
    
        $parametros['tipo'] = $vistaTipo->getTipoarticulo();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            empty($_POST['nombre']) ? : $articulo->setNombre($_POST['nombre']);
            empty($_POST['precio']) ? : $articulo->setPrecio($_POST['precio']);
            empty($_POST['stock']) ? : $articulo->setStock($_POST['stock']);
            empty($_POST['stock_alquiler']) ? : $articulo->setStockalquiler($_POST['stock_alquiler']);
            if (empty($_FILES['foto']['name'])) {
                
            } else {
                if (pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpg' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'png' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpeg') 
                {
                    
                } else
                {
                    $nombreFoto = $sluggerInterface->slug(pathinfo($_FILES['foto']['name'], PATHINFO_FILENAME));
                    $nombreFoto = $nombreFoto . '-' . uniqid() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                    try {
                        /** @var UploadedFile $uploadedFile */
                        $uploadedFile = $request->files->get('foto');

                        $uploadedFile->move(
                            $this->getParameter('images_directory'),
                            $nombreFoto
                        );
                        $articulo->setFoto($nombreFoto);
                        
                    } catch (FileException $e) {
                        $error = true;
                    }
                }
            }
            empty($_POST['idMarca']) ? : $articulo->setIdmarca($this->entityManager->getRepository(Marca::class)->findOneby(array('idmarca' => $_POST['idMarca'])));
            $this->entityManager->persist($articulo);
            $this->entityManager->flush();
            switch ($vistaTipo->getTipoarticulo()) {
                case 'Consola':
                    $articuloTipo = $this->entityManager->getRepository(Consola::class)->findOneBy(array('idarticulo' => $id));
                    empty($_POST['modelo']) ? : $articuloTipo->setModelo($_POST['modelo']);
                    empty($_POST['cant_mandos']) ? : $articuloTipo->setCantmandos($_POST['cant_mandos']);
                    empty($_POST['almacenamientoConsola']) ? : $articuloTipo->setAlmacenamiento($_POST['almacenamientoConsola']);
                    $this->entityManager->getRepository(Plataformaconsola::class)->removeByConsola($articuloTipo->getIdconsola());
                    for ($i=0; $i < sizeof($_POST['plataformas']); $i++) { 
                        $paltaformaConsola = new Plataformaconsola();
                        $paltaformaConsola->setIdconsola($articuloTipo);
                        $paltaforma = $this->entityManager->getRepository(Plataforma::class)->findOneby(array('idplataforma' => $_POST['plataformas'][$i]));
                        if (is_null($paltaforma)) {
                            return $this->redirectToRoute('app_articulo');
                        } else {
                            $paltaformaConsola->setIdplataforma($paltaforma);
                            $this->entityManager->persist($paltaformaConsola);
                            $this->entityManager->flush();
                        }
                    }
                    break;
                case 'DispositivoMovil':
                    $articuloTipo = $this->entityManager->getRepository(Dispositivomovil::class)->findOneBy(array('idarticulo' => $id));
                    empty($_POST['almacenamiento']) ? : $articuloTipo->setAlmacenamiento($_POST['almacenamiento']);
                    empty($_POST['ram']) ? : $articuloTipo->setRam($_POST['ram']);
                    empty($_POST['pantalla']) ? : $articuloTipo->setTamanoPantalla($_POST['pantalla']);
                    break;
                case 'Videojuego':
                    $articuloTipo = $this->entityManager->getRepository(Videojuego::class)->findOneBy(array('idarticulo' => $id));
                    empty($_POST['plataforma']) ? : $articuloTipo->setIdplataforma($this->entityManager->getRepository(Plataforma::class)->findOneby(array('idplataforma' => $_POST['plataforma'])));
                    $this->entityManager->getRepository(Etiquetavideojuego::class)->removeByVideojuego($articuloTipo->getIdvideojuego());
                    for ($i=0; $i < sizeof($_POST['etiquetas']); $i++) { 
                        $etiquetavideojuego = new Etiquetavideojuego();
                        $etiqueta = $this->entityManager->getRepository(Etiqueta::class)->findOneBy(array('idetiqueta' => $_POST['etiquetas'][$i]));
                        $etiquetavideojuego->setIdetiqueta($etiqueta);
                        $etiquetavideojuego->setIdvideojuego($articuloTipo);
                        if (is_null($etiqueta)) {
                            return $this->redirectToRoute('app_articulo');
                        } else {
                            $this->entityManager->persist($etiquetavideojuego);
                            $this->entityManager->flush();
                        }
                    }
                    break;
                default:
                    # code...
                    break;
            }
            $this->entityManager->persist($articuloTipo);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_articulo');
        } else {
            $datosExtraExtra = null;    
            switch ($vistaTipo->getTipoarticulo()) {
                case 'Consola':
                    $datosExtra = $this->entityManager->getRepository(Consola::class)->findOneBy(array('idconsola' => $vistaTipo->getIdtipoClase()));
                    $datosExtraExtra = $this->entityManager->getRepository(Plataformaconsola::class)->findBy(array('idconsola' => $vistaTipo->getIdtipoClase()));
                    break;
                case 'DispositivoMovil':
                    $datosExtra = $this->entityManager->getRepository(Dispositivomovil::class)->findOneBy(array('iddispositivomovil' => $vistaTipo->getIdtipoClase()));
                    break;
                case 'Videojuego':
                    $datosExtra = $this->entityManager->getRepository(Videojuego::class)->findOneBy(array('idvideojuego' => $vistaTipo->getIdtipoClase()));
                    $datosExtraExtra = $this->entityManager->getRepository(Etiquetavideojuego::class)->findBy(array('idvideojuego' => $vistaTipo->getIdtipoClase()));
                    break;
                default:
                    $datosExtra = null;
                    break;
            }
            
            $parametros['datosExtra'] = $datosExtra;
            $parametros['datosExtraExtra'] = $datosExtraExtra;
            $marcas = $this->entityManager->getRepository(Marca::class)->findAll();
            $parametros['marcas'] = $marcas;
            $plataformas = $this->entityManager->getRepository(Plataforma::class)->findAll();
            $etiqueta = $this->entityManager->getRepository(Etiqueta::class)->findAll();
            $parametros['etiquetas'] = $etiqueta;
            $parametros['plataformas'] = $plataformas;

            return $this->render('articulos/edit.html.twig', $parametros);
        }
    }

    #[Route('/api/articulos', name: 'app_articulo_api', methods:['GET'])]
    public function indexApi(): Response
    {
        $articulos = $this->entityManager->getRepository(VistaEntity::class)->findAll();

        //$articulos = $this->entityManager->getRepository(VistaEntity::class)->find3TypeStartingBy('Consola', $offset);

        return $this->convertToJson($articulos);   
    }


    #[Route('/api/articulos/{tipo}', name: 'app_articulo_api_tipo', methods:['GET'])]
    public function ArticulosTipo(string $tipo): Response
    {
        $articulos = $this->entityManager->getRepository(VistaEntity::class)->findByType($tipo);

        return $this->convertToJson($articulos);   
    }

    
    #[Route('/api/articulos/buscar', name: 'app_articulo_api_buscar', methods:['POST'])]
    public function ArticulosBuscar(Request $request): Response
    {
        $datos = json_decode($request->getContent(), true);

        $tipoArticulo = $datos['tipoArticulo'];

        $busqueda = $datos['busqueda'];

        $articulos = $this->entityManager->getRepository(VistaEntity::class)->searchArticulo($tipoArticulo, $busqueda);

        return $this->convertToJson($articulos);   
    }

    #[Route('/api/articulos/ver/{id}', name: 'app_articulo_ver')]
    public function verArticulo(int $id): JsonResponse
    {
        $articulo = $this->entityManager->getRepository(VistaEntity::class)->findOneBy(['idarticulo'=>$id]);

        $datos = array();

        switch ($articulo->getTipoarticulo()) {
            case 'Consola':
                array_push($datos, $this->entityManager->getRepository(Consola::class)->findOneBy(['idarticulo'=>$id]));
                $plataformas = $this->entityManager->getRepository(Plataformaconsola::class)->findBy(['idconsola'=>$datos[0]->getIdconsola()]);
                foreach ($plataformas as $plataforma) {
                    array_push($datos, $plataforma->getIdplataforma());
                }
                break;
            
            case 'DispositivoMovil':
                array_push($datos, $this->entityManager->getRepository(Dispositivomovil::class)->findOneBy(['idarticulo'=>$id]));
                break;
            
            case 'Videojuego':
                array_push($datos, $this->entityManager->getRepository(Videojuego::class)->findOneBy(['idarticulo'=>$id]));
                $etiqueta = $this->entityManager->getRepository(Etiquetavideojuego::class)->findBy(['idvideojuego'=>$datos[0]->getIdvideojuego()]);
                foreach ($etiqueta as $etiqueta) {
                    array_push($datos, $etiqueta->getIdetiqueta());
                }
                break;
            default:
                return new JsonResponse(['data' => 'No existe el articulo'], JsonResponse::HTTP_NOT_FOUND);
                break;
        }

        return $this->convertToJson($datos);
    }


    private function convertToJson($object): JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $normalized = $serializer->normalize($object, null, array(DateTimeNormalizer::FORMAT_KEY=>'Y/m/d'));
        $jsonContent = $serializer->serialize($normalized, 'json');
        return JsonResponse::fromJsonString($jsonContent, 200);
    }
}
