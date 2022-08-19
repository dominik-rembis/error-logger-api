<?php

declare(strict_types=1);

namespace User\Account\Infrastructure\Util\Orm\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Shared\Application\Exception\UnexpectedTypeException;
use User\Account\Domain\ObjectValue\Role;

final class RoleType extends Type
{
    public function getName(): string
    {
        return 'role';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string|false
    {
        if (!$value instanceof Role) {
            throw new UnexpectedTypeException($value, Role::class);
        }
        return $value->value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): Role
    {
        return Role::from($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}