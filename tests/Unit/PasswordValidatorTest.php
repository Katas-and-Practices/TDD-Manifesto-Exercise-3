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
     * @dataProvider shouldReturnErrorMessageGivenPasswordsShorterThanEightCharactersLongDataProvider
     */
    public function testShouldReturnErrorMessageGivenPasswordsShorterThanEightCharactersLong(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => false, 'error-message' => 'Password must be at least 8 characters long'], $result);
    }

    /**
     * @dataProvider shouldReturnErrorMessageGivenPasswordsWithoutAtLeastTwoNumbers
     */
    public function testShouldReturnErrorMessageGivenPasswordsWithoutAtLeastTwoNumbers(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => false, 'error-message' => 'Password must contain at least 2 numbers'], $result);
    }

    /**
     * @dataProvider shouldReturnTwoErrorMessagesGivenPasswordsWithoutTwoNumbersAndShorterThanEight
     */
    public function testShouldReturnTwoErrorMessagesGivenPasswordsWithoutTwoNumbersAndShorterThanEight(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame([
            'success' => false,
            'error-message' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers"
        ], $result);
    }

    public static function shouldAcceptPasswordsLongerThanSevenCharactersLongDataProvider(): array
    {
        return [
            ['abc12fgh'],
            ['abcdefghij57lm'],
        ];
    }

    public static function shouldReturnErrorMessageGivenPasswordsShorterThanEightCharactersLongDataProvider(): array
    {
        return [
            ['a78c'],
            ['1234567'],
        ];
    }

    public static function shouldReturnErrorMessageGivenPasswordsWithoutAtLeastTwoNumbers(): array
    {
        return [
            ['abcdefgh'],
            ['abcdefg1'],
            ['abcdefgha'],
            ['abcdefg1h'],
            ['abcdefghijk2'],
        ];
    }

    public static function shouldReturnTwoErrorMessagesGivenPasswordsWithoutTwoNumbersAndShorterThanEight(): array
    {
        return [
            ['abcd'],
            ['abcd3ef'],
        ];
    }
}