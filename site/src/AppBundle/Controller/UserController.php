<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 26/02/2018
 * Time: 16:51
 */

namespace AppBundle\Controller;

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
    public function preferenceAction()
    {
        return $this->render('security/preference.html.twig');
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
