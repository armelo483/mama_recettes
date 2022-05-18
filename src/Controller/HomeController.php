<?php
namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    /**
     * @var EntityManager
     */
    private $em;


    public function __construct(Environment $twig, RecipeRepository $recipeRepository, EntityManagerInterface $em)
    {
        $this->twig = $twig;
        $this->recipeRepository = $recipeRepository;
        $this->em = $em;
    }

    /**
     * Page d'accueil
     * 
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('pages/home.html.twig');
    }


    /**
     * Page liste recettes
     *
     * @Route("/recipes", name="recipes")
     */
    public function recipes(PaginatorInterface $paginator, Request $request)
    {
        //$recipes = $this->recipeRepository->findAllQuery();
        $recipes = $paginator->paginate(
            $this->recipeRepository->findAllQuery(),
            $request->query->getInt('page', 1), 12);

        return $this->render('pages/all_recipes.html.twig', [
            'recipes' => $recipes
        ]);
    }

    /**
     * Page de détail d'une recette
     *
     * @Route("/recipe/{slug}-{id}", name="recipe.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Recipe $recipe
     * @return Response
     */
    public function show(Recipe $recipe, string $slug)
    {
        if ($recipe->getSlug() !== $slug) {
            $this->redirectToRoute('recipe.show', [
                'id' => $recipe->getId(),
                'slug' => $recipe->getSlug()
            ], 301);
        }

        return $this->render('pages/show.html.twig', [
            'recipe' => $recipe
        ]);
    }
}
