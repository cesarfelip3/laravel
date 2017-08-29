<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class ScaffoldingRollback extends Command
{
    protected $name;
    protected $object;
    protected $lowerName;
    protected $pluralName;
    protected $pluralPascalName;
    protected $snakePluralName;
    protected $pascalName;
    protected $kebabName;
    protected $snakeName;
    protected $signature   = 'scaffolding:rollback {name} {--object=?}';
    protected $description = 'Delete all files created by the scaffolding';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->name             = $this->argument('name');
        $this->object           = $this->option('object');
        $this->lowerName        = strtolower($this->name);       // foobar
        $this->pluralName       = str_plural($this->name);       // foobars
        $this->pluralPascalName = $this->pluralName;             // Foobars
        $this->pascalName       = $this->name;                   // FooBar
        $this->kebabName        = kebab_case($this->name);       // foo-bar
        $this->snakeName        = snake_case($this->name);       // foo_bar
        $this->snakePluralName  = snake_case($this->pluralName); // foo_bar

        switch ($this->object) {
            case 'migration':
                $this->migration();
                break;
            
            default:
                $this->model();
                $this->apiController();
                $this->controller();
                $this->apiRoute();
                $this->route();
                $this->createRequest();
                $this->updateRequest();
                $this->presenter();
                $this->transformer();
                $this->repository();
                $this->repositoryEloquent();
                $this->makeVueDirectory();
                $this->vueForm();
                $this->vueList();
                $this->makeViewDirectory();
                $this->view();
                break;
        }
    }

    private function model()
    {
        $this->deleteFile('app/Models', $this->pascalName);
        $this->info('Model deleted!');
    }

    private function apiController()
    {
        $this->deleteFile('app/Http/Controllers/Api', $this->pluralPascalName, 'Controller');
        $this->info('Api Controller deleted!');
    }

    private function controller()
    {
        $this->deleteFile('app/Http/Controllers', $this->pluralPascalName, 'Controller');
        $this->info('Controller deleted!');
    }

    private function apiRoute()
    {
        $this->deleteFile('app/Routes/api', $this->kebabName);
        $this->info('Api Route deleted!');
    }

    private function route()
    {
        $this->deleteFile('app/Routes/auth', $this->kebabName);
        $this->info('Route deleted!');
    }

    private function createRequest()
    {
        $this->deleteFile('app/Http/Requests', $this->pascalName, 'CreateRequest');
        $this->info('Create Request deleted!');
    }

    private function updateRequest()
    {
        $this->deleteFile('app/Http/Requests', $this->pascalName, 'UpdateRequest');
        $this->info('Update Request deleted!');
    }

    private function presenter()
    {
        $this->deleteFile('app/Presenters', $this->pascalName, 'Presenter');
        $this->info('Presenter deleted!');
    }

    private function transformer()
    {
        $this->deleteFile('app/Transformers', $this->pascalName, 'Transformer');
        $this->info('Transformer deleted!');
    }

    private function repository()
    {
        $this->deleteFile('app/Repositories', $this->pascalName, 'Services');
        $this->info('Services deleted!');
    }

    private function repositoryEloquent()
    {
        $this->deleteFile('app/Repositories', $this->pascalName, 'RepositoryEloquent');
        $this->info('Services Eloquent deleted!');
    }

    private function makeVueDirectory()
    {
        $this->deleteDirectory('resources/assets/js/components', $this->kebabName);
        $this->info('Vue Directory deleted!');
    }

    private function vueForm()
    {
        $this->deleteFile("resources/assets/js/components/$this->kebabName", $this->kebabName, '-form', 'vue');
        $this->info('Vue Form deleted!');
    }

    private function vueList()
    {
        $this->deleteFile("resources/assets/js/components/$this->kebabName", $this->kebabName, '-list', 'vue');
        $this->info('Vue List deleted!');
    }

    private function makeViewDirectory()
    {
        $this->deleteDirectory('resources/views', $this->snakeName);
        $this->info('View Directory deleted!');
    }

    private function view()
    {
        $this->deleteFile("resources/views/$this->snakeName", 'index.blade');
        $this->info('View deleted!');
    }

    private function migration()
    {
        $this->deleteFile("database/migrations/", $this->snakePluralName, '_table', 'php', '');
        $this->info('Migration deleted!');
    }

    private function deleteDirectory($path, $name)
    {
        File::deleteDirectory(base_path() . "/$path/$name");
    }

    private function deleteFile($whereToSave, $howToSave, $sufix = '', $extension = 'php', $prefix = '')
    {
        $nameToSave    = $prefix . $howToSave . $sufix;
        File::delete("$whereToSave/$nameToSave.$extension");
    }
}
