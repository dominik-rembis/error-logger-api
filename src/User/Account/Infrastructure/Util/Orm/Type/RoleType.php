<?php

declare(strict_types=1);

namespace User\Account\Infrastructure\Util\Orm\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use User\Account\Domain\ObjectValue\Role;

final class RoleType extends Type
{
    public function getName(): string
    {
        return 'json_role';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string|false
    {
        return json_encode(
            array_map(fn(Role $role): string => $role->value, $value)
        );
    }

    /** @return Role[] */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): array
    {
        return array_map(
          fn(string $role): Role => Role::tryFrom($role),
          json_decode($value, true)
        );
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}