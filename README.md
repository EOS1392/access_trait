# Access trait

The access trait is a dirty and simple helper for some problems. I wrote it, because in some cases, the 
framework/CMS/system you write code for, does not allow you to get access to some variables or methods, you need
to use. With this trait you get the access, but be careful!

## Usage

### Get read access of a variable (`getVariable`) 

In the case you need read access of a variable, the trait provides the `getVariable` method. This method can handle the 
following parameter:

| Name                      | Default value | Description                                |
| ------------------------- |:--------------| ------------------------------------------ |
| `$variableName`           | -             | The variable name which should be accessed |
| `$object`                 | -             | The object in which the variable exist     |
| `$alternativeObjectScope` | null          | An alternative object scope                |

At least 2 parameters are required for the usage. 

#### Basic example

```
class test {

    private $foo = 'bar';
}

class baz {

    use \BeFlo\AccessTrait\AccessTrait;

    public function __construct() {
        $test = new test();
        $value = $this->getVariable('foo', $test);
        echo $value; 
    }
}

$test = new baz(); // 'bar' will be printed
```

### Get write access of a variable (`setVariable`) 

In the case you need write access of a variable, the trait provides the `setVariable` method. This method can handle the 
following parameter:

| Name                      | Default value | Description                                |
| ------------------------- |:--------------| ------------------------------------------ |
| `$variableName`           | -             | The variable name which should be accessed |
| `$newValue`               | -             | The new variable value                     |
| `$object`                 | -             | The object in which the variable exist     |
| `$alternativeObjectScope` | null          | An alternative object scope                |

At least 3 parameters are required for the usage. 

#### Basic example

```
class test {

    private $foo = 'bar';
}

class baz {

    use \BeFlo\AccessTrait\AccessTrait;

    public function __construct() {
        $test = new test();
        $this->setVariable('foo', 'baz', $test);
        $value = $this->getVariable('foo', $test);
        echo $value; 
    }
}

$test = new baz(); // 'baz' will be printed
```

### Execute method of an object (`executeMethod`) 

In the case you need read access of a variable the trait provides the "getVariable" method. This method can handle the 
following parameter:

| Name                      | Default value | Description                                 |
| ------------------------- |:--------------| ------------------------------------------- |
| `$variableName`           | -             | The variable name which should be accessed  |
| `$object`                 | -             | The object in which the variable exist      |
| `$parameter`              | []            | The parameter of the method as an array     |
| `$alternativeObjectScope` | null          | An alternative object scope                 |

At least 2 parameters are required for the usage. 

#### Example

```
class test {

    private function foo(string $var1, array $var2) {
        // Do magic stuff here
    }
}

class baz {

    use \BeFlo\AccessTrait\AccessTrait;

    public function __construct() {
        $test = new test();
        $this->executeMethod('foo', $test, ['bar', ['baz' => 'husel']]);
    }
}

$test = new baz(); // Magic stuff will happen
```

## The alternative object scope

Each method will have a parameter with the name `$alternativeObjectScope`, which is needed for the case, that the 
variable/method you want to access is not located in the class of the object you have but instead it's located in 
an inherited class of the object. In this case you have to give the class name of the inherited class as an alternative
scope for the closure.  