<?php


namespace Quattror\Swagger\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Quattror\Swagger\SwaggerGenerator;

class SwaggerGenerateDocsCommand extends Command
{
    protected $name = 'swagger:generate-docs';
    protected $description = 'Generates the swagger json file';

    public function handle()
    {
        try
        {
            //Test if swagger config file is present
            if (!File::exists(config_path('swagger.php'))) {
                $this->error('Swagger configuration file not found. Run swagger:init first');
                return;
            }

            $description = config('swagger.generator.constants.DESCRIPTION', '');
            if(config('swagger.generator.include_app_info', false))
                $description .= $this->getAppInfo();

            if(config('swagger.generator.include_git_info', false))
                $description .= $this->getGitInfo();

            SwaggerGenerator::generateDocs([ 'DESCRIPTION' => $description]);
            $this->info('Documentation generated');

        } catch(\Exception $e) {
            $this->error('An error ocurred during generation of the json documentation file: ' . $e);
        }
    }

    private function getAppInfo()
    {
        $env = strtoupper((string) config('swagger.controller.view_env', 'local'));
        $url = (string) config('swagger.generator.constants.SERVER_URL', '');

        return '<br><p>Informações da Aplicação:</p>' .
            '<ul>' .
            '<li>Ambiente atual: <b>' . $env . '</b></li>' .
            '<li>URL da API: <a href=\'' . $url . '\'>' . $url . '</a></li>' .
            '</ul>';
    }

    private function getGitInfo()
    {
        $gitRepoUrl = '';
        $gitBranch = '';
        $gitCommit = '';

        //Test if git is enabled
        if(File::exists(app_path('../.git')))
        {
            $outRepoUrl = [];
            exec('git config --get remote.origin.url',$outRepoUrl);
            $gitRepoUrl = $outRepoUrl[0];

            $outBranch = [];
            exec('git rev-parse --abbrev-ref HEAD',$outBranch);
            $gitBranch = $outBranch[0];

            $outCommit = [];
            exec('git log -1 --pretty="%h (por %cn em %ci)"',$outCommit);
            $gitCommit = $outCommit[0];
        }

        return '<p>Informações do Git:</p>' .
            '<ul>' .
            '<li>Repositório: <a href=\'' . $gitRepoUrl . '\'>' . $gitRepoUrl . '</a></li>' .
            '<li>Branch: <b> ' . strtoupper($gitBranch) . '</b></li>' .
            '<li>Commit: ' . $gitCommit . '</li>' .
            '</ul>';
    }
}
