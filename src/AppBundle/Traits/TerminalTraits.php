<?php

namespace App\AppBundle\Traits;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;

trait TerminalTraits
{
    private function get_current_route(Request $request): string
    {
        return $this->generateUrl($request->attributes->get('_route'));
    }
}