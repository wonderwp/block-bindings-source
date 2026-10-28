<?php

declare(strict_types=1);

namespace WonderWp\Component\BlockBindingsSource\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WonderWp\Component\BlockBindingsSource\Exception\BlockBindingsSourceRegistrationException;

final class BlockBindingsSourceRegistrationExceptionTest extends TestCase
{
    public function testExceptionCarriesMessage(): void
    {
        $ex = new BlockBindingsSourceRegistrationException('register failed');
        $this->assertSame('register failed', $ex->getMessage());
    }
}
