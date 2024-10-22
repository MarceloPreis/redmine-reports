
<script>
    function deleteSprint(sprintId) {
        post(`api/sprint/${sprintId}/delete`, {}, () => window.location.reload());
    }
</script>
<div class="container"> 
    <div>⬅️ <a href="/">Projetos</a></div>
    <br />
    <h2>📇 <?= $this->project->name ?></h2>
    <p><?= $this->project->description ?></p>

    <div class="results">
        <div class="result-item full">
            <h4 class="d-flex">Sprints <a href="/sprint?project_id=<?= $this->project->id ?>" class="btn btn-light ml-auto">➕ Sprint</a></h4>
            <p>Lista de Sprints</p>

            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Inicio</th>
                        <th>Fim</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($this->project->sprints as $sprint) {
                            echo "<tr>";
                            echo "<td>{$sprint->id}</td>";
                            echo "<td>{$sprint->desc}</td>";
                            echo "<td>{$sprint->start}</td>";
                            echo "<td>{$sprint->end}</td>";
                            echo "<td><a href='/sprint/{$sprint->id}'>📝</a> <a href='#' onclick='deleteSprint($sprint->id)')>❌</a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
