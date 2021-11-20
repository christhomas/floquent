# Floquent
Define eloquent model fields, allow php attributes on eloquent models, create validators for specific fields.

# Supported Attributes
- ```#[Table('users`)]```
- ```#[Fillable]```
- ```#[NotFillable]```
- ```#[StrictPropertyAccess]```
- ```#[Cast('string|min:20')]```
- ```#[Guarded]```
- ```#[Validate('number|gte:0`)]```

# Testing
The ```run-tests``` script can be used to execute the tests, it has the following options.

By default the tests run inside a docker container, this is to help people who don't have PHP 8 installed locally. MacOS only has PHP 7 installed locally. Also, this allow better control over the execution environment, so other locally configured software can't interfere with the tests.


- ```./run-tests``` Run the tests in the default dockerised environment
- ```./run-tests no-docker``` Run the tests but on the local machine, but this requires PHP 8 to be installed
- ```./run-tests stop``` Stop the testing docker container if it's running, otherwise in 3600 seconds (1 hour), it'll automatically stop

# Description
## Table
Configure the ```$this->table``` Eloquent property that will be used with this model

## StrictPropertyAcess
Will restrict setting or getting of any database field to the public properties of the model. This is good for preventing the addition of fields that are not part of the model. Eloquent by default will let you set any attribute you want. This allows the programmer to be strict about what properties they wish to allow

## Fillable
Adds to the ```$model->fillable[]``` Eloquent property all the specified fields given.

On the class, this attribute will add ALL the public properties from the model and it's a convenience to with one attribute, all all properties without making the class messy.

On the property, a single property will be added instead.

## NotFillable
This will remove a field from the ```$model->fillable[]``` Eloquent property. If the field was not in the array in the first place, then this property won't cause any affect.

## Guarded
Adds to the ```$model->guarded[]``` Eloqent property all the specified fields given.

On the class, this attribute will add ALL the public properties from the model and it's a convenience to with one attribute, all all properties without making the class messy.

On the property, a single property will be added instead.

## Validate
Adds to a list of validation rules, that when the programmer set properties on the model, will validate them against the rule, throwing exceptions when the value does not conform to the rule. It accepts normal laravel validation rules.

## Cast
This will add to the ```$model->casts[]``` Eloquent property setting how to cast information according to the Eloquent casts array.

# Example Usage
See description of each attribute for detailed information

```php
<?php declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Table('users'), StrictPropertyAccess, Fillable, Guarded]
class Users extends Model
{
    #[Guarded]
    public int $id;

    #[Fillable, Validate('email')]
    public string $email;

    #[NotFillable]
    public function $firstName;

    #[Cast('datetime:H:i:s Y-m-d')]
    public function $signupDate;
}
```