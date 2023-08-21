<?php

namespace Exercise3\Tests\Unit;

require_once 'src/PasswordValidator.php';

use Exercise3\PasswordValidator;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    public PasswordValidator $passwordValidator;

    public function setUp(): void
    {
        $this->passwordValidator = new PasswordValidator();
    }

    /**
     * @dataProvider shouldAcceptPasswordsLongerThanSevenCharactersLongDataProvider
     */
    public function testShouldAcceptPasswordsLongerThanSevenCharactersLong(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(true, $result);
    }

    /**
     * @dataProvider shouldReturnErrorMessageGivenPasswordsShorterThanNineCharactersLongDataProvider
     */
    public function testShouldReturnErrorMessageGivenPasswordsShorterThanEightCharactersLong(string $testcase, string $errorMessage): void
    {
        $this->expectExceptionMessage($errorMessage);

        $this->passwordValidator->validate($testcase);
    }

    public static function shouldAcceptPasswordsLongerThanSevenCharactersLongDataProvider(): array
    {
        return [
            ['abcdefgh'],
            ['abcdefghijklm'],
        ];
    }

    public static function shouldReturnErrorMessageGivenPasswordsShorterThanNineCharactersLongDataProvider(): array
    {
        return [
            ['abc', 'Password must be at least 8 characters long'],
            ['1234567', 'Password must be at least 8 characters long'],
        ];
    }
}