<?php

    declare(strict_types=1);

    namespace App\Core;

    class Page {
        /**
         * Título da página.
         * @var string
         */
        public string $title;

        /**
         * Link da navbar da página atual (usada para ser desativada via js).
         * @var string
         */
        public string $currentNavItem;

        /**
         * Array personalizado com os dados a ser renderizados no página.
         * @var array
         */
        public array $data;

        /**
         * Caminho do formulário que fica no modal.
         * @var string
         */
        public string $pathFormModal;

        /**
        * Nome dos arquivos css's da página
        * @var array
        */
        public array $css = [
            "font",
            "global"
        ];

        /**
        * Nome dos arquivos js's da página
        * @var array
        */
        public array $js;

        /**
         * Contrutor da classe que inicializa o objeto página recebendo todos os dados da mesma.
         * @param string $title Título da página
         * @param string $currentNavItem Link da navbar da página atual
         * @param array $data Array personalizado com os dados a ser renderizados no página
         * @param array $css Arquivos css's da página
         * @param array $js Arquivos js's da página
         * @param string $pathFormModal Caminho do formulário que fica no modal
         */
        public function __construct(string $title, string $currentNavItem, array $data, array $css, array $js, string $pathFormModal = "") {
            $this->title = $title;
            $this->currentNavItem = $currentNavItem;
            $this->data = $data;
            $this->pathFormModal = $pathFormModal;
            $this->css = array_merge($this->css, $css);
            $this->js = $js;
        }
    }