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
            ['', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one capital letter\nPassword must contain at least one special character"],
            ['1', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one capital letter\nPassword must contain at least one special character"],
            ['acd', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one capital letter\nPassword must contain at least one special character"],
            ['A', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one special character"],
            ['52', "Password must be at least 8 characters long\nPassword must contain at least one capital letter\nPassword must contain at least one special character"],
            [')', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one capital letter"],
            ['Bacd', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one special character"],
            ['a1a5', "Password must be at least 8 characters long\nPassword must contain at least one capital letter\nPassword must contain at least one special character"],
            ['abcD3ef', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one special character"],
            ['abc3efabc', "Password must contain at least 2 numbers\nPassword must contain at least one capital letter\nPassword must contain at least one special character"],
            ['B_c?', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers"],
            ['ab|3efabc', "Password must contain at least 2 numbers\nPassword must contain at least one capital letter"],
            ['a7Bc3', "Password must be at least 8 characters long\nPassword must contain at least one special character"],
            ['AB34Z67', "Password must be at least 8 characters long\nPassword must contain at least one special character"],
            ['abcAefgh', "Password must contain at least 2 numbers\nPassword must contain at least one special character"],
            ['abcdBfg1', "Password must contain at least 2 numbers\nPassword must contain at least one special character"],
            ['abcdefg1H', "Password must contain at least 2 numbers\nPassword must contain at least one special character"],
            ['abcHefghijK2', "Password must contain at least 2 numbers\nPassword must contain at least one special character"],
            ['abcdefg15', "Password must contain at least one capital letter\nPassword must contain at least one special character"],
            ['a7Bc3\'', "Password must be at least 8 characters long"],
            ['!bcdefg1H', "Password must contain at least 2 numbers"],
            ['ab+ef7hijd2', "Password must contain at least one capital letter"],
            ['ab6ef7_ijd2', "Password must contain at least one capital letter"],
            ['1234567A', 'Password must contain at least one special character'],
            ['ab2c2fAh24gd', 'Password must contain at least one special character'],
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