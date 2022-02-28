<?php

namespace Twentyonetf\AjaxTableCard\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateAjaxCard extends Command
{
    protected $files;

    protected $signature = 'card:create {className?}';

    protected $description = 'Create a new Laravel Nova Ajax Table Card.';

    protected $className;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $this->className = $this->getClassNameArgument();
        $path = $this->getPath();
        $this->files->put($path, $this->buildClass());
        $this->info('Successfully created Card at ' . $path);
    }

    /**
     * Gets the class name argument - if missing, asks the user to enter it.
     *
     * @return string
     **/
    public function getClassNameArgument()
    {
        if (!$this->argument('className')) {
            return $this->ask('Please enter a name for the Card class');
        }
        return $this->argument('className');
    }

    /**
     * Creates the directory for the template files and returns the file path.
     *
     * @return string
     **/
    protected function getPath()
    {
        return $this->makeDirectory(
            app_path('Nova/Cards/' . $this->className . '.php')
        );
    }

    /**
     * Creates the directory for the template file.
     *
     * @param string $path Expected path of the Template file.
     * @return string
     **/
    protected function makeDirectory($path)
    {
        $directory = dirname($path);
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true, true);
        }
        return $path;
    }

    /**
     * Create the template file content.
     *
     * @return string
     */
    protected function buildClass()
    {
        $replace = [
            ':className' => $this->className,
            ':title' => Str::headline($this->className),
        ];

        $templateFilePath = '/../Stubs/AjaxCardTemplate.php';

        $template = $this->files->get($templateFilePath);

        foreach ($replace as $key => $value) {
            $template = str_replace($key, $value, $template);
        }

        return $template;
    }

}
