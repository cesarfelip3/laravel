<?php

namespace App\Console\Commands;

use DB;
use File;
use Schema;
use Artisan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Scaffolding extends Command
{
    protected $name;
    protected $object;
    protected $getTableColumns;
    protected $lowerName;
    protected $pluralName;
    protected $pluralPascalName;
    protected $snakePluralName;
    protected $pascalName;
    protected $kebabName;
    protected $kebabPluralName;
    protected $columnsInformation;
    protected $snakeName;
    protected $signature = 'scaffolding:make {name} {--object=all}';
    protected $description = 'Scaffolding everything related to the model';
    protected $unnecessaryColumns = ['id', 'created_at', 'updated_at', 'deleted_at', 'created_by_id', 'updated_by_id'];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->name = $this->argument('name');       // FooBar
        $this->object = $this->option('object');
        $this->lowerName = strtolower($this->name);       // foobar
        $this->pluralName = str_plural($this->name);       // foobars
        $this->pluralPascalName = $this->pluralName;             // Foobars
        $this->pascalName = $this->name;                   // FooBar
        $this->kebabName = kebab_case($this->name);       // foo-bar
        $this->kebabPluralName = kebab_case($this->pluralName);       // foo-bar
        $this->snakeName = snake_case($this->name);       // foo_bar
        $this->snakePluralName = snake_case($this->pluralName); // foo_bar

        // --
        // Get Database Information
        if ($this->hasTable()) {
            $this->getTableColumns();
        } else {
            if ($this->ask("The table for the model doesn't exist.\nDo you want to create a migration for it? [y/n]") == 'y') {
                $this->migration();
                $this->info('Make sure to run run the new migration before scaffolding again.');

                return false;
            }
        }

        switch ($this->object) {
            case 'migration':
                $this->migration();
                break;

            default:
                $this->model();
                $this->service();
                $this->apiController();
                $this->controller();
                $this->apiRoute();
                $this->route();
                $this->createRequest();
                $this->updateRequest();
                $this->makeVueDirectory();
                $this->vueForm();
                $this->vueList();
                $this->vueSelect();
                $this->updateBootstrapJs();
                $this->makeViewDirectory();
                $this->view();
                $this->info(PHP_EOL . 'BE HAPPY');
                break;
        }

    }

    private function model()
    {
        $this->generateFile('model', 'app/Models', $this->pascalName);
        $this->info('Model generated!');
    }

    private function apiController()
    {
        $this->generateFile('api-controller', 'app/Http/Controllers/Api', $this->pluralPascalName, 'Controller');
        $this->info('Api Controller generated!');
    }

    private function controller()
    {
        $this->generateFile('controller', 'app/Http/Controllers/Web', $this->pluralPascalName, 'Controller');
        $this->info('Controller generated!');
    }

    private function apiRoute()
    {
        $this->generateFile('api-route', 'app/Routes/api', $this->kebabName);
        $this->info('Api Route generated!');
    }

    private function route()
    {
        $this->generateFile('route', 'app/Routes/auth', $this->kebabName);
        $this->info('Route generated!');
    }

    private function createRequest()
    {
        $this->generateFile('create-request', 'app/Http/Requests', $this->pascalName, 'CreateRequest');
        $this->info('Create Request generated!');
    }

    private function updateRequest()
    {
        $this->generateFile('update-request', 'app/Http/Requests', $this->pascalName, 'UpdateRequest');
        $this->info('Update Request generated!');
    }

    private function service()
    {
        $this->generateFile('service', 'app/Services', $this->pascalName, 'Service');
        $this->info('Service generated!');
    }

    private function makeVueDirectory()
    {
        $this->makeDirectory('resources/assets/js/components', $this->kebabName);
        $this->info('Vue Directory generated!');
    }

    private function vueForm()
    {
        $this->generateFile('vue-form', "resources/assets/js/components/$this->kebabName", $this->kebabName, '-form', 'vue');
        $this->info('Vue Form generated!');
    }

    private function vueList()
    {
        $this->generateFile('vue-list', "resources/assets/js/components/$this->kebabName", $this->kebabName, '-list', 'vue');
        $this->info('Vue List generated!');
    }

    private function vueSelect()
    {
        $this->generateFile('vue-select', "resources/assets/js/components/$this->kebabName", $this->kebabName, '-select', 'vue');
        $this->info('Vue Select generated!');
    }

    private function makeViewDirectory()
    {
        $this->makeDirectory('resources/views', $this->snakeName);
        $this->info('View Directory generated!');
    }

    private function view()
    {
        $this->generateFile('view', "resources/views/$this->snakeName", 'index.blade');
        $this->info('View generated!');
    }

    private function migration()
    {
        $today = new Carbon();
        $this->generateFile(
            'migration',
            'database/migrations/',
            $this->snakePluralName,
            '_table',
            'php',
            $today->format('Y_m_d_His') . '_create_'
        );
        $this->info('Migration generated!');
    }

    // ==

    private function makeDirectory($path, $name)
    {
        File::makeDirectory(base_path() . "/$path/$name");
    }

    private function generateFile($templateToUse, $whereToSave, $howToSave, $sufix = '', $extension = 'php', $prefix = '')
    {
        $template = File::get(base_path() . "/templates/$templateToUse.txt");
        $compiledModel = str_replace('{name}', $this->lowerName, $template);
        $compiledModel = str_replace('{snakeName}', $this->snakeName, $compiledModel);
        $compiledModel = str_replace('{kebabName}', $this->kebabName, $compiledModel);
        $compiledModel = str_replace('{kebabPluralName}', $this->kebabPluralName, $compiledModel);
        $compiledModel = str_replace('{lowerName}', $this->lowerName, $compiledModel);
        $compiledModel = str_replace('{pluralName}', $this->pluralName, $compiledModel);
        $compiledModel = str_replace('{pluralPascalName}', $this->pluralPascalName, $compiledModel);
        $compiledModel = str_replace('{snakePluralName}', $this->snakePluralName, $compiledModel);
        $compiledModel = str_replace('{pascalName}', $this->pascalName, $compiledModel);
        if (!is_null($this->columnsInformation)) {
            $compiledModel = str_replace('{fillable}', $this->getFillables(), $compiledModel);
            $compiledModel = str_replace('{casts}', $this->getCasts(), $compiledModel);
            $compiledModel = str_replace('{relationships}', $this->getRelationships(), $compiledModel);
            $compiledModel = str_replace('{rules}', $this->getRules(), $compiledModel);
            $compiledModel = str_replace('{vueFormFields}', $this->getVueFormFields(), $compiledModel);
            $compiledModel = str_replace('{vueFormFieldsJs}', $this->getVueFormFieldsJs(), $compiledModel);
            $compiledModel = str_replace('{vueTableColumns}', $this->getVueTableColumns(), $compiledModel);
            $compiledModel = str_replace('{transformerFields}', $this->getTransformerFields(), $compiledModel);
        }
        $nameToSave = $prefix . $howToSave . $sufix;
        File::put("$whereToSave/$nameToSave.$extension", $compiledModel);
    }

    private function getTableColumns()
    {
        $this->columnsInformation = DB::select(DB::raw("SHOW COLUMNS FROM $this->snakePluralName"));
    }

    private function hasTable()
    {
        return Schema::hasTable($this->snakePluralName);
    }

    private function getFillables()
    {
        $results = '';
        foreach ($this->columnsInformation as $column) {
            if (in_array($column->Field, $this->unnecessaryColumns)) {
                continue;
            }
            $results .= PHP_EOL . "\t\t'{$column->Field}',";
        }

        return $results;
    }

    private function getRules()
    {
        $results = '';
        foreach ($this->columnsInformation as $column) {
            if (in_array($column->Field, $this->unnecessaryColumns)) {
                continue;
            }
            $rule = $this->listTheRulesFrom($column);
            $results .= PHP_EOL . "\t\t\t'{$column->Field}' => '$rule',";
        }

        return $results;
    }

    private function listTheRulesFrom($column)
    {
        $rules = [];

        if ($column->Null == 'NO') {
            array_push($rules, 'required');
        }

        if (strpos($column->Type, 'int(') !== false) {
            array_push($rules, 'numeric');
        }

        if (strpos($column->Type, 'date') !== false) {
            array_push($rules, 'date');
        }

        return implode('|', $rules);
    }

    private function getVueFormFields()
    {
        $fields = '';
        foreach ($this->columnsInformation as $column) {
            if (in_array($column->Field, $this->unnecessaryColumns)) {
                continue;
            }
            $titledField = title_case($column->Field);
            $field = <<<EOF
                                <form-group :form="form" field="{$column->Field}">
                                    <input-label for="{$column->Field}">{$titledField}: </input-label>
                                    <input-text v-model="form.{$column->Field}" id="{$column->Field}" name="{$column->Field}"/>
                                </form-group>                             
EOF;
            $fields .= $field . PHP_EOL;
        }

        return $fields;
    }

    private function getVueFormFieldsJs()
    {
        $results = PHP_EOL . "\t\t\tid: $this->snakeName ? $this->snakeName.id : null,";
        foreach ($this->columnsInformation as $column) {
            if (in_array($column->Field, $this->unnecessaryColumns)) {
                continue;
            }
            $results .= PHP_EOL . "\t\t\t$column->Field: $this->snakeName ? $this->snakeName.$column->Field : null,";
        }

        return $results;
    }

    private function getVueTableColumns()
    {
        $fields = [];
        array_push($fields, "'id'");
        foreach ($this->columnsInformation as $column) {
            if (in_array($column->Field, $this->unnecessaryColumns)) {
                continue;
            }
            array_push($fields, "'$column->Field'");
        }

        return implode(', ', $fields);
    }

    private function getCasts()
    {
        return '';
    }

    private function getRelationships()
    {
        return '';
    }

    private function getTransformerFields()
    {
        $results = '';
        foreach ($this->columnsInformation as $column) {
            if (in_array($column->Field, $this->unnecessaryColumns)) {
                continue;
            }
            $rule = $this->listTheRulesFrom($column);
            $results .= PHP_EOL . "\t\t\t'$column->Field' => \$model->$column->Field,";
        }

        return $results;
    }

    private function larouteGenerate()
    {
        Artisan::call('laroute:generate');
        $this->info('Laroute Generated!');
    }

    private function updateRepositoryServiceProvider()
    {
        $repositoryServiceProvider = base_path() . '/app/Providers/RepositoryServiceProvider.php';
        $contents = file($repositoryServiceProvider);
        $template = "\t\t\$this->app->bind(\\App\\Repositories\\{$this->pascalName}Services::class, \\App\\Repositories\\{$this->pascalName}RepositoryEloquent::class);\n";
        $newFile = '';
        $firstBindFounded = false;
        $templateAdded = false;

        foreach ($contents as $line) {
            if (!$firstBindFounded && strpos($line, 'app->bind(') !== false) {
                $firstBindFounded = true;
            }

            if (!$templateAdded) {
                if ($firstBindFounded && strpos($line, 'app->bind(') == false) {
                    $newFile .= $template;
                    $templateAdded = true;
                }
            }

            $newFile .= $line;
        }


        File::put($repositoryServiceProvider, $newFile);
        $this->info('Services Service Provider Updated!');
    }

    private function updateBootstrapJs()
    {
        $bootstrapJs = base_path() . '/resources/assets/js/components/bootstrap.js';
        $template = "\nVue.component('{$this->kebabName}-list', require('./{$this->kebabName}/{$this->kebabName}-list.vue'));\nVue.component('{$this->kebabName}-form', require('./{$this->kebabName}/{$this->kebabName}-form.vue'));\n";
        File::append($bootstrapJs, $template);
        $this->info('BootstrapJS Updated!');
    }

    private function npmRunDev()
    {
        $this->comment('Running npm run dev.. this could take a while!');
        shell_exec('npm run dev');
        $this->info('Js Compiled');
    }


}
