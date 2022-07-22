<?php

declare(strict_types=1);

namespace User\Data\UserInterface\Controller;

use Shared\Application\Proxy\MessageBus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;
use User\Data\Application\Model\Command\UserDataModel;

final class CreateAccount
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function __invoke(UserDataModel $userDataModel): Response
    {
        $this->commandBus->dispatch($userDataModel);

        return new Response('ok');
    }
}