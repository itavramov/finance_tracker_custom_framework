<?php
namespace Repository;

use Model\User;

class UserRepository extends AbstractRepository {

    public function addUser(User $user)
    {
        $firstName = $user->getFirstName();
        $lastName  = $user->getLastName();
        $age = $user->getAge();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $picture = $user->getImgUrl();
        $sql = "
            INSERT INTO
                users (
                    first_name, 
                    last_name, 
                    email,
                    age,
                    password,
                    picture,
                    sign_up_date
                    )
            VALUES
                (
                    :first_name,
                    :last_name,
                    :email,
                    :age,
                    :password,
                    :picture,
                    curdate()
                )
        ";
        $bindParams = [
          "first_name" => $firstName,
          "last_name" => $lastName ,
          "email" => $email,
          "age" => $age,
          "password" => $password,
          "picture" => $picture,
        ];
        $this->execute($sql, $bindParams);
        $user->setId($this->lastInsertedId());

        if($this->getEffectedRows() === 0){
            return false;
        }
        return true;
    }

    public function getIdByEmail($email)
    {
        $sql = "
            SELECT
                user_id
            FROM
                users
            WHERE
             email = :email
        ";
        $bindParams = [
          "email" => $email
        ];
        $row = $this->fetchAssocSingleRow($sql, $bindParams);

        if($this->getEffectedRows() === 0){
            return false;
        }
        return $row["user_id"];
    }

    public function getPassByEmail($email)
    {
        $sql = "
            SELECT
                password
            FROM
                users
            WHERE
                email = :email
        ";
        $bindParams = [
            "email" => $email
        ];

        $row = $this->fetchAssocSingleRow($sql, $bindParams);
        if(empty($row)){
            return null;
        }
        else{
            return $row["password"];
        }
    }

    public function getInfoById($id)
    {
        $sql = "
            SELECT
                user_id,
                first_name,
                last_name,
                email,
                picture,
                age,
                sign_up_date
            FROM
                users 
            WHERE
                user_id = :user_id
        ";
        $bindParams = [
            "user_id" => $id
        ];

        $row = $this->fetchAssocSingleRow($sql,$bindParams);
        if(empty($row)){
            return null;
        }
        else{
            return $row;
        }
    }

    public function getPassById($id)
    {
        $sql = "
            SELECT
                password
            FROM 
                users
            WHERE
                user_id = :user_id
        ";
        $bindParams = [
            "user_id" => $id
        ];

        $row = $this->fetchAssocSingleRow($sql, $bindParams);
        if(empty($row)){
            return null;
        }
        else{
            return $row["password"];
        }
    }

    public function updateUser(User $user, $userId)
    {
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $age = $user->getAge();
        $email = $user->getEmail();
        $picture = $user->getImgUrl();
        $sql = "
            UPDATE
                users
            SET 
                first_name = :first_name,
                last_name = :last_name,
                age = :age,
                email = :email,
                picture = :picture
            WHERE
                user_id = :user_id
        ";
        $bindParams = [
            "first_name" => $firstName,
            "last_name" => $lastName,
            "age" => $age,
            "email" => $email,
            "picture" => $picture,
            "user_id" => $userId
        ];
        $this->execute($sql , $bindParams);
        if ($this->getEffectedRows() === 0){
            return false;
        }
        return true;
    }
}
