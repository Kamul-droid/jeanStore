<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LangChangeController extends AbstractController
{
    /**
     * @Route("/langchange/{locale}", name="langchange")
     */
    public function langChange($locale, Request $request)
    {
         // On stocke la langue dans la session
            $request->getSession()->set('_locale', $locale);

            // On revient sur la page précédente
            return $this->redirect($request->headers->get('referer'));
    }
}
