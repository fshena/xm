<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company as CompanyEntity;
use App\Form\CompanyType;
use App\Service\CompanySymbol;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Company extends AbstractController
{
    /**
     * @Route("/", methods={"GET","POST"}, name="company_index")
     * @param Request       $request
     * @param CompanySymbol $companySymbol $
     *
     * @return Response
     */
    public function indexAction(Request $request, CompanySymbol $companySymbol, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(CompanyType::class, new CompanyEntity(), [
            'action' => $this->generateUrl('company_index'),
        ]);

        $data = ['form' => $form->createView()];

        $form->handleRequest($request);

        // if error pass them to the view
        if ($form->isSubmitted() && ! $form->isValid()) {
            $data['validationErrors'] = $form->getErrors(true);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // get submitted data
            $symbol   = mb_strtoupper($form->getData()->getCompanySymbol());
            $fromDate = $form->getData()->getFromDate()->format('Y-m-d');
            $toDate   = $form->getData()->getToDate()->format('Y-m-d');
            $email    = $form->getData()->getEmail();

            // get data from API
            $results = $companySymbol->getDataForSymbol($symbol, $fromDate, $toDate);
            $data    = array_merge($data, $results);

            // send email
            $message = (new \Swift_Message($symbol))
                ->setFrom('send@example.com')
                ->setTo($email)
                ->setBody("From {$fromDate} to {$toDate}", 'text/html');

            $mailer->send($message);
        }

        return $this->render('company/index.html.twig', $data);
    }
}
