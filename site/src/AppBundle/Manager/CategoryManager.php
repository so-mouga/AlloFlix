<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

class CategoryManager
{
    
    private $em;
    private $categoryRepository;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->categoryRepository = $entityManager->getRepository(Category::class);
    }
    
    
    public function findCategoriesByLabel($categoriesName)
    {
        
        $nameCategories = explode("," , $categoriesName);
        $listCategory = [];
        $i = 0;
        
        foreach($nameCategories as $nameCategory)
        {
            $category = $this->categoryRepository->findOneByLabel($nameCategory);
            
            if(empty($category))
            {
                $newCategory = new Category();
                $newCategory->setLabel($nameCategory);
                $this->em->persist($newCategory);
                $this->em->flush();
                
                $listCategory[$i] = $newCategory;
            }
            else
            {
                $listCategory[$i] = $category;
            }
            
            $i++;
        }
        
        if(!empty($listCategory))
        {
            return $listCategory;
        }
        
        
    }

    /**
     * @return array
     */
    public function getAllCategories() : array {
        return $this->em->getRepository(Category::class)
            ->findAll();
    }

    /**
     * @param int $id
     * @return Category
     */
    public function getCategoryById(int $id) : ?Category{
        return $this->em->getRepository(Category::class)
            ->findOneById($id);
    }
    /**
     * @param string $label
     * @return bool
     */
    public function addCategory(string $label) : bool{
        $category = new Category();
        $category->setLabel($label);

        $this->em->persist($category);
        $this->em->flush();
        return true;
    }

    /**
     * @param Request $request
     * @param Category $category
     */
    public function createCategory(Request $request, Category $category)
    {
        if (null != $request->request->get('appbundle_category')['id'])
        {
            $data = $request->request->get('appbundle_category');
            $category = $this->getCategoryById($data['id']);
            $category->setLabel($data['label']);
            $request->getSession()->getFlashBag()->add('info', 'well edited category.');
        }else {
            $this->em->persist($category);
            $request->getSession()->getFlashBag()->add('info', 'well recorded category.');
        }
        $this->em->flush();
    }

    /**
     * @param int $id
     */
    public function deleteCategory(int $id)
    {
        $category = $this->getCategoryById($id);

        if (null === $category) {
            throw new NotFoundHttpException("category d'id ".$id." n'existe pas.");
        }
        $this->em->remove($category);
        $this->em->flush();
    }
}

