<?php

namespace App\Controller\Prototype;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Description of BaseController
 */
class BaseController extends AbstractController
{
    /**/
    public function renderer($viewPath, $viewData)
    {
        $data = array_merge(
            $viewData,
            []
        );
        //$this->render($view, $parameters, $response)
        return $this->render($viewPath, $data);
    }
}
