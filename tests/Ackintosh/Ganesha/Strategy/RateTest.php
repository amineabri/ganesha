<?php
namespace Ackintosh\Ganesha\Strategy;

use Ackintosh\Ganesha\Storage\AdapterInterface;
use Ackintosh\Ganesha\Strategy\Rate;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Ackintosh\Ganesha\Strategy\Rate
 */
class RateTest extends TestCase
{
    /**
     * @test
     * @expectedException \LogicException
     */
    public function validateThrowsExceptionWhenTheRequiredParamsIsMissing()
    {
        Rate::validate([]);
    }

    /**
     * @test
     */
    public function validateThrowsExceptionWhenTheAdapterDoesntSupportCountStrategy()
    {
        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->expects(self::atLeastOnce())
            ->method('supportRateStrategy')
            ->willReturn(false);

        $params = [
            'adapter' => $adapter,
            'failureRateThreshold' => 10,
            'intervalToHalfOpen' => 10,
            'minimumRequests' => 10,
            'timeWindow' => 10,
        ];

        $this->expectException(\InvalidArgumentException::class);
        Rate::validate($params);
    }
}
