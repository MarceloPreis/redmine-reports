<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../views/css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <div>⬅️ <a href="/">Projetos</a></div>
        <br />
        <h2>📇 <?= $this->project->name ?></h2>
        <p><?= $this->project->description ?></p>
        
        <h2>📈 Dashboard</h2>
        <form class="search-form" action="dashboard" method="post">
             <select id="sprint" name="sprint" title="sprints" onchange="this.form.submit()">
            <?php
                foreach ($this->project->sprints as $index => $sprint) {
                    $description = $sprint->desc . ' (' . $sprint->start . ' a ' . $sprint->end . ')';
                    echo "<option value='$sprint->id' " . ($sprint->id == $this->sprint->id ? 'selected' : '')  . ">$description</option>";
                }
            ?>
            </select>            
            <input type="hidden" name="project_id" value="<?= _get('project_id') ?>">
            <input type="submit" value="Buscar">
        </form>

        <?php 
            if (!$this->sprint->issues) {
                echo '<div class="alert alert-info" role="alert">Nenhuma tarefa foi encontrada para essa sprint!</div>';
                return;
            }
        ?>
        
        <div class="results">
            <div class="result-item half">
                <h4>Burndown</h4>
                <p>Gráfico de burndown.</p>
                <canvas id="burndownChart"></canvas>
            </div>
            <div class="result-item half">
                <h4>Burnup</h4>
                <p>Gráfico de burnup</p>
                <canvas id="burnupChart"></canvas>
            </div>
        </div>
        <div class="results">
            <div class="result-item full">
                <h4>Backlog</h4>
                <p>Lista de Tarefas da Sprint. Total: <?= count($this->sprint->issues) ?></p>

                <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Descrição</th>
                        <th>Autor</th>
                        <th>Responsável</th>
                        <th>Prioridade</th>
                        <th>Storie Points</th>
                        <th>Vencimento</th>
                        <th>Conclusao</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->sprint->issues as $issue) {
                        echo "<tr>";
                        echo "<td>{$issue->subject}</td>";
                        echo "<td>{$issue->getAuthorName()}</td>";
                        echo "<td>{$issue->getResponsibleName()}</td>";
                        echo "<td>{$issue->priority->name}</td>";
                        echo "<td>";
                        foreach ($issue->custom_fields as $field) {
                            if ($field->name === 'Storie Points') {
                                echo $field->value;
                            }
                        }
                        echo "</td>";
                        echo "<td>{$issue->getDueDate()->format('d/m/Y')}</td>";
                        echo "<td>{$issue->getClosedOn()->format('d/m/Y')}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>


    <script>
        let ctx = document.getElementById('burndownChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: <?= json_encode($this->sprint->burndownData()) ?>,
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Remaining Issues'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        ctx = document.getElementById('burnupChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: <?= json_encode($this->sprint->burnupData()) ?>,
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Remaining Issues'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
