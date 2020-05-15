<?php
class ExemploController //This is a sample laravel Controller
{
    /**
     * @OA\GET(
     *     path="/api/exemplo",
     *     tags={"Seção"},
     *     summary="Função vazia apenas para exemplificar",
     *     description="Um exemplo para testar a API",
     *     operationId="funcaoExemploDoc",
     *     @OA\Response(
     *         response="default",
     *         description="Sucesso"
     *     )
     * )
     */
    public function funcaoExemploDoc()
    {
    }
}
