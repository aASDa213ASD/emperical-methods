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
        $command = explode(' ', $command);

        //dd($command);
        
        //dd(urlencode($command[2]));

        switch ($command[0])
        {
            case "probability":
                if (isset($command[1]) && "add" == $command[1])
                    return $this->redirectToRoute("probability_add", [ "a" => urlencode($command[2]), "b" => urlencode($command[3]) ]);
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