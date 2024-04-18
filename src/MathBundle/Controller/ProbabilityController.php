<?php

namespace App\MathBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\AppBundle\Traits\TerminalTraits;

// Mess, I know, don't blame

/**
 * @Route("/math/probability")
 */
class ProbabilityController extends AbstractController
{
    use TerminalTraits;

    /**
     * @Route("/add", name="probability_add")
     */
    public function add(Request $request): Response
    {   
        $args = $request->query->all();
        $result = array_reduce($args, function($carry, $item) {
            $item = floatval($item);
            return $carry + $item - ($carry * $item);
        }, 0);

        return $this->render("@Math/probability.html.twig", [
            "route" => $this->get_current_route($request),
            "operation_name" => __FUNCTION__,
            "arguments" => implode(" ", $args),
            "result" => $result
        ]);
    }

    /**
     * @Route("/multiply", name="probability_multiply")
     */
    public function multiply(Request $request): Response
    {
        $args = $request->query->all();
        $result = array_reduce($args, function($carry, $item) {
            $item = floatval($item);
            return ($carry * $item);
        }, 1);

        return $this->render("@Math/probability.html.twig", [
            "route" => $this->get_current_route($request),
            "operation_name" => __FUNCTION__,
            "arguments" => implode(" ", $args),
            "result" => $result
        ]);
    }

    /**
     * @Route("/full", name="probability_full")
     */
    public function full(Request $request): Response
    {
        $args = $request->query->all();
        $split_by = array_search("and", $args);

        $conditional_probabilities = array_slice($args, 0, $split_by);
        $prior_probabilities = array_slice($args, $split_by + 1);

        $result = 0;
        $length = count($conditional_probabilities);
        
        for($i = 0; $i < $length; $i++)
            $result += $conditional_probabilities[$i] * $prior_probabilities[$i];
        
        return $this->render("@Math/probability.html.twig", [
            "route" => $this->get_current_route($request),
            "operation_name" => __FUNCTION__,
            "arguments" => implode(" ", $args),
            "result" => $result
        ]);
    }

    /**
     * @Route("/single", name="probability_single")
     */
    public function single(Request $request): Response
    {
        $args = $request->query->all();

        $complementary_probability = 1;
        foreach ($args as $p)
        {
            $p = floatval($p);
            $complementary_probability *= (1 - $p);
        }

        $result = 1 - $complementary_probability;

        return $this->render("@Math/probability.html.twig", [
            "route" => $this->get_current_route($request),
            "operation_name" => __FUNCTION__,
            "arguments" => implode(" ", $args),
            "result" => $result
        ]);
    }

    /**
     * @Route("/bayes", name="probability_bayes")
     */
    public function bayes(Request $request): Response
    {
        $args = $request->query->all();
        $args = array_map('floatval', $args);

        $result = $args[0] * $args[2] / $args[1];

        return $this->render("@Math/probability.html.twig", [
            "route" => $this->get_current_route($request),
            "operation_name" => __FUNCTION__,
            "arguments" => implode(" ", $args),
            "result" => $result
        ]);
    }
}