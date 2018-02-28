<?php 

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Category;

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
        
        foreach($nameCategories as $nameCategory)
        {
            $i = 0;
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
    
    
}


?>