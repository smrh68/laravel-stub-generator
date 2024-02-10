<?php

namespace App\Console\Commands;

use App\Services\CustomStub\PluralForm;
use App\Services\CustomStub\StubGenerator;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CustomModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:custom-model {model_1} {model_2} {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make Custom model and migration with relations';

    protected StubGenerator $stubGenerator;

    public function __construct()
    {
        parent::__construct();
        $this->stubGenerator = new StubGenerator();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model1 = $this->argument('model_1');
        $model2 = $this->argument('model_2');
        $type = $this->option('type');

        switch ($type){
            case '11':
                $this->one_to_one($model1, $model2);
                break;
            case '1n':
                $this->one_to_many($model1, $model2);
                break;
            case 'nn':
                $this->many_to_many($model1, $model2);
                break;
        }
    }

    public function one_to_one($model1, $model2)
    {
        $this->modelGenerator($model1, $model2, 'hasOne');
        $this->modelGenerator($model2, $model1, 'belongsTo');
        $this->migrationGenerator($model1);
        $this->migrationGenerator($model2);
    }

    public function one_to_many($model1, $model2)
    {
        $this->modelGenerator($model1, $model2, 'hasMany');
        $this->modelGenerator($model2, $model1, 'belongsTo');
        $this->migrationGenerator($model1);
        $this->migrationGenerator($model2);
    }

    public function many_to_many($model1, $model2)
    {
        $this->modelGenerator($model1, $model2, 'belongsToMany');
        $this->modelGenerator($model2, $model1, 'belongsToMany');
        $this->migrationGenerator($model1);
        $this->migrationGenerator($model2);
        $this->middleMigrationGenerator($model1, $model2);
    }

    public function modelGenerator($model, $relationModel, $relation)
    {
        $relationName = in_array($relation, array('hasMany', 'belongsToMany'))? PluralForm::make($relationModel) : $relationModel;
        $stub = 'custom-model';
        $content = [
            'namespace' => 'App\Models',
            'class' => $model,
            'relationClass' => $relationModel,
            'relationName' => lcfirst($relationName),
            'relationType' => ucfirst($relation),
            'relation' => $relation,
        ];
        $savePath = app_path('Models/'. $model . '.php');
        $this->stubGenerator->load($stub)->make($content)->save($savePath);
        $this->info('Model '. $model . ' created successfully.');
    }

    public function migrationGenerator($model)
    {
        $table_name = PluralForm::make(lcfirst($model));
        // Generate migration file
        Artisan::call('make:migration', [
            'name' => "create_{$table_name}_table",
            '--create' => $table_name,
        ]);
        $this->info('Migration '. $table_name .' created successfully.');
    }

    //for migrate middle table of many_to_many relation
    public function middleMigrationGenerator($model1, $model2)
    {
        $stub = 'custom-migration.create';
        $table_name = lcfirst($model1) . '_' . lcfirst($model2);
        $content = [
            'table' => $table_name,
            'model1' => lcfirst($model1),
            'model2' => lcfirst($model2),
        ];
        $time = Carbon::now()->format('Y_m_d_His');
        $savePath = base_path('/database/migrations/'. $time .'_create_' . $table_name . '_table.php');
        $this->stubGenerator->load($stub)->make($content)->save($savePath);
        $this->info('Migration '. $table_name .' created successfully.');
    }
}
