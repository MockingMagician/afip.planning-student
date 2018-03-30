<?php use Afip\Planning\Models\Student;

require_once __DIR__ . '/../principal-layout-top.php'; ?>

    <div class="uk-container-expand uk-padding-small">
        <h2 class="uk-heading-line uk-text-center"><?php echo $title ?></h2>
        <table id="table-list" class="display uk-table uk-table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Nationalité</th>
                <th>Formation</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /** @var Student $student */
            foreach ($students as $student) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($student->getLastName()) ?></td>
                    <td><?php echo htmlspecialchars($student->getFirstName()) ?></td>
                    <td><?php echo htmlspecialchars($student->nationality) ?></td>
                    <td><?php echo htmlspecialchars($student->traineeship) ?></td>
                    <td style="text-align: center;">
                        <a href="/student/edit/<?php echo $student->getId() ?>"
                           class="uk-button uk-button-primary"
                        >
                            Modifier
                        </a>
                        <a href="/student/delete/<?php echo $student->getId() ?>"
                           class="uk-button uk-button-danger"
                        >
                            Supprimer
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