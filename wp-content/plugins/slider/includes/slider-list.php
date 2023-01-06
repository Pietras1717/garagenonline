<?php
global $wpdb;
$getSlides = $wpdb->get_results("SELECT * from " . returnTableName('slider_tables') . " ORDER BY id DESC", ARRAY_A);
?>
<div class="plugin-wrapper">
    <div class="plugin-heading">
        <h1>Slider - List of all slides</h1>
    </div>
    <div class="plugin-body">
        <div class="table">
            <table id="sliderList" class="">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Image</th>
                        <th>Heading text</th>
                        <th>Content text</th>
                        <th>Active</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getSlides as $row) : ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><img src="<?php echo $row['imagePath'] ?>" alt="" width="160px" height="90px"></td>
                            <td><?php echo $row['heading'] ?></td>
                            <td><?php echo $row['description'] ?></td>
                            <td><?php echo $row['isactive'] == "1" ? "tak" : "nie" ?></td>
                            <td><?php echo $row['insertedAt'] ?></td>
                            <td>
                                <div class="flexrow">
                                    <a class="plugin_save_changes" href="<?php echo admin_url("admin.php?page=edit-slide&slideid=" . $row['id']) ?>">Edytuj</a>
                                    <button class="plugin_save_change deleteSlide">Usuń</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$wpdb->flush();
?>