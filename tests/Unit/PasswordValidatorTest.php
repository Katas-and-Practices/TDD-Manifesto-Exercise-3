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
     * @dataProvider shouldReturnErrorMessageGivenPasswordsWithoutAtLeastTwoNumbersDataProvider
     */
    public function testShouldReturnErrorMessageGivenPasswordsWithoutAtLeastTwoNumbers(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => false, 'error-message' => 'Password must contain at least 2 numbers'], $result);
    }

    /**
     * @dataProvider shouldReturnTwoErrorMessagesGivenPasswordsWithoutTwoNumbersAndShorterThanEightDataProvider
     */
    public function testShouldReturnTwoErrorMessagesGivenPasswordsWithoutTwoNumbersAndShorterThanEight(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame([
            'success' => false,
            'error-message' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers"
        ], $result);
    }

    /**
     * @dataProvider shouldReturnErrorMessageGivenNoCapitalLettersDataProvider
     */
    public function testShouldReturnErrorMessageGivenNoCapitalLetters(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => false, 'error-message' => 'Password must contain at least one capital letter'], $result);
    }

    public static function shouldAcceptPasswordsLongerThanSevenCharactersLongDataProvider(): array
    {
        return [
            ['abc12fAh'],
            ['abcdefAhij57lm'],
        ];
    }

    public static function shouldReturnErrorMessageGivenPasswordsShorterThanEightCharactersLongDataProvider(): array
    {
        return [
            ['a78Bc'],
            ['1234Z67'],
        ];
    }

    public static function shouldReturnErrorMessageGivenPasswordsWithoutAtLeastTwoNumbersDataProvider(): array
    {
        return [
            ['abcAefgh'],
            ['abcdBfg1'],
            ['abcdEfgha'],
            ['abcdefg1H'],
            ['abcdefghijK2'],
        ];
    }

    public static function shouldReturnTwoErrorMessagesGivenPasswordsWithoutTwoNumbersAndShorterThanEightDataProvider(): array
    {
        return [
            ['aBcd'],
            ['abcD3ef'],
        ];
    }

    public static function shouldReturnErrorMessageGivenNoCapitalLettersDataProvider(): array
    {
        return [
            ['abcdef21ijk'],
            ['abcd3e66'],
        ];
    }
}