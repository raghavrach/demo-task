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
        // Create form fields
		$builder
            ->add('name', null, [
                'attr' => ['autofocus' => true, 'class' => 'form-control'],
                'label' => 'Group Name',
            ])
            ->add('users', EntityType::class, array(
                'label' => 'Group Users',
                'class' => Users::class,
                'query_builder' => function (UsersRepository $er) {
					// Fetch only users with Group User role
                    return $er->getItems(array('roleSlug' => 'ROLE_GROUP_USER', 'return' => 'queryObject'));
                },
                'choice_label' => function(Users $user) {
					// Option label
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
    /*
	 * Link the form fields to Entity class
	 *
	 * @params $resolver
	 * @return none
	 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groups::class,
        ]);
    }
}
