<?php

namespace App\TTLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class TTLController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function home(Request $request): Response
    {
        $route = $this->generateUrl(
            $request->attributes->get('_route')
        );

        return $this->render("@TTL/home.html.twig", [
            "route" => $route
        ]);
    }

    /**
     * @Route("/kernel", name="kernel")
     */
    public function kernel(Request $request): Response
    {
        $command = $request->request->get("command");
        $input_array = explode(' ', $command);
        
        $command = $input_array[0];
        $args = array_slice($input_array, 1);

        switch ($command)
        {
            case "probability":
                if (isset($args[0]) && "add" == $args[0])
                    return $this->redirectToRoute("probability_add", array_slice($args, 1));
                else if (isset($args[0]) && "multiply" == $args[0])
                    return $this->redirectToRoute("probability_multiply", array_slice($args, 1));
                else if (isset($args[0]) && "full" == $args[0])
                    return $this->redirectToRoute("probability_full", array_slice($args, 1));
                else if (isset($args[0]) && "single" == $args[0])
                    return $this->redirectToRoute("probability_single", array_slice($args, 1));
                else if (isset($args[0]) && "bayes" == $args[0])
                    return $this->redirectToRoute("probability_bayes", array_slice($args, 1));
        }

        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/help", name="help")
     * @return Response
     */
    public function help(): Response
    {
        return $this->render("@TTL/help.html.twig");
    }

    /**
     * @Route("/about", name="about")
     * @return Response
     */
    public function about(): Response
    {
        return $this->render("@TTL/about.html.twig");
    }
}