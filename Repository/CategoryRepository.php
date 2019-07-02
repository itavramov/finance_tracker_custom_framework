<?php
namespace Repository;

use Model\Category;

class CategoryRepository extends AbstractRepository
{
    public function addCategory(Category $category)
    {
        $name = $category->getCategoryName();
        $type = $category->getCategoryType();
        $userId = $category->getUserId();
        $sql = "
            INSERT INTO
                categories(
                    category_name, 
                    category_type,
                    user_id
                )
            VALUES(
                :category_name,
                :category_type,
                :user_id
            )
        ";
        $bindParams = [
            "category_name" => $name,
            "category_type" => $type,
            "user_id" => $userId
        ];
        $this->execute($sql,$bindParams);
        if($this->lastInsertedId() === 0){
            return false;
        }
        return true;
    }

    public function getAllCategoriesByUser($userId)
    {
        try{
            $sql = "
                SELECT
                    category_id,
                    category_name,
                    category_type 
                FROM
                    categories 
                WHERE
                    user_id = :user_id OR user_id IS NULL 
            ";
            $bindParams = [
              "user_id" => $userId
            ];
            $categories = [];
            $categories = $this->fetchAssoc($sql, $bindParams);
        }
        catch (\PDOException $exception){
            echo 'Problem with db categories ->' . $exception->getMessage();
        }
        return $categories;
    }

    public function getCategoryType($categoryId)
    {
        $sql = "
                SELECT
                    category_type
                FROM
                    categories
                WHERE
                    category_id = :category_id
            ";
        $bindParams = [
            'category_id' => $categoryId
        ];

        $result = $this->fetchAssocSingleRow($sql, $bindParams);

        if($this->getEffectedRows() > 0){
            return $result;
        }

        return false;
    }
}
