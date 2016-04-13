# Segments

Segments are a means of grouping together groups of users who meet a particular sub-set of rules. Segments are defined in code using a specifically designed class which has public emthods which act as callbacks.


## The Segments Class

Your component (or app) can provide a class which has one or more public methods in it which return an array of user IDs. These IDs are used by the drip campaign as the sub-set of users which are being dealt with during that aprticular run of the campaign.

The name of this class must match the following rules:

* Be within the components root namespace (as defined in `composer.json` or `config.json`)
* Be called `EmailDripSegments`

A valid example for fictional component `myvendor/foo` might be `MyVendor/Foo/EmailDripSegments`.


### Defining segments

Each public, non-static method of this class is considered a segment handler. The segment model uses reflection to analyse the class and will automatically use any DocBlock description as the method's label. If none is found it will format the method's name into a more human-friendly string.

Each segment handler must return an array of user IDs and nothing else. It will receive no arguments.

**Example**

See below for an example for fictional component `myvendor/foo`:

```php
<?php

namespace MyVendor\Foo;

class EmailDripSegments
{
    /**
     * Users who like dogs
     * @return array
     */
    public function usersWhoLikeDogs()
    {
        //  Perform whatever actions are required
        return array(1, 2, 3)
    }

    /**
     * Users who like cats
     * @return array
     */
    public function usersWhoLikeCats()
    {
        //  Perform whatever actions are required
        return array(4, 5, 6)
    }

    public function usersWhoLikeCatsAndDogs()
    {
        //  Perform whatever actions are required
        //  Notice this method does not have a docBloc
        return array(1, 5, 10)
    }

    //  The following methods will be ignored
    protected function someProtectedMethod()
    {
    }

    private function somePrivateMethod()
    {
    }

    static function someStaticMethod()
    {
    }
}

```

The above class will return 3 segment handlers, named the following:

* Users who like dogs
* Users who like cats
* Users who like cats and dogs
