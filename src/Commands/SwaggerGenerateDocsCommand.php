<?php


namespace Quattror\Swagger\Commands;

use File;
use Illuminate\Console\Command;
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
        return '<br><p>Informações da Aplicação:</p>' .
            '<ul>' .
            '<li>Ambiente atual: <b>' . strtoupper(env('APP_ENV', 'local')) . '</b></li>' .
            '<li>Banco de dados (' . env('DB_CONNECTION', 'exemplo') . '): <b>' . env('DB_DATABASE', 'DBEXE') . '</b></li>' .
            '<li>URL da API do Portal de Sistemas: <a href=\'' . env('PORTAL_API_URL', 'https://www.exemplo.com.br/api/exemplo') . '\'>' . env('PORTAL_API_URL', 'https://www.exemplo.com.br/api/exemplo') .'</a></li>'.
            '<li>Portal Token Key: <b>' . env('PORTAL_API_TOKEN_KEY', 'exemplotokenkey') . '</b></li>'.
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
