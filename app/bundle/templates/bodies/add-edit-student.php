<?php

use Afip\Planning\Models\Nationality;
use Afip\Planning\Models\Student;
use Afip\Planning\Models\StudentTeacher;
use Afip\Planning\Models\Teacher;
use Afip\Planning\Models\Traineeship;

require_once __DIR__ . '/../principal-layout-top.php';

?>
    <div class="uk-container-expand uk-padding-small">
        <h2 class="uk-heading-line uk-text-center"><?php echo $title ?></h2>
        <form method="post">
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Etudiant</legend>

                <div class="uk-margin">
                    <input class="uk-input"
                           type="text"
                           placeholder="Nom"
                           name="student[lastName]"
                        <?php
                        /** @var Student $student */
                        if (isset($student)) {
                            echo 'value="'.htmlspecialchars($student->getLastName()).'"';
                        }
                        ?>
                    >
                </div>

                <div class="uk-margin">
                    <input class="uk-input"
                           type="text"
                           placeholder="Prénom"
                           name="student[firstName]"
                        <?php
                        /** @var Student $student */
                        if (isset($student)) {
                            echo 'value="'.htmlspecialchars($student->getFirstName()).'"';
                        }
                        ?>
                    >
                </div>

                <div class="uk-margin">
                    <div class="uk-form-label">Nationalité</div>
                    <select class="uk-select"
                            name="student[nationalityId]"
                    >
                        <?php
                        /** @var Nationality $nationality */
                        foreach ($nationalities as $nationality) {
                            ?>
                            <option value="<?php echo htmlspecialchars($nationality->getId()) ?>"
                                <?php
                                /** @var Student $student */
                                if (isset($student)) {
                                    if ($student->getNationalityId() === $nationality->getId()) {
                                        echo 'selected';
                                    }
                                }
                                ?>
                            >
                                <?php echo htmlspecialchars($nationality->getLabel()) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="uk-margin">
                    <div class="uk-form-label">Formation</div>
                    <select class="uk-select"
                            id="traineeshipIdSelector"
                            name="student[traineeshipId]"
                            onchange="switchTraineeship(this.value);"
                    >
                        <?php
                        /** @var Traineeship $traineeship */
                        foreach ($traineeships as $traineeship) {
                        ?>
                        <option value="<?php echo $traineeship->getId() ?>"
                            <?php
                            /** @var Student $student */
                            if (isset($student)) {
                                if ($student->getTraineeshipId() === $traineeship->getId()) {
                                    echo 'selected';
                                }
                            }
                            ?>
                        >
                            <?php echo htmlspecialchars($traineeship->getLabel()) ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <legend class="uk-legend">Professeurs et dates</legend>


                <?php
                /** @var Teacher $teacher */
                $i = 0;
                foreach ($teachers as $teacher) {
                    $studentTeacherKey = false;
                    if (isset($student)) {
                        /** @var StudentTeacher $studentTeacher */
                        foreach ($studentsTeachers as $key => $studentTeacher) {
                            if ($studentTeacher->getTeacherId() === $teacher->getId()) {
                                $studentTeacherKey = $key;
                            }
                        }
                    }
                ?>
                <div class="uk-margin traineeshipTeacher"
                    <?php
                    /** @var Traineeship $traineeship */
                    foreach ($teacher->traineeships as $traineeship) {
                        echo "data-traineeship-id-{$traineeship->getTraineeshipId()} ";
                    }
                    ?>
                >
                    <div class="uk-form-label">
                        <label>
                            <input class="uk-checkbox"
                                   type="checkbox"
                                   name="studentTeacher[<?php echo $i ?>][teacherId]"
                                   value="<?php echo $teacher->getId() ?>"
                                <?php
                                if (false !== $studentTeacherKey) {
                                    /** @var StudentTeacher[] $studentsTeachers */
                                    if ($studentsTeachers[$studentTeacherKey]->getTeacherId() === $teacher->getId()) {
                                        echo 'checked';
                                    }
                                }
                                ?>
                            >
                            <?php echo htmlspecialchars($teacher->getLastName()) ?>
                            <?php echo htmlspecialchars($teacher->getFirstName()) ?>, Salle
                            <?php echo htmlspecialchars($teacher->room) ?>
                        </label>
                        <div uk-grid>
                            <div class="uk-width-1-2">
                                <div class="uk-form-label">Début</div>
                                <input class="uk-input"
                                       type="date"
                                       name="studentTeacher[<?php echo $i ?>][startDate]"
                                    <?php
                                    if (false !== $studentTeacherKey) {
                                        /** @var StudentTeacher[] $studentsTeachers */
                                        if ($studentsTeachers[$studentTeacherKey]->getTeacherId() === $teacher->getId()) {
                                            echo 'value="'.$studentsTeachers[$studentTeacherKey]->getStartDate().'"';
                                        }
                                    }
                                    ?>
                                >
                            </div>
                            <div class="uk-width-1-2">
                                <div class="uk-form-label">Fin</div>
                                <input class="uk-input"
                                       type="date"
                                       name="studentTeacher[<?php echo $i ?>][endDate]"
                                    <?php
                                    if (false !== $studentTeacherKey) {
                                        /** @var StudentTeacher[] $studentsTeachers */
                                        if ($studentsTeachers[$studentTeacherKey]->getTeacherId() === $teacher->getId()) {
                                            echo 'value="'.$studentsTeachers[$studentTeacherKey]->getEndDate().'"';
                                        }
                                    }
                                    ?>
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $i++;
                }
                ?>

                <div class="uk-margin uk-align-right">
                    <button class="uk-button uk-button-danger uk-button-large"
                            type="submit"
                    >
                        <?php
                        if (isset($student)) {
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

    <script>
        function switchTraineeship(id) {

            $('.traineeshipTeacher input')
                .each(function (index, element) {
                    $(element).prop('disabled', true);
                })
            ;

            $('.traineeshipTeacher[data-traineeship-id-'+ id + '] input')
                .each(function (index, element) {
                    $(element).prop('disabled', false);
                })
            ;

        }

        $(document).ready(function() {
            switchTraineeship($('#traineeshipIdSelector').val())
        } );
    </script>

<?php require_once __DIR__ . '/../principal-layout-bottom.php'; ?>