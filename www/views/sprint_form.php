<script>
    function addIssue(checkbox, rowId) {
        var hiddenInput = document.getElementById('issuesHidden');
        var currentValue = hiddenInput.value.split(',');

        if (checkbox.checked) {
            if (!currentValue.includes(rowId)) {
                currentValue.push(rowId);
            }
        } else {
            var index = currentValue.indexOf(rowId);
            if (index !== -1) {
                currentValue.splice(index, 1);
            }
        }

        hiddenInput.value = currentValue.filter(Boolean).join(',');
    }
</script>
<div class="container">
    <div>⬅️ <a href="/project/<?= $this->sprint->project_id; ?>">Projeto</a></div>
    <h2>Adicionar Sprint</h2>
    
    <form action="/api/sprint" method="post">
        <div class="row">
            <div class="form-group col-md-2">
                <label for="id">ID:</label>
                <input type="number" class="form-control" id="id" name="id" value="<?= $this->sprint->id ?>" required readonly>
            </div>
            <div class="form-group col-md-10">
                <label for="desc">Description:</label>
                <input type="text" class="form-control" id="desc" name="desc" value="<?= $this->sprint->desc ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="start">Start Date:</label>
                <input type="date" class="form-control" id="start" name="start" value="<?= $this->sprint->start ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="end">End Date:</label>
                <input type="date" class="form-control" id="end" name="end" value="<?= $this->sprint->end ?>" required>
            </div>
        </div>
        <div style="max-height: 150px; overflow-y: scroll;">    
            <table class="table table-bordered" style="font-size: 10px;">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->sprint->issues as $issue) {
                        echo "<tr>";
                        if ($this->sprint->id)
                            echo '<td></td>';
                        else 
                            echo "<td><input type='checkbox' onclick='addIssue(this, $issue->id)' ></td>";

                        echo "<td>{$issue->id}</td>";
                        echo "<td>{$issue->subject}</td>";
                        echo "<tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>  

        <br />

        <div class="row">
            <div class="form-group col-md-2">
                <input type="hidden" name="project_id" value="<?= _get('project_id', $this->sprint->project_id) ?>" required>
                <input type="hidden" name="issue_ids" id="issuesHidden" value="<?= implode(',', $this->sprint->getIssuesId()) ?>" required>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>

</div>