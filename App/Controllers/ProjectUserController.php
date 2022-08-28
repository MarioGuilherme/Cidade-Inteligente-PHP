<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\{
        Project,
        User
    };
    use App\Database\Database;

    /**
     * Classe herdada de Controller responsável por controlar as ações do Projeto com os Usuário (N:N)
     * @author Mário Guilherme
     */
    class ProjectUserController extends Controller {
        /**
         * Modelo da entidade Usuário.
         * @var User
         */
        private User $userModel;

        /**
         * Modelo da entidade Projeto.
         * @var Project
         */
        private Project $projectModel;

        /**
         * Classe do banco de dados com acesso à tabela dos usuários.
         */
        public Database $projectUserDAO;

        /**
         * Construtor da classe responsável de instanciar o Modelo de Usuário e Projeto
         * juntamente com o objeto Database para abstração de dados da tabela dos projects_users (N:N).
         */
        public function __construct() {
            if (!isset($this->userModel)) $this->userModel = new User;
            if (!isset($this->projectModel)) $this->projectModel = new Project;
            if (!isset($this->projectUserDAO)) $this->projectUserDAO = new Database("projects_users");
        }

        /**
         * Método responsável por verificar se existem projetos relacionado ao ID de um Usuário.
         * @param int $id_user ID do Usuário
         * @return bool True se existir, false se não.
         */
        public function userHasProjectsLinked(int $id_user) : bool {
            return $this->projectUserDAO->select(where: "id_user = ?", fields: "id_user", params: [$id_user])->rowCount() > 0;
        }

        /**
         * Método responsável por retornar todos os usuários de um projeto.
         * @param int $id_project ID do projeto
         * @return array Dados dos usuários.
         */
        public function getAllUsersByProject(int $id_project) : array {
            return (array) $this->projectUserDAO->select(
                join: "INNER JOIN users ON projects_users.id_user = users.id_user",
                where: "id_project = ?",
                fields: "users.id_user, name",
                params: [$id_project]
            )->fetchAll(PDO::FETCH_CLASS, $this->userModel::class);
        }

        /**
         * Método responsável por retornar todos os projetos de um usuário.
         * @param int $id_user ID do usuário
         * @return array Array com os Projetos
         */
        public function getAllProjectsByUser(int $id_user) : array {
            return (array) $this->projectUserDAO->select(
                join: "pu INNER JOIN projects p ON pu.id_project = p.id_project",
                where: "pu.id_user = ?",
                fields: "p.id_project, title, description",
                params: [$id_user]
            )->fetchAll(PDO::FETCH_CLASS, $this->projectModel::class);
        }
    }