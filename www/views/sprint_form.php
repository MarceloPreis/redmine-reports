<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Sprint</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Adicionar Sprint</h1>
        <form action="/add-sprint" method="post">
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="number" class="form-control" id="id" name="id" value="<?= $this->sprint->id ?>" required>
            </div>
            <div class="form-group">
                <label for="desc">Description:</label>
                <input type="text" class="form-control" id="desc" name="desc" value="<?= $this->sprint->desc ?>" required>
            </div>
            <div class="form-group">
                <label for="start">Start Date:</label>
                <input type="date" class="form-control" id="start" name="start" value="<?= $this->sprint->start ?>" required>
            </div>
            <div class="form-group">
                <label for="end">End Date:</label>
                <input type="date" class="form-control" id="end" name="end" value="<?= $this->sprint->end ?>" required>
            </div>
            <input type="hidden" name="project_id" value="<?= _get('project_id', $this->sprint->project_id) ?>" required>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
