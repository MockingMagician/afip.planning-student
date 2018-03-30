<?php

use Afip\Planning\Models\Nationality;
use Afip\Planning\Models\Room;
use Afip\Planning\Models\Student;
use Afip\Planning\Models\StudentTeacher;
use Afip\Planning\Models\Teacher;
use Afip\Planning\Models\TeacherTraineeshipLabel;
use Afip\Planning\Models\Traineeship;
use Afip\Planning\Models\TraineeshipTeacher;

require_once __DIR__ . '/../principal-layout-top.php';

?>
    <div class="uk-container-expand uk-padding-small">
        <h2 class="uk-heading-line uk-text-center"><?php echo $title ?></h2>
        <form method="post">
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Salle</legend>

                <div class="uk-margin">
                    <input class="uk-input"
                           type="text"
                           placeholder="Etiquette"
                           name="room[label]"
                        <?php
                        /** @var Room $label */
                        if (isset($room)) {
                            echo 'value="'.htmlspecialchars($room->getLabel()).'"';
                        }
                        ?>
                    >
                </div>

                <div class="uk-margin uk-align-right">
                    <button class="uk-button uk-button-danger uk-button-large"
                            type="submit"
                    >
                        <?php
                        if (isset($room)) {
                            echo 'Modifier';
                        } else {
                            echo 'Créer';
                        }
                        ?>
                    </button>
                </div>
            </fieldset>
        </form>
    </div>

<?php require_once __DIR__ . '/../principal-layout-bottom.php'; ?>