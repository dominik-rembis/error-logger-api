<?php

declare(strict_types=1);

namespace Project\Application\Application\Action\Command;

use Project\Application\Application\Model\Command\ApplicationData;
use Project\Application\Domain\Entity\Application;
use Shared\Domain\Repository\PersistenceInterface;
use Shared\Infrastructure\Proxy\Test\BaseTestCase;

final class ApplicationCreatorTest extends BaseTestCase
{
    private PersistenceInterface $persistence;

    protected function setUp(): void
    {
        parent::setUp();

        $this->persistence = self::createMock(PersistenceInterface::class);
    }

    public function testCaseOfCreatingNewApplication(): void
    {
        $this->persistence
            ->expects($this->once())
            ->method('save')
            ->with(self::callback(fn(object $object): bool => $object instanceof Application));

        $handler = new ApplicationCreator($this->persistence);
        $handler->__invoke(self::getApplicationDataMock());
    }

    private static function getApplicationDataMock(): ApplicationData
    {
        return new ApplicationData(
            'exampleName',
            'b4a018b2-0b31-4212-8376-3a9acca45495'
        );
    }
}