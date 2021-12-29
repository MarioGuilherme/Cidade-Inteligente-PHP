<?php

    declare(strict_types=1);

    namespace App\Controllers;

    use PDO;
    use App\Core\Controller;
    use App\Models\Project_User;

    /**
     * Classe herdada de Controller responsável por controlar as ações do Projecto com os Usuário (N:N)
     *
     * @author Mário Guilherme
     */
    class ProjectUserController extends Controller {
        private Project_User $projectUserModel;

        /**
         * Método responsável de carregar a configuração do
         * banco de dados e instanciar o modelo de usuario
         * @return void
         */
        private function GetModel() : void {
            require __DIR__ . "/../Database/Connection.php";
            $this->projectUserModel = new Project_User();
        }

        /**
         * Método responsável por retornar os usuários de um projeto
         * @param int $id_user
         * @return array Usuários
         */
        public function GetUsersByProject(int $id_project) : array {
            $this->GetModel();
            return $this->projectUserModel->Select("INNER JOIN users ON projects_users.id_user = users.id_user", "id_project = ?", "", "", "name", [$id_project])->fetchAll(PDO::FETCH_ASSOC);
        }
    }