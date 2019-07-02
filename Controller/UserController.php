<?php
namespace Controller;

use http\SessionHandler;
use Interfaces\Editable;
use Repository\UserRepository;
use Router\Url;
use Service\UserService;
use Support\Manager\CustomerManager;

class UserController extends AbstractController implements Editable
{
    public function before()
    {
    }

    public function userRegistration()
    {
        $validationRules = [
            'first_name' => 'required@alpha@post:first_name',
            'last_name' => 'required@alpha@post:last_name',
            'email' => 'required@email@post:email',
            'age' => 'required@min:18@post:age',
            'password_1' => 'required@same:password_2@regex:#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#@post:password_1',
            'password_2' => 'required@post:password_2',
            'register' => 'required'
        ];
        $validation = $this->doValidate($validationRules);
        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $userService = new UserService();
            $response = $userService->registerUser($validData);
            if ($response) {
                header("Location:". Url::generateUrl('indexPage'));
            }
        } else {
            $arr["response"] = false;
        }
    }

    public function userLogin()
    {
        $validationRules = [
            'email' => 'required@email@post:email',
            'pass' => 'required@post:pass'
        ];
        $result['response'] = 'fail';
        $validation = $this->doValidate($validationRules);
        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $userService = new UserService();
            $response = $userService->userLogin($validData);
            if ($response) {
                $result["response"] = "success";
            }
        }

        echo json_encode($result);
    }

    public function userData()
    {
        $userRepository = new UserRepository();
        echo json_encode($userRepository->getInfoById(CustomerManager::getUserId()));
    }

    public function userLogout()
    {
        CustomerManager::unsetUserSession();
        $arr = [];
        $arr["message"] = "true";
        echo json_encode($arr);
    }

    public function edit()
    {
        $validationRules = [
            'first_name' => 'required@alpha@post:first_name',
            'last_name' => 'required@alpha@post:last_name',
            'email' => 'required@email@post:email',
            'age' => 'required@min:18@post:age',
            'user_id' => 'required'
        ];
        $validation = $this->doValidate($validationRules);
        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $userService = new UserService();
            $response = $userService->edit($validData);
            if ($response) {
                header("Location:". Url::generateUrl('indexPage'));
            }
        } else {
            $arr["response"] = false;
        }
    }

    public function checkUserExists()
    {
        $validationRules = [
            'email' => 'required@email@post:email'
        ];
        $validation = $this->doValidate($validationRules);
        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $userService = new UserService();
            $response = $userService->checkUserExists($validData);
            $arr["message"] = $response;
        } else {
            $arr["message"] = false;
        }

        echo json_encode($arr);
    }
}
