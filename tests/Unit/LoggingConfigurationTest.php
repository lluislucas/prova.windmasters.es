<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoggingConfigurationTest extends TestCase
{
    public function test_stack_channel_does_not_ignore_exceptions_by_default(): void
    {
        $this->assertFalse(config('logging.channels.stack.ignore_exceptions'));
    }

    public function test_daily_channel_keeps_a_bounded_number_of_files(): void
    {
        $this->assertSame(14, (int) config('logging.channels.daily.max_files'));
    }
}
