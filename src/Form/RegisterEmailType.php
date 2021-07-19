<?php

namespace App\Form;

use App\Entity\CurrencyRate;
use App\Entity\UnconfirmedUser;
use App\Repository\CurrencyRateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterEmailType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currencies = $this->entityManager->getRepository(CurrencyRate::class)->findAll();
        $result = [];
        foreach ($currencies as $currency) {
            $result[] = $currency->getCurrency();    
        }


        $builder
            ->add('email')
            ->add('name')
            ->add('surname')
            ->add('phoneNumber')
            ->add('birthDate', BirthdayType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('currencies', ChoiceType::class, [
                'choices' => $result,
                'multiple' => true,
                'expanded' => true,
                'placeholder' => 'Dostępne tagi do dodania'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UnconfirmedUser::class,
        ]);
    }
}
