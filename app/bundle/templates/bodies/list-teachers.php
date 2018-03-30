<?php use Afip\Planning\Models\Teacher;

require_once __DIR__ . '/../principal-layout-top.php'; ?>

    <div class="uk-container-expand uk-padding-small">
        <h2 class="uk-heading-line uk-text-center"><?php echo $title ?></h2>
        <table id="table-list" class="display uk-table uk-table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Salle affecté</th>
                <th>Capacités</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /** @var Teacher $teacher */
            foreach ($teachers as $teacher) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($teacher->getLastName()) ?></td>
                    <td><?php echo htmlspecialchars($teacher->getFirstName()) ?></td>
                    <td><?php echo htmlspecialchars($teacher->room) ?></td>
                    <td>
                        <ul>
                            <?php foreach ($teacher->traineeships as $traineeship) { ?>
                            <li><?php echo htmlspecialchars($traineeship->getTraineeshipLabel()) ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                    <td style="text-align: center;">
                        <a href="/teacher/edit/<?php echo $teacher->getId() ?>"
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
                <th>Nom</th>
                <th>Prénom</th>
                <th>Nationalité</th>
                <th>Formation</th>
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