<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Entity\Consola;
use App\Entity\Articulo;
use App\Entity\Detalletransaccion;
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
            $error = "";
            $nombreFoto = '';
            $articulo = new Articulo();
            empty($_POST['nombre']) ? $error .= "Nombre Invalido " : $articulo->setNombre($_POST['nombre']);
            empty($_POST['precio']) || !is_numeric($_POST['precio']) ? $error .= "Precio Invalido " : $articulo->setPrecio($_POST['precio']);
            !is_numeric($_POST['stock']) && $_POST['stock'] < 0 ? $error .= "Stock Invalido " : $articulo->setStock($_POST['stock']);
            !is_numeric($_POST['stock_alquiler']) && $_POST['stock_alquiler'] < 0 ? $error .= "Stock Alquiler Invalido " : $articulo->setStockalquiler($_POST['stock_alquiler']);
            
            if (empty($_FILES['foto']['name'])) {
                $error .= "Foto Vacia";
            } else {
                if (pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpg' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'png' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpeg' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'webp') 
                {
                    $error .= "Formato de foto invalido ";
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
                        $error .= "Fallo al subir la foto";
                    }
                }
            }
            empty($_POST['idMarca']) ? $error .= "Marca Invalida " : $articulo->setIdmarca($this->entityManager->getRepository(Marca::class)->findOneby(array('idmarca' => $_POST['idMarca'])));
            switch ($_POST['tipo']) {
                
                case 'Consola':
                    if ($error == "") {
                        $this->entityManager->persist($articulo);
                        $this->entityManager->flush();
                        
                        $consola = new Consola();
                        $consola->setIdarticulo($articulo);
                        empty($_POST['modelo']) ? $error .= "Modelo Invalido " : $consola->setModelo($_POST['modelo']);
                        empty($_POST['cant_mandos']) ? $error = "Cantidad de mando Invalidos " : $consola->setCantmandos($_POST['cant_mandos']);
                        empty($_POST['almacenamientoConsola']) ? $error = "Almacenamiento Invalido " : $consola->setAlmacenamiento($_POST['almacenamientoConsola']);
                        if ($error == "") {
                            $this->entityManager->persist($consola);
                            $this->entityManager->flush();

                            for ($i=0; $i < sizeof($_POST['plataformas']); $i++) { 
                                $paltaformaConsola = new Plataformaconsola();
                                $paltaformaConsola->setIdconsola($consola);
                                $paltaforma = $this->entityManager->getRepository(Plataforma::class)->findOneby(array('idplataforma' => $_POST['plataformas'][$i]));
                                if (is_null($paltaforma)) {
                                    $this->addFlash(
                                       'error',
                                       $error
                                    );
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
                        $this->addFlash(
                           'error',
                            $error
                        );
                        
                        return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear el producto']);
                    }
                    break;
                case 'Dispositivo Movil':
                    if ($error == "") {
                        
                        $this->entityManager->persist($articulo);
                        $this->entityManager->flush();
                        
                        $dispMovil = new Dispositivomovil();
                        $dispMovil->setIdarticulo($articulo);
                        empty($_POST['almacenamiento']) ? $error .= "Almacenamiento Invalido " : $dispMovil->setAlmacenamiento($_POST['almacenamiento']);
                        empty($_POST['ram']) ? $error .= "Ram Invalida " : $dispMovil->setRam($_POST['ram']);
                        empty($_POST['pantalla']) ? $error .= "Pantalla Invalida" : $dispMovil->setTamanoPantalla($_POST['pantalla']);
                        if ($error == "") {
                            $this->entityManager->persist($dispMovil);
                            $this->entityManager->flush();
                            return $this->redirectToRoute('app_articulo');
                        } else {
                            
                            $this->entityManager->remove($articulo);
                            $this->entityManager->flush();
                            $this->addFlash(
                               'error',
                               $error
                            );
                            return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear el dispositivo']);
                        }
                    } else {
                        return $this->redirectToRoute('app_articulo', ['error' => 'fallo al crear el producto']);
                    }
                    break;
                case 'VideoJuego':
                    if ($error == "") {
                        
                        $this->entityManager->persist($articulo);
                        $this->entityManager->flush();
                        
                        $videoJuego = new Videojuego();
                        $videoJuego->setIdarticulo($articulo);
                        empty($_POST['plataforma']) ? $error .= "Plataforma Invalida " : $videoJuego->setIdplataforma($this->entityManager->getRepository(Plataforma::class)->findOneby(array('idplataforma' => $_POST['plataforma'])));
                        if ($error == "") {
                            $this->entityManager->persist($videoJuego);
                            $this->entityManager->flush();

                            for ($i=0; $i < sizeof($_POST['etiquetas']); $i++) { 
                                $etiquetavideojuego = new Etiquetavideojuego();
                                $etiqueta = $this->entityManager->getRepository(Etiqueta::class)->findOneBy(array('idetiqueta' => $_POST['etiquetas'][$i]));
                                $etiquetavideojuego->setIdetiqueta($etiqueta);
                                $etiquetavideojuego->setIdvideojuego($videoJuego);
                                if (is_null($etiqueta)) {
                                    $this->addFlash(
                                       'error',
                                       $error
                                    );
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

    #[Route('/articulos/delete/{id}', name: 'app_articulo_delete', methods:['GET'])]
    public function delete(int $id): Response
    {

        $articulo = $this->entityManager->getRepository(Articulo::class)->findOneBy(array('idarticulo' => $id));

        $transacciones = $this->entityManager->getRepository(Detalletransaccion::class)->findBy(array('idarticulo' => $id));

        $imagenArticulo = $articulo->getFoto();

        if (sizeof($transacciones) > 0) {
            $this->addFlash(
                'error',
                'No se puede eliminar el articulo porque tiene transacciones asociadas'
             );
            return $this->redirectToRoute('app_articulo');
        }

        $vistaTipo = $this->entityManager->getRepository(VistaEntity::class)->findOneBy(array('idarticulo' => $id));

        switch ($vistaTipo->getTipoarticulo()) {
            case 'Consola':
                $this->entityManager->getRepository(Plataformaconsola::class)->removeByConsola($vistaTipo->getIdtipoClase());
                $this->entityManager->remove($this->entityManager->getRepository(Consola::class)->findOneBy(array('idarticulo' => $id)));
                break;
            case 'DispositivoMovil':
                $this->entityManager->remove($this->entityManager->getRepository(Dispositivomovil::class)->findOneBy(array('idarticulo' => $id)));
                break;
            case 'Videojuego':
                $this->entityManager->remove($this->entityManager->getRepository(Videojuego::class)->findOneBy(array('idarticulo' => $id)));
                $this->entityManager->getRepository(Etiquetavideojuego::class)->removeByVideojuego($vistaTipo->getIdtipoClase());
                break;
            default:
                # code...
                break;
        }

        $this->entityManager->remove($articulo);
        $this->entityManager->flush();

        if ($imagenArticulo != null) {
            unlink($this->getParameter('images_directory') . '/' . $imagenArticulo);
        }

        return $this->redirectToRoute('app_articulo');
    }

    #[Route('/articulos/edit/{id}', name: 'app_articulo_edit', methods:['GET', 'POST'])]
    public function edit(int $id, SluggerInterface $sluggerInterface, Request $request): Response
    {

        $error = "";

        $articulo = $this->entityManager->getRepository(Articulo::class)->findOneBy(array('idarticulo' => $id));

        $parametros['articulo'] = $articulo;
    
        $vistaTipo = $this->entityManager->getRepository(VistaEntity::class)->findOneBy(array('idarticulo' => $id));
    
        $parametros['tipo'] = $vistaTipo->getTipoarticulo();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            empty($_POST['nombre']) ? $error .= "Nombre Invalido" : $articulo->setNombre($_POST['nombre']);
            empty($_POST['precio']) || $_POST['precio'] < 0 ? $error .= "Precio Invalido" : $articulo->setPrecio($_POST['precio']);
            !is_numeric($_POST['stock']) || $_POST['stock'] < 0 ? $error .= "Stock Invalido" : $articulo->setStock($_POST['stock']);
            !is_numeric($_POST['stock_alquiler']) || $_POST['stock_alquiler'] < 0 ? $error .= "Stock Alquiler Invalido" : $articulo->setStockalquiler($_POST['stock_alquiler']);
            if ($error != "") {
                $this->addFlash(
                    'error',
                    $error
                 );
                return $this->redirectToRoute('app_articulo');
            }
            if (empty($_FILES['foto']['name'])) {
                
            } else {
                if (pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpg' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'png' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpeg') 
                {
                    $error .= "Formato de foto Invalido";   
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
                        $error .= "Fallo al subir la foto";
                    }
                }
            }
            empty($_POST['idMarca']) ? $error .= "Marca Invalido " : $articulo->setIdmarca($this->entityManager->getRepository(Marca::class)->findOneby(array('idmarca' => $_POST['idMarca'])));
            $this->entityManager->persist($articulo);
            $this->entityManager->flush();
            switch ($vistaTipo->getTipoarticulo()) {
                case 'Consola':
                    $articuloTipo = $this->entityManager->getRepository(Consola::class)->findOneBy(array('idarticulo' => $id));
                    empty($_POST['modelo']) ? $error .= "Modelo Invalido " : $articuloTipo->setModelo($_POST['modelo']);
                    empty($_POST['cant_mandos']) ? $error .= "Cantidad de mandos Invalido " : $articuloTipo->setCantmandos($_POST['cant_mandos']);
                    empty($_POST['almacenamientoConsola']) ? $error .= "Almacenamiento Invalido " : $articuloTipo->setAlmacenamiento($_POST['almacenamientoConsola']);
                    $this->entityManager->getRepository(Plataformaconsola::class)->removeByConsola($articuloTipo->getIdconsola());
                    for ($i=0; $i < sizeof($_POST['plataformas']); $i++) { 
                        $paltaformaConsola = new Plataformaconsola();
                        $paltaformaConsola->setIdconsola($articuloTipo);
                        $paltaforma = $this->entityManager->getRepository(Plataforma::class)->findOneby(array('idplataforma' => $_POST['plataformas'][$i]));
                        if (is_null($paltaforma)) {
                            $error .= "Plataforma Invalida ";
                            if ($error != "") {
                                $this->addFlash(
                                    'error',
                                    $error
                                 );
                            }
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
                    empty($_POST['almacenamiento']) ? $error .= "Almacenamiento Invalido" : $articuloTipo->setAlmacenamiento($_POST['almacenamiento']);
                    empty($_POST['ram']) ? $error .= "Ram Invalida " : $articuloTipo->setRam($_POST['ram']);
                    empty($_POST['pantalla']) ? $error .= "Pantalla Invalida " : $articuloTipo->setTamanoPantalla($_POST['pantalla']);
                    break;
                case 'Videojuego':
                    $articuloTipo = $this->entityManager->getRepository(Videojuego::class)->findOneBy(array('idarticulo' => $id));
                    empty($_POST['plataforma']) ? $error .= "Plataforma Invalida " : $articuloTipo->setIdplataforma($this->entityManager->getRepository(Plataforma::class)->findOneby(array('idplataforma' => $_POST['plataforma'])));
                    $this->entityManager->getRepository(Etiquetavideojuego::class)->removeByVideojuego($articuloTipo->getIdvideojuego());
                    for ($i=0; $i < sizeof($_POST['etiquetas']); $i++) { 
                        $etiquetavideojuego = new Etiquetavideojuego();
                        $etiqueta = $this->entityManager->getRepository(Etiqueta::class)->findOneBy(array('idetiqueta' => $_POST['etiquetas'][$i]));
                        $etiquetavideojuego->setIdetiqueta($etiqueta);
                        $etiquetavideojuego->setIdvideojuego($articuloTipo);
                        if (is_null($etiqueta)) {
                            $error .= "Etiqueta Invalida";
                            if ($error != "") {
                                $this->addFlash(
                                    'error',
                                    $error
                                 );
                            }
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
            if ($error != "") {
                $this->addFlash(
                    'error',
                    $error
                 );
            }
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


    #[Route('/api/articulos/tipo/{tipo}', name: 'app_articulo_api_tipo', methods:['GET'])]
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

    #[Route('/api/articulos/buscarEtiqueta/{etiqueta}', name: 'app_articulo_buscar_etiquetas')]
    public function buscarEtiquetas(string $etiqueta): JsonResponse
    {
        $articulos = $this->entityManager->getRepository(Articulo::class)->findVideoJuegoByTag($etiqueta);

        return $this->convertToJson($articulos);
    }

    #[Route('/api/articulos/marca/{marca}', name: 'app_articulo_marcas', methods:['GET'])]
    public function buscarMarcas(string $marca): JsonResponse
    {
        $articulos = $this->entityManager->getRepository(Articulo::class)->findBy(['idmarca'=>$marca]);

        return $this->convertToJson($articulos);
    }

    #[Route('/api/articulos/marcas', name: 'app_articulo_marca_todos', methods:['GET'])]
    public function buscarMarcasAll(): JsonResponse
    {
        $marcasArticulos = array();

        $marcas = $this->entityManager->getRepository(Marca::class)->findAll();

        foreach ($marcas as $marca) {
            $marcasArticulos[$marca->getNombre()] = $this->entityManager->getRepository(Articulo::class)->findBy(['idmarca'=>$marca->getIdmarca()]);
        }

        return $this->convertToJson($marcasArticulos);
    }

    #[Route('/api/articulos/marcas/tipo/{tipo}', name: 'app_articulo_marca_todos_tipo', methods:['GET'])]
    public function buscarMarcasAllTipo(string $tipo): JsonResponse
    {
        $marcasArticulos = array();

        $marcas = $this->entityManager->getRepository(Marca::class)->findMarcaOfArticuloType($tipo);

        foreach ($marcas as $marca) {
            $marcasArticulos[$marca->getNombre()] = $this->entityManager->getRepository(Articulo::class)->findBy(['idmarca'=>$marca->getIdmarca()]);
            if (sizeof($marcasArticulos[$marca->getNombre()]) == 0) {
                unset($marcasArticulos[$marca->getNombre()]);
            }
        }

        return $this->convertToJson($marcasArticulos);
    }

    #[Route('/api/articulos/etiquetas/', name: 'app_articulo_etiquetas_todos', methods:['GET'])]
    public function buscarEtiquetasAll(): JsonResponse
    {
        $etiquetasArticulos = array();

        $etiquetas = $this->entityManager->getRepository(Etiqueta::class)->findAll();

        foreach ($etiquetas as $etiqueta) {
            $etiquetasArticulos[$etiqueta->getNombre()] = $this->entityManager->getRepository(Articulo::class)->findVideoJuegoByTag($etiqueta->getNombre());
            if (sizeof($etiquetasArticulos[$etiqueta->getNombre()]) == 0) {
                unset($etiquetasArticulos[$etiqueta->getNombre()]);
            }
        }

        return $this->convertToJson($etiquetasArticulos);
    }

    #[Route('/api/articulos/tipo/', name: 'app_articulo_tipo_todos', methods:['GET'])]
    public function buscarTipoAll(): JsonResponse
    {
        $tiposArticulos = array();

        $tipos = array('Consola', 'Videojuego', 'DispositivoMovil');

        foreach ($tipos as $tipo) {
            $tiposArticulos[$tipo] = $this->entityManager->getRepository(VistaEntity::class)->findBy(['tipoarticulo'=>$tipo]);
            if (sizeof($tiposArticulos[$tipo]) == 0) {
                unset($tiposArticulos[$tipo]);
            }
        }

        return $this->convertToJson($tiposArticulos);
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
