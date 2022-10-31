<?php

declare(strict_types=1);

namespace Doctrine\ORM\Mapping;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

/**
 * @Annotation
 * @NamedArgumentConstructor()
 * @Target("CLASS")
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class InheritanceType implements MappingAttribute
{
    /** @psalm-param 'NONE'|'JOINED'|'SINGLE_TABLE'|'TABLE_PER_CLASS' $value */
    public function __construct(
        public readonly string $value,
    ) {
    }
}
