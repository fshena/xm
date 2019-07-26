<?php declare(strict_types=1);

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companySymbol')
            ->add('fromDate', DateType::class, [
                'widget' => 'single_text',
                'years' => range(date('Y') - 50, date('Y')),
                'attr' => [
                    'id' => 'fromDate'
                ]
            ])
            ->add('toDate', DateType::class, [
                'widget' => 'single_text',
                'years' => range(date('Y') - 50, date('Y')),
                'attr' => [
                    'id' => 'toDate'
                ]
            ])
            ->add('email')
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
