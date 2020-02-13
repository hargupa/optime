<?php

namespace App\Controller;
use App\Controller\FunctionController;
use App\Entity\Category;
use App\Form\CategoryType;
use http\Env\Response;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request,PaginatorInterface $paginator)
    {
        $query=null;
        $count_rows=0;
        $message='';
        $function = new FunctionController();
        $category = new Category();
        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->getRepository(Category::class)->FindCategory();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );


        if($form->isSubmitted() && $form->isValid()){
            /*validate if name_category and code_category don´t same*/
            $total_rows=$this->findCategory($form['code_category']->getData(),$form['name_category']->getData());
            $sn_character = $function->validateCharacter($form['code_category']->getData());
            $sn_name = $function->validateName($form['name_category']->getData(),'Category');
            if($total_rows==0){
                if ($sn_character==true){
                    if ($sn_name==true){
                        $category->setCodeCategory($form['code_category']->getData());
                        $category->setNameCategory($form['name_category']->getData());
                        $category->setDescriptionCategory($form['description_category']->getData());
                        $category->setActive($form['active']->getData());
                        $entityManager->persist($category);
                        $entityManager->flush();
                        $message=category::MESSANGE_OK;
                    }else{
                        $message=category::MESSANGE_ERROR_NAME;
                    }

                }else{
                    $message=category::MESSANGE_ERROR_CHAR;
                }
            }else{
                $message=category::MESSANGE_ERROR;
            }
            $this->addFlash('msg',$message);
            return $this->redirectToRoute('category');
            //return $this->render('category/index.html.twig', [ 'controller_name' => 'Categorias','form'=>$form->createView(),'query' =>$count_reg ]);
        }


        return $this->render('category/index.html.twig', [
            'controller_name' => 'Categorias',
            'form'=>$form->createView(),
            'pagination' => $pagination
        ]);
    }
    public function findCategory($code,$name){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->getRepository(Category::class)->findBy(array('name_category' => $name));
        $count_rows= count($query);
        $query = $entityManager->getRepository(Category::class)->findBy(array('code_category' => $code));
        $count_rows = $count_rows + count($query);
        return $count_rows;
    }

    /**
     * @Route("/Delete",options={"expose"=true},name="Delete")
     */
    public function delete(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $query = $entityManager->getRepository(Category::class)->find($id);
        $entityManager->remove($query);
        $entityManager->flush();
        return new JsonResponse(['answer'=>Category::MESSANGE_DELETE]);
    }
    /**
     * @Route("/Modify",options={"expose"=true},name="Modify")
     */
    public function modify(Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $query = $entityManager->getRepository(Category::class)->find($id);
        //$entityManager = $this->getDoctrine()->getManager();
        //$entityManager->remove($query);
        //$entityManager->flush();
        return new JsonResponse(['name'=>$query->getNameCategory(),'code'=>$query->getCodeCategory(),'description'=>$query->getDescriptionCategory(),'active'=>$query->getActive()]);
    }

    /**
     * @Route("/SaveModify",options={"expose"=true},name="SaveModify")
     */
    public function SaveModify(Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $query = $entityManager->getRepository(Category::class)->find($id);
        $query->setCodeCategory($request->request->get('code'));
        $query->setNameCategory($request->request->get('name'));
        $query->setDescriptionCategory($request->request->get('description'));
        $query->setActive($request->request->get('active'));
        $entityManager->flush();
        return new JsonResponse(['answer'=>Category::MESSANGE_UPDATE]);
    }



}
