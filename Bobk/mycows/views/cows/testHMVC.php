<!--  Just a daft attempt to get cows controller/testHMVC to call airport controller's index 
method and display the index page.
It worked but a bit of a mess.
-->
<h2>Aiports</h2>

<h3> is this the right one</h3>
<a href='airports/create' class='btn btn-primary' role='button'>New Aiport</a>
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
                    <a href="airports/update/<?= $row['id'] ?>">Edit</a> |
                    <a href="airports/delete/<?= $row['id'] ?>" onclick="return confirm('Delete this item?');">Delete</a>
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
