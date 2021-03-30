<h2>Cows</h2>


<a href='cows/create' class='btn btn-primary '    role='button'>New Cow</a>
<hr/>

<?php if ( ! empty($rows) && is_array($rows) && count($rows) ) : ?>

    <?php $headers = array_keys($rows[0]); ?>

    <table class="table">
        <thead>
        <tr>
        <?php foreach ($headers as $name) : ?>
            <th><?= $name ?></th>
        <?php endforeach; ?>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row) : ?>
            <tr>
                <?php foreach ($headers as $key) : ?>
                    <td><?= $row[$key] ?></td>
                <?php endforeach; ?>
                <td>
                    <a href="cows/update/<?= $row['id'] ?>">Edit</a> |
                    <a href="cows/delete/<?= $row['id'] ?>" onclick="return confirm('Delete this item?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else : ?>

    <div class='alert alert-warning '>
	Unable to find any records.
	<a href='#' class='close'>&times;</a>
</div>

<?php endif; ?>
