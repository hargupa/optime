<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\ProductType;
use App\Controller\FunctionController;
use App\Entity\Product;
use Doctrine\ORM\EntityNotFoundException;
use http\Env\Response;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product")
     */
    public function index(Request $request,PaginatorInterface $paginator )
    {
        try {

            $query = null;
            $count_rows = 0;
            $message = '';
            $function = new FunctionController();
            $product = new Product();
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);
            $entityManager = $this->getDoctrine()->getManager();
            $query = $entityManager->getRepository(Product::class)->FindProduct();

            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                5 /*limit per page*/
            );

            if ($form->isSubmitted() && $form->isValid()) {
                /*validate if name_category and code_category don´t same*/
                $total_rows = $this->findProduct($form['code_product']->getData(), $form['name_product']->getData());
                $sn_character = $function->validateCharacter($form['code_product']->getData());
                $sn_name = $function->validateName($form['code_product']->getData(), 'Product');
                $sn_name1 = $function->validateName($form['name_product']->getData(), 'Product');


                if ($total_rows == 0) {
                    if ($sn_character == true) {
                        if ($sn_name == true && $sn_name1 == true) {
                            if (is_numeric($form['price']->getData())) {
                                $product->setCodeProduct($form['code_product']->getData());
                                $product->setNameProduct($form['name_product']->getData());
                                $product->setDescriptionProduct($form['description_product']->getData());
                                $product->setBrand($form['brand']->getData());
                                $product->setCategory($form['category']->getData());
                                $product->setPrice($form['price']->getData());
                                $entityManager->persist($product);
                                $entityManager->flush();
                                $message = product::MESSANGE_OK;
                            } else {
                                $message = product::MESSANGE_ERROR_PRICE;
                            }
                        } else {
                            $message = product::MESSANGE_ERROR_NAME;
                        }

                    } else {
                        $message = product::MESSANGE_ERROR_CHAR;
                    }
                } else {
                    $message = product::MESSANGE_ERROR;
                }
                $this->addFlash('msg', $message);
                return $this->redirectToRoute('product');

            }


            return $this->render('product/index.html.twig', [
                'controller_name' => 'Productos',
                'form' => $form->createView(),
                'pagination' => $pagination
            ]);
        }catch (EntityNotFoundException $e){
            echo "Exception Found - " . $e->getMessage() . "<br/>";
        }
    }
    public function findProduct($code,$name){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->getRepository(Product::class)->findBy(array('name_product' => $name));
        $count_rows= count($query);
        $query = $entityManager->getRepository(Product::class)->findBy(array('code_product' => $code));
        $count_rows = $count_rows + count($query);
        return $count_rows;
    }

    /**
     * @Route("/DeleteProd",options={"expose"=true},name="DeleteProd")
     */
    public function delete(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $query = $entityManager->getRepository(Product::class)->find($id);
        $entityManager->remove($query);
        $entityManager->flush();
        return new JsonResponse(['answer'=>Product::MESSANGE_DELETE]);
    }
    /**
     * @Route("/ModifyProd",options={"expose"=true},name="ModifyProd")
     */
    public function modify(Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $query = $entityManager->getRepository(Product::class)->find($id);
        return new JsonResponse(['name'=>$query->getNameProduct(),'code'=>$query->getCodeProduct(),'description'=>$query->getDescriptionProduct(),'brand'=>$query->getBrand(),'price'=>$query->getPrice(),'category'=>$query->getCategory()]);
    }
    /**
     * @Route("/SaveModifyProd",options={"expose"=true},name="SaveModifyProd")
     */
    public function SaveModify(Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $query = $entityManager->getRepository(Product::class)->find($id);
        $query->setCodeProduct($request->request->get('code'));
        $query->setNameProduct($request->request->get('name'));
        $query->setDescriptionProduct($request->request->get('description'));
        $query->setBrand($request->request->get('brand'));
        $query->setPrice($request->request->get('price'));
        $entityManager->flush();
        return new JsonResponse(['answer'=>Product::MESSANGE_UPDATE]);
    }



}
