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

                <legend class="uk-legend">Professeur</legend>

                <div class="uk-margin">
                    <input class="uk-input"
                           type="text"
                           placeholder="Nom"
                           name="teacher[lastName]"
                        <?php
                        /** @var Teacher $teacher */
                        if (isset($teacher)) {
                            echo 'value="'.htmlspecialchars($teacher->getLastName()).'"';
                        }
                        ?>
                    >
                </div>

                <div class="uk-margin">
                    <input class="uk-input"
                           type="text"
                           placeholder="Prénom"
                           name="teacher[firstName]"
                        <?php
                        /** @var Teacher $teacher */
                        if (isset($teacher)) {
                            echo 'value="'.htmlspecialchars($teacher->getFirstName()).'"';
                        }
                        ?>
                    >
                </div>

                <div class="uk-margin">
                    <div class="uk-form-label">Salle</div>
                    <select class="uk-select"
                            name="teacher[roomId]"
                    >
                        <?php
                        /** @var Room $room */
                        foreach ($rooms as $room) {
                            ?>
                            <option value="<?php echo $room->getId() ?>"
                                <?php
                                /** @var Teacher $teacher */
                                if (isset($teacher)) {
                                    if ($teacher->getRoomId() === $room->getId()) {
                                        echo 'selected';
                                    }
                                }
                                ?>
                            >
                                <?php echo htmlspecialchars($room->getLabel()) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="uk-margin">
                    <div class="uk-form-label">Compétences <q>(ctrl + clic pour une sélection multiple)</q></div>
                    <select class="uk-select uk-height-small"
                            name="TraineeshipTeacher[]"
                            multiple
                    >
                        <?php
                        /** @var Traineeship $traineeship */
                        foreach ($traineeships as $traineeship) {
                            ?>
                            <option value="<?php echo $traineeship->getId() ?>"
                                <?php
                                /** @var TraineeshipTeacher $traineeshipTeacher */
                                if (isset($teacher)) {
                                    foreach ($traineeshipsTeachers as $traineeshipTeacher) {
                                        if ($traineeshipTeacher->getTraineeshipId() === $traineeship->getId()) {
                                            echo 'selected';
                                        }
                                    }
                                }
                                ?>
                            >
                                <?php echo htmlspecialchars($traineeship->getLabel()) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>



                <div class="uk-margin uk-align-right">
                    <button class="uk-button uk-button-danger uk-button-large"
                            type="submit"
                    >
                        <?php
                        if (isset($teacher)) {
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