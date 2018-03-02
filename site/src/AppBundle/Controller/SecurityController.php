<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 21/02/2018
 * Time: 15:19
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('preference');
        }

        $form = $this->createForm(UserType::class);

            return $this->render('security/login.html.twig', [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error'         => $authenticationUtils->getLastAuthenticationError(),
                'form'          => $form->createView()
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function createUserAction(Request $request, UserManager $userManager)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        $userManager->encodePasswordUser($user);

        if ($request->isMethod('POST') AND $form->isValid()){
            $userManager->addUser($user);

            $request->getSession()->getFlashBag()
                ->add('info', 'Votre compte a bien été créé, vous pouvez vous connectez avec vos identifiants');

            return $this->redirectToRoute('login');
        }
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

}
