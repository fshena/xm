<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company as CompanyEntity;
use App\Form\CompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Company extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="company_index")
     *
     * @return Response
     */
    public function indexAction(): Response
    {
        $company = new CompanyEntity();
        $form = $this->createForm(CompanyType::class, $company, [
            'action' => $this->generateUrl('company_profile')
        ]);

        return $this->render('company/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/company", methods={"POST"}, name="company_profile")
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request): Response
    {
        $company = new CompanyEntity();
        $form    = $this->createForm(CompanyType::class, $company);

        if ($form->isSubmitted() && !$form->isValid()) {
            return $this->redirectToRoute('company_index');
        }

        return $this->render('company/profile.html.twig');
    }
}
