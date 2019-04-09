<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Users;
use App\Entity\Groups;
use App\Repository\UsersRepository;


class GroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // For the full reference of options defined by each form field type
        // see https://symfony.com/doc/current/reference/forms/types.html

        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        // $builder->add('title', null, ['required' => false, ...]);

        $builder
            ->add('name', null, [
                'attr' => ['autofocus' => true, 'class' => 'form-control'],
                'label' => 'Group Name',
            ])
            ->add('users', EntityType::class, array(
                'label' => 'Group Users',
                'class' => Users::class,
                'query_builder' => function (UsersRepository $er) {
                    return $er->getItems(array('roleSlug' => 'ROLE_GROUP_USER', 'return' => 'queryObject'));
                },
                'choice_label' => function(Users $user) {
                    return sprintf('%s - %s', $user->getName(), $user->getEmail());
                },
                'multiple' => true,
                'required' => false,
                'mapped' => true,
                'by_reference' => true
             ))
             ->add('save', SubmitType::class, ['label' => 'Save Task', 'attr' => ['class' => 'btn btn-primary'] ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groups::class,
        ]);
    }
}
