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
    public function home(): Response
    {
        return $this->render("@TTL/home.html.twig", [
            "route" => "/"
        ]);
    }

    /**
     * @Route("/kernel", name="kernel")
     */
    public function kernel(Request $request): Response
    {
        $command = $request->request->get("command");
        
        switch ($command)
        {
            case "system":
                return $this->redirectToRoute("system");
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