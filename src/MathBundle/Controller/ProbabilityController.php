<?php

namespace App\MathBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/math/probability")
 */
class ProbabilityController extends AbstractController
{
    /**
     * @Route("/add", name="probability_add")
     */
    public function add(Request $request): Response
    {
        $a = floatval($request->query->get('a'));
        $b = floatval($request->query->get('b'));
        $result = $a + $b;

        return $this->json("{$a} + {$b} = {$result}");
    }

    public function multiply()
    {

    }

    public function full()
    {

    }

    public function least()
    {

    }

    public function bayes()
    {

    }
}