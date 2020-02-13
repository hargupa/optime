<?php

namespace App\Controller;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FunctionController extends AbstractController
{
    /**
     * @Route("/function", name="function")
     */
    public function index()
    {
        return $this->render('function/index.html.twig', [
            'controller_name' => 'FunctionController',
        ]);
    }


    public function validateCharacter($code){
        $character_ok = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for ($i=0; $i<strlen($code); $i++){
            if (strpos($character_ok, substr($code,$i,1))===false){
                return false;
            }
            if (substr($code,$i,1)==' '){
                return false;
            }
        }
        return true;
    }
    public function validateName($name,$entity){
        if($entity=='Product'){
            if (strlen($name)<=3 ||strlen($name)>10){
                return false;
            }
            return true;
        }else{
            if (strlen($name)<=1){
                return false;
            }
            return true;
        }

    }
}
