# laravel-stub-generator

**Laravel **

create custom Models and Migrations based on relation type by an Artisan Command

Command is like this

``` php artisan make:custom-model MODEL_NAME_1 MODEL_NAME_2 --type=RELATION_TYPE ```

The type can be one of these

1. "11" for one to one relation

2. "1n" for one to many relation

3. "nn" for many to many relation

Example

``` php artisan make:custom-model Author Book --type=nn ```

To run, the files must be placed in the specified path in Laravel project

First run command ``` php artisan stub:publish ``` to publish stubs in root directory

Root
|
|__app
|    |__Console
|    |    |__Commands
|    |         |__CustomModel.php
|    |__Services
|         |__CustomStub
|              |__FileHelper.php
|              |__PluralForm.php
|              |__StubGenerationException.php
|              |__StubGenerator.php
|
|
|__stubs
     |__custom-migration.create.stub
     |__custom-model.stub
