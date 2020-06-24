<?php

declare(strict_types=1);

use Murtukov\PHPCodeGenerator\ArrowFunction;
use PHPUnit\Framework\TestCase;

class ArrowFunctionTest extends TestCase
{
    /**
     * @test
     */
    public function emptyBody()
    {
        $arrow = ArrowFunction::new();

        $this->expectOutputString(<<<CODE
        fn() => null
        CODE);

        echo $arrow;

        return $arrow;
    }
    
    /**
     * @test
     * @depends emptyBody
     */
    public function setExpression(ArrowFunction $arrow)
    {
        $innerArrow = ArrowFunction::new([
            'name' => 'Alrik',
            'age' => 30
        ]);

        $arrow->setExpression($innerArrow);

        $template = <<<CODE
        fn() => fn() => [
            'name' => 'Alrik',
            'age' => 30,
        ]
        CODE;

        $this->expectOutputString($template);

        echo $arrow;

        return [$arrow, $template];
    }

    /**
     * @test
     * @depends setExpression
     */
    public function setStatic(array $values)
    {
        [$arrow, $template] = $values;

        $arrow->setStatic();
        $this->expectOutputString('static '.$template);

        echo $arrow;
    }
}
