<?php
namespace Controller;

use Exception\ServiceException;
use http\Response;
use Service\CategoryService;

class CategoryController extends AbstractAjaxController
{
    public function regCategory()
    {
        $validationRules = [
            'cat_name' => 'post:cat_name@required@alpha',
            'cat_type' => 'post:cat_type@required',
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $categoryService = new CategoryService();
            $result = $categoryService->registerCategory($validData);
            $this->responseCode = $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $result = false;
        }

        $arr['response'] = $result;

        $this->response(
            $this->getResponseCode(),
            $arr
        );
    }

    public function allUserCategories()
    {
        $categoryService = new CategoryService();
        $result = $categoryService->getAllCategories();
        $this->responseCode = $categoryService->getSuccessCheck() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        if (!$result) {
            $result = false;
        }
        $this->response(
            $this->getResponseCode(),
            $result
        );
    }
}
