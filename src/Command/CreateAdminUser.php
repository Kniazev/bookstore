<?php

namespace App\Command;

use App\Entity\User;
use App\Service\UserServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminUser extends Command
{
    protected static $defaultName = 'app:create-admin-user';
    protected UserPasswordHasherInterface $hasher;
    protected UserServiceInterface $userService;

    /**
     * @param UserPasswordHasherInterface $hasher
     * @param UserServiceInterface $userService
     */
    public function __construct(UserPasswordHasherInterface $hasher, UserServiceInterface $userService)
    {
        $this->hasher = $hasher;
        $this->userService = $userService;

        parent::__construct();
    }


    protected function configure()
    {
        $this->addArgument('email', InputArgument::REQUIRED, 'email is required.');
        $this->addArgument('password', InputArgument::REQUIRED, 'password is required.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $admin = new User();

        $admin->setTelephoneNumber('14158586273');
        $admin->setAddress('address');
        $admin->setFristName('admin');
        $admin->setLastName('admin');
        $admin->setEmail($input->getArgument('email'));
        $admin->setRoles([User::ADMIN_ROLE]);
        $admin->setPassword($this->hasher->hashPassword($admin, $input->getArgument('password')));

        $this->userService->create($admin);

        $output->writeln('Admin was created.');
        $output->write($admin->getEmail());

        return Command::SUCCESS;
    }
}