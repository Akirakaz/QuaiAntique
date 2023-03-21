<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Validation;

#[AsCommand(
    name       : 'app:createadmin',
    description: 'This commande create admin user',
)]
class CreateadminCommand extends Command
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface      $manager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager, string $name = null)
    {
        $this->passwordHasher = $passwordHasher;
        $this->manager        = $manager;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, "Email de l'administrateur")
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $inputEmail    = $input->getArgument('email');
        $inputPassword = $input->getArgument('password');

        $validator      = Validation::createValidator();
        $constraints    = [];
        $violationCount = 0;

        $registeredAdmin = $this->manager->getRepository(User::class)->findBy(['email' => $inputEmail]);

        if ($registeredAdmin) {
            $io->warning('Le compte ' . $inputEmail . ' existe déjà !');
            return Command::FAILURE;
        }

        $constraints[] = $validator->validate($inputEmail, [
            new Email([
                'message' => "\"$inputEmail\" n'est pas une adresse valide.",
            ]),
        ]);

        $constraints[] = $validator->validate($inputPassword, [
            new Length([
                'min'        => 8,
                'minMessage' => "Le mot de passe doit contenir au moins 8 caractères.",
            ]),
        ]);

        foreach ($constraints as $violations) {
            if (0 !== count($violations)) {
                foreach ($violations as $violation) {
                    $io->warning($violation->getMessage());
                    $violationCount++;
                }
            }
        }

        if (0 !== $violationCount) {
            return Command::FAILURE;
        }

        $user = new User();
        $user
            ->setEmail($inputEmail)
            ->setPassword($this->passwordHasher->hashPassword($user, $inputPassword))
            ->setRoles(['ROLE_ADMIN']);

        $this->manager->persist($user);
        $this->manager->flush();

        $io->success('Le compte ' . $inputEmail . ' à bien été crée !');

        return Command::SUCCESS;
    }
}
