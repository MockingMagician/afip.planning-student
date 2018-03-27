<?php use Afip\Planning\Models\Nationality;

require_once __DIR__ . '/../principal-layout-top.php'; ?>

    <div class="uk-container-expand uk-padding-small">
        <h2 class="uk-heading-line uk-text-center"><?php echo $title ?></h2>
        <table id="table-list" class="display uk-table uk-table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Etiquette</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /** @var Nationality $room */
            foreach ($nationalities as $nationality) {
            ?>
                <tr>
                    <td><?php echo $nationality->getLabel() ?></td>
                    <td style="text-align: center;">
                        <a href="/rooms/edit/<?php echo $nationality->getId() ?>"
                           class="uk-button uk-button-primary"
                        >
                            Modifier
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <th>Etiquette</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#table-list').DataTable();
        } );
    </script>

<?php require_once __DIR__ . '/../principal-layout-bottom.php'; ?>