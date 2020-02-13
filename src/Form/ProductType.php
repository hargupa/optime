<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code_product',TextType::class,['label'=>'Codigo Producto'])
            ->add('name_product',TextType::class,['label'=>'Nombre Producto'])
            ->add('description_product',TextType::class,['label'=>'Descripcion Producto'])
            ->add('brand',TextType::class,['label'=>'Marca'])
            ->add('price',IntegerType::class,['label'=>'Precio'])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.active=1')
                        ->orderBy('c.name_category', 'ASC');
                },
                'choice_label' => 'name_category',

            ],['label'=>'Categoria'])
            ->add('Grabar',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
