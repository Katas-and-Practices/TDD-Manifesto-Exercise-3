<?php

namespace Exercise3\Tests\Unit;

require_once 'src/PasswordValidator.php';
require_once 'src/ValidatorRunner.php';

use Exercise3\PasswordValidator;
use Exercise3\ValidatorRunner;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    public ValidatorRunner $passwordValidator;

    public function setUp(): void
    {
        $this->passwordValidator = new ValidatorRunner(new PasswordValidator());
    }

    /**
     * @dataProvider shouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputsDataProvider
     */
    public function testShouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputs(string $testcase, string $errorMessage): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => false, 'error-message' => $errorMessage], $result);
    }

    /**
     * @dataProvider shouldPassGivenCorrectInputPassword
     */
    public function testShouldPassGivenCorrectInputPassword(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => true], $result);
    }

    public static function shouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputsDataProvider(): array
    {
        return [
            ['', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ['1', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ['acd', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ['A', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ['52', "Password must be at least 8 characters long\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            [')', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters"],
            ['Bacd', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ['a1a5', "Password must be at least 8 characters long\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ['abcD3ef', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ['abc3efabc', "Password must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ['B_c?', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers"],
            ['ab|3efabc', "Password must contain at least 2 numbers\nPassword must contain at least 1 capital letters"],
            ['a7Bc3', "Password must be at least 8 characters long\nPassword must contain at least 1 special characters"],
            ['AB34Z67', "Password must be at least 8 characters long\nPassword must contain at least 1 special characters"],
            ['abcAefgh', "Password must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ['abcdBfg1', "Password must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ['abcdefg1H', "Password must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ['abcHefghijK2', "Password must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ['abcdefg15', "Password must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ['a7Bc3\'', "Password must be at least 8 characters long"],
            ['!bcdefg1H', "Password must contain at least 2 numbers"],
            ['ab+ef7hijd2', "Password must contain at least 1 capital letters"],
            ['ab6ef7_ijd2', "Password must contain at least 1 capital letters"],
            ['1234567A', 'Password must contain at least 1 special characters'],
            ['ab2c2fAh24gd', 'Password must contain at least 1 special characters'],
        ];
    }

    public static function shouldPassGivenCorrectInputPassword(): array
    {
        return [
            ['123456+A'],
            ['1A3?5678'],
            ['<33DEFGH'],
            ['bcdE4g4\\'],
            ['22dfdfA?'],
            ['ab2c2fAh__4gd'],
            ['abcdE?Ahij57lm'],
        ];
    }
}