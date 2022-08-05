<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\Project_User;

    /**
     * Classe herdada de Controller responsável por controlar as ações do Projeto com os Usuário (N:N)
     * @author Mário Guilherme
     */
    class ProjectUserController extends Controller {
        private Project_User $projectUserModel;

        /**
         * Construtor da classe que realiza a instanciação do modelo.
         * @return void
         */
        public function __construct() {
            if (!isset($this->projectUserModel)) $this->projectUserModel = new Project_User;
        }

        /**
         * Método responsável por verificar se existem projetos relacionado ao ID de um Usuário.
         * @param int $id_user ID do Usuário
         * @return bool True se existir, false se não.
         */
        public function userHasProjectsLinked(int $id_user) : bool {
            return $this->projectUserModel::select(where: "id_user = ?", fields: "id_user", params: [$id_user])->rowCount() > 0;
        }

        /**
         * Método responsável por retornar todos os usuários de um projeto.
         * @param int $id_project ID do projeto
         * @return array Dados dos usuários.
         */
        public function getAllUsersByProject(int $id_project) : array {
            return (array) $this->projectUserModel::select(
                join: "INNER JOIN users ON projects_users.id_user = users.id_user",
                where: "id_project = ?",
                fields: "users.id_user, name",
                params: [$id_project]
            )->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Método responsável por retornar os projetos de um usuário.
         * @param int $id_user ID do usuário
         * @return array Array com os Projetos
         */
        public function getAllProjectsByUser(int $id_user) : array {
            return (array) $this->projectUserModel::select(
                join: "pu INNER JOIN projects p ON pu.id_project = p.id_project",
                where: "pu.id_user = ?",
                fields: "p.id_project, title, description",
                params: [$id_user]
            )->fetchAll(PDO::FETCH_ASSOC);
        }
    }