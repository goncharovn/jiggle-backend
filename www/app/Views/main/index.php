<p>Main page</p>

<?php foreach ($products as $val): ?>
    <h3><?php echo $val['title']; ?></h3>
    <p><?php echo $val['price']; ?></p>
<?php endforeach; ?>