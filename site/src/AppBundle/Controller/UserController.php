<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:51
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserChangeInfoType;
use AppBundle\Form\UserChangePasswordType;
use AppBundle\Form\UserType;
use AppBundle\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * @Route("/preference", name="preference")
     */
    public function preferenceAction(Request $request , UserManager $userManager)
    {
        $userInfo = new User();
        $formInfo = $this->createForm(UserChangeInfoType::class , $userInfo);
        $formInfo->handleRequest($request);
        
        $userPassword = new User();
        $formPassword = $this->createForm(UserChangePasswordType::class , $userPassword);
        $formPassword->handleRequest($request);
        
        $userSession = $this->getUser();
        
        if($formInfo->isValid())
        {
            if(password_verify($userSession->getPassword() , $userInfo->getPassword()))
            {
                $userManager->changeInfo($userSession , $userInfo->getEmail());
            }
        }
        if($formPassword->isValid())
        {
            if($formPassword->get('newPassword')->getData() == $formPassword->get('confirmNewPassword')->getData() AND 
                password_verify($userSession->getPassword() , $userPassword->getPassword()) == true)
            {
                $userManager->changePassword($userSession , $formPassword->get('newPassword')->getData());
            }
        }
        
        return $this->render('security/preference.html.twig' , array("formInfo" => $formInfo->createView() , "formPassword" => $formPassword->createView() ,
            "user" => $userSession));
    }

    /**
     * SearchUserAction
     *
     * @Route("/user/search", name="user_search", condition="request.isXmlHttpRequest()")
     */
    public function searchUserAction(Request $request){
        $word = $request->query->get('search');
        $users = $this->userManager->searchUser($word);
        $items = array();
        $response = new JsonResponse();
        foreach ($users as $user){
            $items[] = [
                'id' => $user->getId(),
                'pseudo' => $user->getPseudo()
            ];

        }
        return $response->setData(array('users'=>$items));
    }
}
