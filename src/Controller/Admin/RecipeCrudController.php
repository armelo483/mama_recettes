<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\RecipePhotoType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }


    public function configureFields(string $pageName): iterable
    {

        $image = ImageField::new('image_url')
            ->setBasePath('uploads/images/recipes')
            ->setUploadDir('public/uploads/images/recipes')
            ->setUploadedFileNamePattern('[randomhash].[extension]');

        $fields = [
            TextField::new('title'),
            TextEditorField::new('description'),
            $image,
            CollectionField::new('recipePhotos')
                ->setEntryType(RecipePhotoType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms(),
            CollectionField::new('recipePhotos')
                ->setTemplatePath('recipe_photos.html.twig')
                ->onlyOnDetail()
        ];

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, 'detail');
    }

}
