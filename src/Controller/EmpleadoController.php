<?php

namespace App\Controller;


use App\Entity\Empleado;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmpleadoController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/empleado', name: 'app_empleado')]
    public function index(): Response
    {
        if (is_null($this->security->getUser())) {
            return $this->redirectToRoute('app_empleado_login');
        }

        /** @var Empleado $empleado */
        $empleado = $this->security->getUser();



        return $this->render('empleado/index.html.twig', [
            'controller_name' => 'EmpleadoController',
        ]);
    }

    #[Route('/empleado/pagina/', name: 'app_empleado_redirect')]
    public function empleadoRedirect(): Response
    {
        return $this->redirectToRoute('app_empleado_lista', array('offset' => 1));
    }

    #[Route('/empleado/pagina/{offset}', name: 'app_empleado_lista')]
    public function empleadoLista($offset): Response
    {
        if (is_null($this->security->getUser())) {
            return $this->redirectToRoute('app_empleado_login');
        } else {
            /** @var Empleado $empleado */
            $empleado = $this->security->getUser();
            if ($empleado->isGerente() == false) {
                return $this->redirectToRoute('app_empleado_login');
            }
        if ($offset <= 0) {
            return $this->redirectToRoute('app_empleado_lista', array('offset' => 1));
        }
        }

        $qdb = $this->entityManager->createQueryBuilder();

        $qdb->select('count(e.idempleado)')
            ->from('App\Entity\Empleado', 'e');
        $totalArticulos = $qdb->getQuery()->getSingleScalarResult();

        $cantPaginas = ceil($totalArticulos / 10);

        if ($offset > $cantPaginas) {
            return $this->redirectToRoute('app_empleado_lista', array('offset' => $cantPaginas));
        }
        
        $qdb->select('e')
            ->setFirstResult(($offset - 1) * 10)
            ->setMaxResults(10);
        $empleados = $qdb->getQuery()->getResult();
        $parametros['empleados'] = $empleados;
        $parametros['paginas'] = $cantPaginas;

        return $this->render('empleado/list.html.twig', $parametros);
    }

    #[Route('/empleado/buscar/', name: 'app_empleado_buscar_redirect')]
    public function empleadoBuscarRedirect(): Response
    {
        return $this->redirectToRoute('app_empleado_list');
    }

    #[Route('/empleado/buscar/{busqueda}', name: 'app_empleado_buscar')]
    public function empleadoBuscar(string $busqueda): Response
    {
        if (is_null($this->security->getUser())) {
            return $this->redirectToRoute('app_empleado_login');
        } else {
            /** @var Empleado $empleado */
            $empleado = $this->security->getUser();
            if ($empleado->isGerente() == false) {
                return $this->redirectToRoute('app_empleado_login');
            }
        }

        $qdb = $this->entityManager->createQueryBuilder();
        $qdb->select('a')
            ->from('App\Entity\Empleado', 'a')
            ->where('a.nombre LIKE :busqueda')
            ->orWhere('a.apellido1 LIKE :busqueda')
            ->orWhere('a.apellido2 LIKE :busqueda')
            ->orWhere('a.email LIKE :busqueda')
            ->setParameter('busqueda', '%' . $busqueda . '%');
        $empleados = $qdb->getQuery()->getResult();
        $parametros['empleados'] = $empleados;
        $parametros['paginas'] = 1;

        return $this->render('empleado/list.html.twig', $parametros);
    }

    #[Route('/login', name: 'app_empleado_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //var_dump($authenticationUtils->getLastAuthenticationError());
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }


    #[Route('/register', name: 'app_empleado_register', methods:['GET','POST'])]
    public function register(UserPasswordHasherInterface $passwordHasher): Response
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (is_null($this->security->getUser())) {
                return $this->redirect('login');
            } else {
                /** @var Empleado $empleado */
                $empleado = $this->security->getUser();
                if ($empleado->isGerente() == false) {
                    return $this->redirect('login');
                }
            }
            $existingEmpleado = $this->entityManager->getRepository(Empleado::class)->findOneBy(['email' => $_POST['email']]);
            if ($existingEmpleado !== null) {
                return $this->render('auth/register.html.twig', [
                    'error' => "Error: El usuario ya existe"
                ]);
            } else {
                $error = false;
                empty($_POST['nombre']) ? $error = true : $nombre = $_POST['nombre'];
                empty($_POST['apellido1']) ? $error = true : $apellido = $_POST['apellido1'];
                empty($_POST['apellido2']) ? $error = true : $apellido2 = $_POST['apellido2'];
                empty($_POST['email']) ? $error = true : $email = $_POST['email'];
                empty($_POST['password']) ? $error = true : $password = $_POST['password'];
                $gerente = filter_var($_POST['gerente'], FILTER_VALIDATE_BOOLEAN);


                if ($error) {
                    return $this->render('auth/register.html.twig', [
                        'error' => "Error: Debes rellenar todos los campos"
                    ]);
                } else {
                    $empleado = new Empleado();
                    $empleado->setNombre($nombre);
                    $empleado->setApellido1($apellido);
                    $empleado->setApellido2($apellido2);
                    $empleado->setEmail($email);
                    $hashedPassword = $passwordHasher->hashPassword($empleado, $password);
                    $empleado->setPassword($hashedPassword);
                    $empleado->setGerente($gerente);
                    $this->entityManager->persist($empleado);
                    $this->entityManager->flush();
                    return $this->redirect('login');
                }
            }
        }


        return $this->render('auth/register.html.twig', [
            'error' => null
        ]);
    }

    #[Route('/logout', name: 'app_empleado_logout')]
    public function logout(): Response
    {
        session_destroy();
        return $this->redirect('login');
    }

    #[Route('/empleado/list', name: 'app_empleado_list')]
    public function empleadoList(): Response
    {
        if (is_null($this->security->getUser())) {
            return $this->redirectToRoute('app_empleado_login');
        } else {
            /** @var Empleado $empleado */
            $empleado = $this->security->getUser();
            if ($empleado->isGerente() == false) {
                return $this->redirectToRoute('app_empleado_login');
            }
        }


        return $this->redirectToRoute('app_empleado_lista', array('offset' => 1));
    }

    #[Route('/empleado/editar/{id}', name: 'app_empleado_edit', methods:['GET','POST'])]
    public function empleadoEdit($id, UserPasswordHasherInterface $passwordHasher): Response
    {

        /** @var Empleado $empleado */
        $empleado = $this->getUser();
        if ($empleado == null) {
            return $this->redirectToRoute('app_empleado_lista', array('offset' => 1));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            empty($_POST['newPassword']) ? $error = false : $empleado->setPassword($passwordHasher->hashPassword($empleado, $_POST['newPassword']));
            empty($_POST['nombre']) ? $error = true : $nombre = $_POST['nombre'];
            empty($_POST['apellido1']) ? $error = true : $apellido = $_POST['apellido1'];
            empty($_POST['apellido2']) ? $error = true : $apellido2 = $_POST['apellido2'];
            empty($_POST['email']) ? $error = true : $email = $_POST['email'];
            $gerente = filter_var($_POST['gerente'], FILTER_VALIDATE_BOOLEAN);

            if ($error) {
                $this->addFlash('error', 'Error: Debes rellenar todos los campos');
                return $this->render('empleado/edit.html.twig', [
                    'empleado' => $empleado
                ]);
            } else {
                $empleado->setNombre($nombre);
                $empleado->setApellido1($apellido);
                $empleado->setApellido2($apellido2);
                $empleado->setEmail($email);
                $empleado->setGerente($gerente);
                $this->entityManager->persist($empleado);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_empleado_lista', array('offset' => 1));
            }
        }

        return $this->render('empleado/editar.html.twig', [
            'empleado' => $empleado,
        ]);
    }
}
