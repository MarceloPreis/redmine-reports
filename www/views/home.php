<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Projetos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Projetos</h1>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
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
                    ],
                    [
                        "id" => 15,
                        "name" => "Renda Agrícola",
                        "identifier" => "sitfe",
                        "description" => "Projeto de Pesquisa - Professor Paulo",
                        "status" => 1,
                        "is_public" => true,
                        "inherit_members" => false,
                        "created_on" => "2024-10-14T19:35:35Z",
                        "updated_on" => "2024-10-14T19:35:35Z"
                    ],
                    [
                        "id" => 14,
                        "name" => "RioAr - Dashboard - PROTALENT",
                        "identifier" => "sitfd",
                        "description" => "Desenvolvimento de software proprietário capaz de incorporar os parâmetros necessários para o monitoramento de misturas de concreto. Atualmente, são utilizados dashboard e software gratuito com interface não amigável. A empresa deseja a criação de um novo software, a fim de facilitar o gerenciamento dos processos.",
                        "status" => 1,
                        "is_public" => true,
                        "inherit_members" => false,
                        "created_on" => "2024-10-09T13:55:55Z",
                        "updated_on" => "2024-10-14T19:50:24Z"
                    ]
                ];

                foreach ($projects as $project) {
                    echo "<tr>";
                    echo "<td>{$project['id']}</td>";
                    echo "<td><a href='dashboard?project_id=" . $project['id'] . "'>{$project['name']}</a></td>";
                    echo "<td>{$project['status']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
