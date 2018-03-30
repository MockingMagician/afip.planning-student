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

            <?php
            $j = 0;
            foreach ($students as $student) {
            ?>

            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Etudiant
                    <label style="cursor: pointer;">
                        <input class="uk-checkbox uk-margin-medium-left studentSelector"
                               type="checkbox" onclick="studentSelector(this)"
                        >
                        <input type="hidden"
                               name="student[<?php echo $j ?>][id]"
                            <?php echo 'value="'.$student->getId().'"'; ?>
                        >
                        <span>Modifier</span>
                    </label>
                </legend>

                <div uk-grid class="uk-margin-small-bottom">

                    <div class="uk-width-1-4">
                        <div class="uk-margin">
                            <div class="uk-form-label">Nom</div>
                            <input class="uk-input"
                                   type="text"
                                   placeholder="Nom"
                                   name="student[<?php echo $j ?>][lastName]"
                                <?php echo 'value="'.htmlspecialchars($student->getLastName()).'"'; ?>
                            >
                        </div>
                    </div>

                    <div class="uk-width-1-4">
                        <div class="uk-margin">
                            <div class="uk-form-label">Prénom</div>
                            <input class="uk-input"
                                   type="text"
                                   placeholder="Prénom"
                                   name="student[<?php echo $j ?>][firstName]"
                                <?php echo 'value="'.htmlspecialchars($student->getFirstName()).'"'; ?>
                            >
                        </div>
                    </div>

                    <div class="uk-width-1-4">
                        <div class="uk-margin">
                            <div class="uk-form-label">Nationalité</div>
                            <select class="uk-select"
                                    name="student[<?php echo $j ?>][nationalityId]"
                            >
                                <?php
                                /** @var Nationality $nationality */
                                foreach ($nationalities as $nationality) {
                                    ?>
                                    <option value="<?php echo $nationality->getId() ?>"
                                        <?php
                                        /** @var Student $student */
                                        if ($student->getNationalityId() === $nationality->getId()) {
                                            echo 'selected';
                                        }
                                        ?>
                                    >
                                        <?php echo htmlspecialchars($nationality->getLabel()) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="uk-width-1-4">
                        <div class="uk-margin">
                            <div class="uk-form-label">Formation</div>
                            <select class="uk-select traineeshipIdSelector"
                                    name="student[<?php echo $j ?>][traineeshipId]"
                                    onchange="switchTraineeship(this, this.value);"
                            >
                                <?php
                                /** @var Traineeship $traineeship */
                                foreach ($traineeships as $traineeship) {
                                ?>
                                <option value="<?php echo $traineeship->getId() ?>"
                                    <?php
                                    /** @var Student $student */
                                    if ($student->getTraineeshipId() === $traineeship->getId()) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    <?php echo htmlspecialchars($traineeship->getLabel()) ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>

                <legend class="uk-legend">Professeurs et dates</legend>


                <?php
                /** @var Teacher $teacher */
                $i = 0;
                foreach ($teachers as $teacher) {
                    $studentTeacherKey = false;
                    if (isset($student)) {
                        /** @var StudentTeacher $studentTeacher */
                        foreach ($student->studentsTeachers as $key => $studentTeacher) {
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
                                   name="studentTeacher[<?php echo $j ?>][<?php echo $i ?>][teacherId]"
                                   value="<?php echo $teacher->getId() ?>"
                                <?php
                                if (false !== $studentTeacherKey) {
                                    /** @var StudentTeacher[] $studentsTeachers */
                                    if ($student->studentsTeachers[$studentTeacherKey]->getTeacherId() === $teacher->getId()) {
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
                                       name="studentTeacher[<?php echo $j ?>][<?php echo $i ?>][startDate]"
                                    <?php
                                    if (false !== $studentTeacherKey) {
                                        /** @var StudentTeacher[] $studentsTeachers */
                                        if ($student->studentsTeachers[$studentTeacherKey]->getTeacherId() === $teacher->getId()) {
                                            echo 'value="'.$student->studentsTeachers[$studentTeacherKey]->getStartDate().'"';
                                        }
                                    }
                                    ?>
                                >
                            </div>
                            <div class="uk-width-1-2">
                                <div class="uk-form-label">Fin</div>
                                <input class="uk-input"
                                       type="date"
                                       name="studentTeacher[<?php echo $j ?>][<?php echo $i ?>][endDate]"
                                    <?php
                                    if (false !== $studentTeacherKey) {
                                        /** @var StudentTeacher[] $studentsTeachers */
                                        if ($student->studentsTeachers[$studentTeacherKey]->getTeacherId() === $teacher->getId()) {
                                            echo 'value="'.$student->studentsTeachers[$studentTeacherKey]->getEndDate().'"';
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
            </fieldset>

                <hr>

            <?php $j++; } ?>

            <div class="uk-margin uk-align-right">
                <button class="uk-button uk-button-danger uk-button-large"
                        type="submit"
                >
                    Modifier
                </button>
            </div>

        </form>
    </div>

    <script>
        function switchTraineeship(from, id) {

            from = from.parentNode.parentNode.parentNode.parentNode;

            $(from).find('.traineeshipTeacher input')
                .each(function (index, element) {
                    $(element).prop('disabled', true);
                })
            ;

            $(from).find('.traineeshipTeacher[data-traineeship-id-'+ id + '] input')
                .each(function (index, element) {
                    $(element).prop('disabled', false);
                })
            ;

        }

        function studentSelector(self) {

            var from = self.parentNode.parentNode.parentNode;

            if (! $(self).is(':checked')) {
                $(from).find('input, select, textarea')
                    .each(function (index, element) {
                        $(element).prop('disabled', true);
                    })
                ;
                $(self).prop('disabled', false);
            } else {
                $(from).find('input, select, textarea')
                    .each(function (index, element) {
                        $(element).prop('disabled', false);
                    })
                ;
                $(from).find('.traineeshipIdSelector')
                    .each(function (index, element) {
                        switchTraineeship(element, $(element).val())
                    })
                ;
            }
        }

        $(document).ready(function() {
            $('.studentSelector')
                .each(function (index, element) {
                    studentSelector(element)
                })
            ;
        } );
    </script>

<?php require_once __DIR__ . '/../principal-layout-bottom.php'; ?>