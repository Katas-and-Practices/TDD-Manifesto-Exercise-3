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

        $this->assertSame(['success' => true], $result);
    }

    /**
     * @dataProvider shouldReturnErrorMessageGivenPasswordsShorterThanNineCharactersLongDataProvider
     */
    public function testShouldReturnErrorMessageGivenPasswordsShorterThanEightCharactersLong(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => false, 'error-message' => 'Password must be at least 8 characters long'], $result);
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
            ['abc'],
            ['1234567'],
        ];
    }
}