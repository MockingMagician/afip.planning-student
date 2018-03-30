<?php
require_once __DIR__ . '/../principal-layout-top.php';
?>

    <div class="uk-container-expand uk-padding-small">
        <div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid>
            <div>
                <a href="/list/students" style="text-decoration: none;">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h1 class="uk-text-uppercase uk-heading-divider">
                            Etudiants
                        </h1>
                        <span class="uk-text-primary uk-text-large">
                            <?php echo $studentsCount ?>
                        </span>
                    </div>
                </a>
            </div>
            <div>
                <a href="/list/rooms" style="text-decoration: none;">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h1 class="uk-text-uppercase uk-heading-divider">
                            Salles
                        </h1>
                        <span class="uk-text-primary uk-text-large">
                            <?php echo $roomsCount ?>
                        </span>
                    </div>
                </a>
            </div>
            <div>
                <a href="/list/teachers" style="text-decoration: none;">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h1 class="uk-text-uppercase uk-heading-divider">
                            Professeurs
                        </h1>
                        <span class="uk-text-primary uk-text-large">
                            <?php echo $teachersCount ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

<?php
require_once __DIR__ . '/../principal-layout-bottom.php';
?>