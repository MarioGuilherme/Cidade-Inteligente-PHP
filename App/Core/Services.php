<?php

    declare(strict_types=1);

    namespace App\Core;

    use App\Utils\Response;

    /**
     * Classe encarregada de fazer o controle das requisições capturadas nos services.
     * @author Mário Guilherme
     */
    class Services {
        /**
         * Objeto Controller ao qual será manipulado durante a requisição.
         * @var object
         */
        private object $controller;

        /**
         * Entidade a qual será manipulada durante a requisição. Usada para concatenar a string nas chamadas dos métodos do Controller.
         * @var string
         */
        private string $entity;

        /**
         * Método HTTP recebido na requisição.
         * @var string
         */
        private string $method;

        /**
         * Payload recebido na requisição.
         * @var array|null
         */
        private array|null $payload;

        /**
         * Parâmetro de consulta ID recebido na URL da requisição.
         * @var string|null
         */
        private string|null $id;

        /**
         * Construtor da classe que realiza as configurações do Controller e configurações
         * de métodos, preparando-a para executar a requisição.
         * @param string $entity Entidade (Controller) a ser manipulada
         */
        public function __construct(string $controller) {
            $this->controller = new ("\App\Controllers\\{$controller}Controller");
            $this->entity = $controller;
            $this->method = $_SERVER["REQUEST_METHOD"];
            $this->payload = self::getPayload();
            $this->id = $_GET["id"] ?? null;
        }

        /**
         * Método responsável por capturar os dados enviados via Payload.
         * @return array|null Dados capturados
         */
        public static function getPayload() : array|null {
            return json_decode(file_get_contents("php://input"), true);
        }

        /**
         * Método responsável por rodar a requisição.
         * @return void
         */
        public function run() : void {
            switch ($this->method) {
                case "GET":
                    if (isset($this->id))
                        $this->controller->{"get{$this->entity}ByID"}((int) $this->id);

                    $this->controller->{"getAll{$this->entity}s"}(true);

                case "POST":
                    $this->controller->create($this->payload);

                case "PATCH":
                    $this->controller->update($this->payload);

                case "DELETE":
                    $this->controller->delete($this->id);

                default:
                    Response::returnResponse(Response::METHOD_NOT_ALLOWED, 405, "error");
            }
        }
    }