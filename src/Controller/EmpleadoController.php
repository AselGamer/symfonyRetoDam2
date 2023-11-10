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
            return $this->redirect('login');
        }

        /** @var Empleado $empleado */
        $empleado = $this->security->getUser();



        return $this->render('empleado/index.html.twig', [
            'controller_name' => 'EmpleadoController',
        ]);
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
            return $this->redirect('login');
        } else {
            /** @var Empleado $empleado */
            $empleado = $this->security->getUser();
            if ($empleado->isGerente() == false) {
                return $this->redirect('login');
            }
        }

        $empleados = $this->entityManager->getRepository(Empleado::class)->findAll();
        $parametros['empleados'] = $empleados;

        return $this->render('empleado/list.html.twig', $parametros);
    }
}
