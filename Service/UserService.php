<?php
namespace Service;

use http\SessionHandler;
use Support\Manager\CustomerManager;
use Model\User;
use Repository\UserRepository;

class UserService
{
    public function registerUser(array $validData)
    {
        $userRepository = new UserRepository();
        $userImage = $_FILES["user_image"]["tmp_name"];
        $imageUrl = "uploads/user_image/noPicture.png";

        if(move_uploaded_file($userImage, "view/uploads/user_image/". $validData["first_name"].time() . ".jpg")){
            $imageUrl = "uploads/user_image/". $validData["first_name"].time() . ".jpg";
        }
        $user = new User(
            $validData["first_name"],
            $validData["last_name"],
            $validData["email"],
            $validData["age"],
            password_hash($validData["password_1"], PASSWORD_BCRYPT, ['cost'=>12]),
            $imageUrl
        );
        $response = $userRepository->addUser($user);

        $session = SessionHandler::getInstance();
        $session->setSessionValue(
            'logged',
            true
        );
        $session->setSessionValue(
            'email',
            $validData["email"]
        );
        $session->setSessionValue(
            'user_id',
            $userRepository->getIdByEmail($validData["email"])
        );

        $_SESSION["logged"] = true;
        $_SESSION["email"] = $validData["email"];
        $_SESSION["user_id"] = $userRepository->getIdByEmail($validData["email"]);

        return $response;
    }

    public function userLogin(array $validData)
    {
        $userRepository = new UserRepository();
        $db_pass = $userRepository->getPassByEmail($validData['email']);
        $response = true;
        if (password_verify($validData['pass'], $db_pass)) {
            $userData = [
                'email' => $validData["email"],
                'user_id' => $userRepository->getIdByEmail($validData['email'])
            ];
            CustomerManager::setUserData($userData);
//            $session = SessionHandler::getInstance();
//            $session->setSessionValue(
//                'logged',
//                true
//            );
//            $session->setSessionValue(
//                'email',
//                $validData["email"]
//            );
//            $session->setSessionValue(
//                'user_id',
//                $userRepository->getIdByEmail($validData["email"])
//            );
//            $_SESSION["logged"] = true;
//            $_SESSION["email"] = $validData['email'];
//            $_SESSION["user_id"] = $userRepository->getIdByEmail($validData['email']);
        } else {
            $response = false;
        }
        return $response;
    }

    public function edit(array $validData)
    {
        $userId = $validData['user_id'];
        $userRepository = new UserRepository();
        $imageUrl = $_FILES["user_image"]["tmp_name"];

        if (empty($_FILES["user_image"]["tmp_name"])) {
            $arr = $userRepository->getInfoById($userId);
            $imageUrl = $arr["picture"];
        } else {
            if (move_uploaded_file($imageUrl, "view/uploads/user_image/". $validData['first_name'].time() . ".jpg")) {
                $imageUrl = "uploads/user_image/". $validData['first_name'] .time() . ".jpg";
            }
        }

        $pass = $userRepository->getPassById($userId);
        $user = new User(
            $validData["first_name"],
            $validData["last_name"],
            $validData["email"],
            $validData["age"],
            $pass,
            $imageUrl
        );
        $response = $userRepository->updateUser(
            $user,
            $userId
        );

        return $response;
    }

    public function checkUserExists(array $validData)
    {
        $userRepository = new UserRepository();
        $response = $userRepository->getIdByEmail($validData['email']);

        return $response;
    }
}