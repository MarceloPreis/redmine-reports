
<div class="container mt-5">
    <h1 class="mb-4">Projetos</h1>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Sprints</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $projects = [
                [
                    "id" => 8,
                    "name" => "Euler - Feiras",
                    "identifier" => "sitex",
                    "description" => "Sistema para uso nas feiras de Matemática e Ciências que atenda às seguintes funcionalidades: credenciamento, inscrição e submissão, cadastro dos avaliadores, formação dos grupos de avaliação, distribuição dos trabalhos para os avaliadores, registro das avaliações, geração e emissão de certificados (digitais). Deve gerar os relatórios (planilha) de dados da inscrição e listagens.",
                    "status" => 1,
                    "is_public" => false,
                    "inherit_members" => false,
                    "created_on" => "2024-03-22T19:23:14Z",
                    "updated_on" => "2024-09-19T22:36:47Z"
                ]
            ];

            foreach ($projects as $project) {
                echo "<tr>";
                echo "<td>{$project['id']}</td>";
                echo "<td>{$project['name']}</td>";
                echo "<td>{$project['status']}</td>";
                echo "<td></td>";
                echo "<td><a href='project/" . $project['id'] . "'>📝</a> <a href='dashboard?project_id=" . $project['id'] . "'>📈</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>