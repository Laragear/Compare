<?php

namespace Tests;

use Error;
use Laragear\Compare\Comparable;
use PHPUnit\Framework\TestCase;

class ComparisonTest extends TestCase
{
    /** @var \Laragear\Compare\Comparable&object */
    protected object $comparable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->comparable = new class {
            public array $compare = [
                'bool' => true,
                'number' => 10,
                'float' => 20.0,
                'negative' => ['number' => -4, 'float' => -4.5],
                'nested' => [
                    'items' => [
                        'foo', 'bar', 'baz', 'quz'
                    ]
                ],
                'string' => 'foo bar baz',
                'blank' => '',
                'empty' => [],
                'zeroes' => ['0', 0, 0.0],
                'false' => false,
                'null' => null
            ];

            use Comparable;
        };
    }

    public function test_dynamic_inverse(): void
    {
        static::assertTrue($this->comparable->is('invalid')->blank());
        static::assertFalse($this->comparable->is('invalid')->not->blank());
    }

    public function test_blank(): void
    {
        static::assertTrue($this->comparable->is('invalid')->blank());
        static::assertFalse($this->comparable->is('invalid')->not()->blank());

        static::assertTrue($this->comparable->is('compare.blank')->blank());
        static::assertFalse($this->comparable->is('compare.blank')->not()->blank());

        static::assertFalse($this->comparable->is('compare.string')->blank());
        static::assertTrue($this->comparable->is('compare.string')->not()->blank());

        static::assertTrue($this->comparable->is('invalid')->blank);
        static::assertFalse($this->comparable->is('invalid')->not()->blank);

        static::assertTrue($this->comparable->is('compare.blank')->blank);
        static::assertFalse($this->comparable->is('compare.blank')->not()->blank);

        static::assertFalse($this->comparable->is('compare.string')->blank);
        static::assertTrue($this->comparable->is('compare.string')->not()->blank);
    }

    public function test_filled(): void
    {
        static::assertFalse($this->comparable->is('invalid')->filled());
        static::assertTrue($this->comparable->is('invalid')->not()->filled());

        static::assertFalse($this->comparable->is('compare.blank')->filled());
        static::assertTrue($this->comparable->is('compare.blank')->not()->filled());

        static::assertTrue($this->comparable->is('compare.string')->filled());
        static::assertFalse($this->comparable->is('compare.string')->not()->filled());

        static::assertFalse($this->comparable->is('invalid')->filled);
        static::assertTrue($this->comparable->is('invalid')->not()->filled);

        static::assertFalse($this->comparable->is('compare.blank')->filled);
        static::assertTrue($this->comparable->is('compare.blank')->not()->filled);

        static::assertTrue($this->comparable->is('compare.string')->filled);
        static::assertFalse($this->comparable->is('compare.string')->not()->filled);
    }

    public function test_true(): void
    {
        static::assertFalse($this->comparable->is('invalid')->true());
        static::assertTrue($this->comparable->is('invalid')->not()->true());

        static::assertTrue($this->comparable->is('compare.bool')->true());
        static::assertFalse($this->comparable->is('compare.bool')->not()->true());

        static::assertFalse($this->comparable->is('compare.string')->true());
        static::assertTrue($this->comparable->is('compare.string')->not()->true());

        static::assertFalse($this->comparable->is('invalid')->true);
        static::assertTrue($this->comparable->is('invalid')->not()->true);

        static::assertTrue($this->comparable->is('compare.bool')->true);
        static::assertFalse($this->comparable->is('compare.bool')->not()->true);

        static::assertFalse($this->comparable->is('compare.string')->true);
        static::assertTrue($this->comparable->is('compare.string')->not()->true);
    }

    public function test_truthy(): void
    {
        static::assertFalse($this->comparable->is('invalid')->truthy());
        static::assertTrue($this->comparable->is('invalid')->not()->truthy());

        static::assertTrue($this->comparable->is('compare.bool')->truthy());
        static::assertFalse($this->comparable->is('compare.bool')->not()->truthy());

        static::assertTrue($this->comparable->is('compare.string')->truthy());
        static::assertFalse($this->comparable->is('compare.string')->not()->truthy());

        static::assertFalse($this->comparable->is('compare.false')->truthy());
        static::assertTrue($this->comparable->is('compare.false')->not()->truthy());

        static::assertFalse($this->comparable->is('invalid')->truthy);
        static::assertTrue($this->comparable->is('invalid')->not()->truthy);

        static::assertTrue($this->comparable->is('compare.bool')->truthy);
        static::assertFalse($this->comparable->is('compare.bool')->not()->truthy);

        static::assertTrue($this->comparable->is('compare.string')->truthy);
        static::assertFalse($this->comparable->is('compare.string')->not()->truthy);

        static::assertFalse($this->comparable->is('compare.false')->truthy);
        static::assertTrue($this->comparable->is('compare.false')->not()->truthy);
    }

    public function test_false(): void
    {
        static::assertFalse($this->comparable->is('invalid')->false());
        static::assertTrue($this->comparable->is('invalid')->not()->false());

        static::assertTrue($this->comparable->is('compare.false')->false());
        static::assertFalse($this->comparable->is('compare.false')->not()->false());

        static::assertFalse($this->comparable->is('compare.bool')->false());
        static::assertTrue($this->comparable->is('compare.bool')->not()->false());

        static::assertFalse($this->comparable->is('invalid')->false);
        static::assertTrue($this->comparable->is('invalid')->not()->false);

        static::assertTrue($this->comparable->is('compare.false')->false);
        static::assertFalse($this->comparable->is('compare.false')->not()->false);

        static::assertFalse($this->comparable->is('compare.bool')->false);
        static::assertTrue($this->comparable->is('compare.bool')->not()->false);
    }

    public function test_falsy(): void
    {
        static::assertTrue($this->comparable->is('invalid')->falsy());
        static::assertFalse($this->comparable->is('invalid')->not()->falsy());

        static::assertTrue($this->comparable->is('compare.false')->falsy());
        static::assertFalse($this->comparable->is('compare.false')->not()->falsy());

        static::assertTrue($this->comparable->is('compare.blank')->falsy());
        static::assertFalse($this->comparable->is('compare.blank')->not()->falsy());

        static::assertTrue($this->comparable->is('compare.false')->falsy());
        static::assertFalse($this->comparable->is('compare.false')->not()->falsy());

        static::assertTrue($this->comparable->is('invalid')->falsy);
        static::assertFalse($this->comparable->is('invalid')->not()->falsy);

        static::assertTrue($this->comparable->is('compare.false')->falsy);
        static::assertFalse($this->comparable->is('compare.false')->not()->falsy);

        static::assertTrue($this->comparable->is('compare.blank')->falsy);
        static::assertFalse($this->comparable->is('compare.blank')->not()->falsy);

        static::assertTrue($this->comparable->is('compare.false')->falsy);
        static::assertFalse($this->comparable->is('compare.false')->not()->falsy);
    }

    public function test_null(): void
    {
        static::assertTrue($this->comparable->is('invalid')->null());
        static::assertFalse($this->comparable->is('invalid')->not()->null());

        static::assertTrue($this->comparable->is('compare.null')->null());
        static::assertFalse($this->comparable->is('compare.null')->not()->null());

        static::assertFalse($this->comparable->is('compare.string')->null());
        static::assertTrue($this->comparable->is('compare.string')->not()->null());

        static::assertTrue($this->comparable->is('invalid')->null);
        static::assertFalse($this->comparable->is('invalid')->not()->null);

        static::assertTrue($this->comparable->is('compare.null')->null);
        static::assertFalse($this->comparable->is('compare.null')->not()->null);

        static::assertFalse($this->comparable->is('compare.string')->null);
        static::assertTrue($this->comparable->is('compare.string')->not()->null);
    }

    public function test_exactly(): void
    {
        static::assertFalse($this->comparable->is('invalid')->exactly('foo'));
        static::assertTrue($this->comparable->is('invalid')->not()->exactly('foo'));

        static::assertTrue($this->comparable->is('compare.string')->exactly('foo bar baz'));
        static::assertFalse($this->comparable->is('compare.string')->not()->exactly('foo bar baz'));
    }

    public function test_zero(): void
    {
        static::assertFalse($this->comparable->is('invalid')->zero());
        static::assertTrue($this->comparable->is('invalid')->not()->zero());

        static::assertFalse($this->comparable->is('compare.empty')->zero());
        static::assertTrue($this->comparable->is('compare.empty')->not()->zero());

        static::assertFalse($this->comparable->is('compare.zeroes.0')->zero());
        static::assertTrue($this->comparable->is('compare.zeroes.0')->not()->zero());

        static::assertTrue($this->comparable->is('compare.zeroes.1')->zero());
        static::assertFalse($this->comparable->is('compare.zeroes.1')->not()->zero());

        static::assertTrue($this->comparable->is('compare.zeroes.2')->zero());
        static::assertFalse($this->comparable->is('compare.zeroes.2')->not()->zero());

        static::assertFalse($this->comparable->is('invalid')->zero);
        static::assertTrue($this->comparable->is('invalid')->not()->zero);

        static::assertFalse($this->comparable->is('compare.empty')->zero);
        static::assertTrue($this->comparable->is('compare.empty')->not()->zero);

        static::assertFalse($this->comparable->is('compare.zeroes.0')->zero);
        static::assertTrue($this->comparable->is('compare.zeroes.0')->not()->zero);

        static::assertTrue($this->comparable->is('compare.zeroes.1')->zero);
        static::assertFalse($this->comparable->is('compare.zeroes.1')->not()->zero);

        static::assertTrue($this->comparable->is('compare.zeroes.2')->zero);
        static::assertFalse($this->comparable->is('compare.zeroes.2')->not()->zero);
    }

    public function test_counting(): void
    {
        static::assertTrue($this->comparable->is('compare.nested.items')->counting(4));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->counting(4));
    }

    public function test_counting_fails_on_non_countable(): void
    {
        $this->expectException(Error::class);

        $this->comparable->is('invalid')->counting(1);
    }

    public function test_greater_than(): void
    {
        static::assertFalse($this->comparable->is('invalid')->greaterThan(3));
        static::assertTrue($this->comparable->is('invalid')->not()->greaterThan(3));

        static::assertTrue($this->comparable->is('compare.nested.items')->greaterThan(3));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->greaterThan(3));

        static::assertTrue($this->comparable->is('compare.number')->greaterThan(3));
        static::assertFalse($this->comparable->is('compare.number')->not()->greaterThan(3));

        static::assertTrue($this->comparable->is('compare.float')->greaterThan(3.0));
        static::assertFalse($this->comparable->is('compare.float')->not()->greaterThan(3.0));
    }

    public function test_above_zero(): void
    {
        static::assertFalse($this->comparable->is('invalid')->aboveZero());
        static::assertTrue($this->comparable->is('invalid')->not()->aboveZero());

        static::assertTrue($this->comparable->is('compare.nested.items')->aboveZero());
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->aboveZero());

        static::assertTrue($this->comparable->is('compare.number')->aboveZero());
        static::assertFalse($this->comparable->is('compare.number')->not()->aboveZero());

        static::assertTrue($this->comparable->is('compare.float')->aboveZero());
        static::assertFalse($this->comparable->is('compare.float')->not()->aboveZero());

        static::assertFalse($this->comparable->is('invalid')->aboveZero);
        static::assertTrue($this->comparable->is('invalid')->not()->aboveZero);

        static::assertTrue($this->comparable->is('compare.nested.items')->aboveZero);
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->aboveZero);

        static::assertTrue($this->comparable->is('compare.number')->aboveZero);
        static::assertFalse($this->comparable->is('compare.number')->not()->aboveZero);

        static::assertTrue($this->comparable->is('compare.float')->aboveZero);
        static::assertFalse($this->comparable->is('compare.float')->not()->aboveZero);
    }

    public function test_equal_or_greater_than(): void
    {
        static::assertFalse($this->comparable->is('invalid')->equalOrGreaterThan(10));
        static::assertTrue($this->comparable->is('invalid')->not()->equalOrGreaterThan(10));

        static::assertTrue($this->comparable->is('compare.nested.items')->equalOrGreaterThan(4));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->equalOrGreaterThan(4));
        static::assertTrue($this->comparable->is('compare.nested.items')->equalOrGreaterThan(3));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->equalOrGreaterThan(3));

        static::assertTrue($this->comparable->is('compare.number')->equalOrGreaterThan(10));
        static::assertFalse($this->comparable->is('compare.number')->not()->equalOrGreaterThan(10));
        static::assertTrue($this->comparable->is('compare.number')->equalOrGreaterThan(9));
        static::assertFalse($this->comparable->is('compare.number')->not()->equalOrGreaterThan(9));

        static::assertTrue($this->comparable->is('compare.float')->equalOrGreaterThan(20.0));
        static::assertFalse($this->comparable->is('compare.float')->not()->equalOrGreaterThan(20.0));
        static::assertTrue($this->comparable->is('compare.float')->equalOrGreaterThan(19.9));
        static::assertFalse($this->comparable->is('compare.float')->not()->equalOrGreaterThan(19.9));
    }

    public function test_equal_or_less_than(): void
    {
        static::assertFalse($this->comparable->is('invalid')->equalOrLessThan(10));
        static::assertTrue($this->comparable->is('invalid')->not()->equalOrLessThan(10));

        static::assertTrue($this->comparable->is('compare.nested.items')->equalOrLessThan(4));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->equalOrLessThan(4));
        static::assertTrue($this->comparable->is('compare.nested.items')->equalOrLessThan(5));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->equalOrLessThan(5));

        static::assertTrue($this->comparable->is('compare.number')->equalOrLessThan(10));
        static::assertFalse($this->comparable->is('compare.number')->not()->equalOrLessThan(10));
        static::assertTrue($this->comparable->is('compare.number')->equalOrLessThan(11));
        static::assertFalse($this->comparable->is('compare.number')->not()->equalOrLessThan(11));

        static::assertTrue($this->comparable->is('compare.float')->equalOrLessThan(20.0));
        static::assertFalse($this->comparable->is('compare.float')->not()->equalOrLessThan(20.0));
        static::assertTrue($this->comparable->is('compare.float')->equalOrLessThan(21.1));
        static::assertFalse($this->comparable->is('compare.float')->not()->equalOrLessThan(21.1));
    }

    public function test_less_than(): void
    {
        static::assertFalse($this->comparable->is('invalid')->lessThan(3));
        static::assertTrue($this->comparable->is('invalid')->not()->lessThan(3));

        static::assertTrue($this->comparable->is('compare.nested.items')->lessThan(5));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->lessThan(5));

        static::assertTrue($this->comparable->is('compare.number')->lessThan(11));
        static::assertFalse($this->comparable->is('compare.number')->not()->lessThan(11));

        static::assertTrue($this->comparable->is('compare.float')->lessThan(20.1));
        static::assertFalse($this->comparable->is('compare.float')->not()->lessThan(20.1));
    }

    public function test_below_zero(): void
    {
        static::assertFalse($this->comparable->is('invalid')->belowZero());
        static::assertTrue($this->comparable->is('invalid')->not()->belowZero());

        static::assertFalse($this->comparable->is('compare.nested.items')->belowZero());
        static::assertTrue($this->comparable->is('compare.nested.items')->not()->belowZero());

        static::assertTrue($this->comparable->is('compare.negative.number')->belowZero());
        static::assertFalse($this->comparable->is('compare.negative.number')->not()->belowZero());

        static::assertTrue($this->comparable->is('compare.negative.float')->belowZero());
        static::assertFalse($this->comparable->is('compare.negative.float')->not()->belowZero());

        static::assertFalse($this->comparable->is('invalid')->belowZero);
        static::assertTrue($this->comparable->is('invalid')->not()->belowZero);

        static::assertFalse($this->comparable->is('compare.nested.items')->belowZero);
        static::assertTrue($this->comparable->is('compare.nested.items')->not()->belowZero);

        static::assertTrue($this->comparable->is('compare.negative.number')->belowZero);
        static::assertFalse($this->comparable->is('compare.negative.number')->not()->belowZero);

        static::assertTrue($this->comparable->is('compare.negative.float')->belowZero);
        static::assertFalse($this->comparable->is('compare.negative.float')->not()->belowZero);
    }

    public function test_containing(): void
    {
        static::assertFalse($this->comparable->is('invalid')->containing('foo'));
        static::assertTrue($this->comparable->is('invalid')->not()->containing('foo'));

        static::assertTrue($this->comparable->is('compare.nested.items')->containing('foo'));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->containing('foo'));

        static::assertTrue($this->comparable->is('compare.string')->containing('foo'));
        static::assertFalse($this->comparable->is('compare.string')->not()->containing('foo'));
    }

    public function test_containing_one_item(): void
    {
        static::assertTrue($this->comparable->is('compare.nested')->containingOneItem());
        static::assertFalse($this->comparable->is('compare.nested')->not()->containingOneItem());

        static::assertFalse($this->comparable->is('compare.nested.items')->containingOneItem());
        static::assertTrue($this->comparable->is('compare.nested.items')->not()->containingOneItem());

        static::assertTrue($this->comparable->is('compare.nested')->containingOneItem);
        static::assertFalse($this->comparable->is('compare.nested')->not()->containingOneItem);

        static::assertFalse($this->comparable->is('compare.nested.items')->containingOneItem);
        static::assertTrue($this->comparable->is('compare.nested.items')->not()->containingOneItem);
    }

    public function test_containing_one_item_fails_if_not_countable(): void
    {
        $this->expectException(Error::class);

        $this->comparable->is('invalid')->containingOneItem();
    }

    public function test_between(): void
    {
        static::assertFalse($this->comparable->is('invalid')->between(1, 2));
        static::assertTrue($this->comparable->is('invalid')->not()->between(1, 2));

        static::assertTrue($this->comparable->is('compare.nested.items')->between(1, 4));
        static::assertFalse($this->comparable->is('compare.nested.items')->not()->between(1, 4));

        static::assertFalse($this->comparable->is('compare.nested.items')->between(1, 4, false));
        static::assertTrue($this->comparable->is('compare.nested.items')->not()->between(1, 4, false));

        static::assertTrue($this->comparable->is('compare.number')->between(9, 10));
        static::assertFalse($this->comparable->is('compare.number')->not()->between(9, 10));

        static::assertFalse($this->comparable->is('compare.number')->between(9, 10, false));
        static::assertTrue($this->comparable->is('compare.number')->not()->between(9, 10, false));

        static::assertTrue($this->comparable->is('compare.float')->between(19.9, 20.0));
        static::assertFalse($this->comparable->is('compare.float')->not()->between(19.9, 20.0));

        static::assertFalse($this->comparable->is('compare.float')->between(19.9, 20.0, false));
        static::assertTrue($this->comparable->is('compare.float')->not()->between(19.9, 20.0, false));
    }

    public function test_applies_comparable_to_pluck_values(): void
    {
        static::assertTrue($this->comparable->is('compare.*')->counting(11));

        static::assertTrue($this->comparable->is('compare.*.*.*')->exactly(['foo', 'bar', 'baz', 'quz']));
    }
}
