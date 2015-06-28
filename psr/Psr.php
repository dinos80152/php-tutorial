<?php // PSR-1: MUST use only <?php and <?= tags, MUST use only UTF-8 without BOM for PHP code.
namespace App\Psr; // PSR-1: Namespaces and classes MUST follow an "autoloading" PSR-4
// PSR-2: There MUST be one blank line after the namespace declaration
use Input; // PSR-2: There MUST be one use keyword per declaration.
use Output;
use DinoLai\NameConcat as Concat;
// PSR-2: MUST be one blank line after the block of use declarations.
class Psr extends Php implements // PSR-1: Class names MUST be declared in StudlyCaps. //// PSR2: The extends and implements keywords MUST be declared on the same line as the class name.
    PsrInterface,
    DemoInterface,
    HelloInterface  //Lists of implements MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list MUST be on the next line, and there MUST be only one interface per line.
{// PSR-2: Opening braces for classes MUST go on the next line

    const CREATED_AT = 'created_at'; // PSR-1: Class constants MUST be declared in all upper case with underscore separators.

    private static $timeZone = 'UTF-8';

    private $locale; // PSR-2: Property and Method names SHOULD NOT be prefixed with a single underscore to indicate protected or private visibility.

    // PSR-2: Visibility MUST be declared on all properties and methods
    protected $fullName;
    protected $concat;

    //Methods
    public function __construct($locale)
    {
        $this->locale = $locale;
        $this->concat = new Concat;
    }

    public function getFullName() // PSR-1: Method names MUST be declared in camelCase. PSR-2: Method names MUST NOT be declared with a space after the method name.
    {// PSR-2: Opening braces for methods MUST go on the next line
        return $this->fullName; // PSR-2: Code MUST use 4 spaces for indenting, not tabs.
    }// PSR-2: closing braces MUST go on the next line after the body.

    public static function set($firstName, $lastName, $middleName = '') // PSR-2: static MUST be declared after the visibility. In the argument list, there MUST NOT be a space before each comma, and there MUST be one space after each comma.
    {
        switch ($this->locale) {
            case 'hk':
                // There MUST be a comment such as // no break when fall-through is intentional in a non-empty case body.
                // no break
            case 'tw':
                // PSR-2: method and function calls MUST NOT have one space after them. The structure body MUST be indented once
                $this->fullName = $this->concat($firstName, $lastName);
                break;
            case 'en':
                break;
            default:
                break;
        }
    }

    final public function demoIf($parameter) // PSR-2: abstract and final MUST be declared before the visibility
    {
        if (isset($parameter)) { // PSR-2: Control structure keywords MUST have one space after them, Opening braces for control structures MUST go on the same line. Opening parentheses for control structures MUST NOT have a space after them, and closing parentheses for control structures MUST NOT have a space before. There MUST be one space between the closing parenthesis and the opening brace

        } elseif () { // PSR-2 The keyword elseif SHOULD be used instead of else if so that all control keywords look like single words.

        } else {

        }// PSR-2: Control structure closing braces MUST go on the next line after the body.
        return true; // PSR-2: The PHP constants true, false, and null MUST be in lower case.
    }

    public function demoWhile()
    {
        while ($expr) {

        }

        do {
            // structure body;
        } while ($expr);
    }

    public function demoFor()
    {
        for ($i = 0; $i < 10; $i++) {
            // for body
        }
    }

    public function demoForeach()
    {
        foreach ($iterable as $key => $value) {
            // foreach body
        }
    }

    public function demoException()
    {
        try {
            // try body
        } catch (FirstExceptionType $e) {
            // catch body
        } catch (OtherExceptionType $e) {
            // catch body
        } finally {

        }
    }

    public function demoClosures()
    {
        // PSR2: Closures MUST be declared with a space after the function keyword, and a space before and after the use keyword.
        $closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2) {
            // body
        };
    }

}// PSR-2: closing braces MUST go on the next line after the body.
// All PHP files MUST end with a single blank line.

// PSR-2: There MUST NOT be a hard limit on line length; the soft limit MUST be 120 characters; lines SHOULD be 80 characters or less.
// PSR-2: All PHP files MUST use the Unix LF (linefeed) line ending.
// PSR-2: The closing ?\> tag MUST be omitted from files containing only PHP.
// PSR-2: There MUST NOT be trailing whitespace at the end of non-blank lines.
// PSR-2: There MUST NOT be more than one statement per line.
// PSR-2: PHP keywords MUST be in lower case.