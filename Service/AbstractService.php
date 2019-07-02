<?php
namespace Service;

abstract class AbstractService
{
    protected $successCheck = true;

    public function getSuccessCheck()
    {
        return $this->successCheck;
    }

    public function setSuccessCheck($successCheck)
    {
        $this->successCheck = $successCheck;
    }


}
