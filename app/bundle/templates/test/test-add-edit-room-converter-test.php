{% require_once __DIR__ . '/../principal-layout-top.php'; %}
    <div class="uk-container-expand uk-padding-small">
        <h2 class="uk-heading-line uk-text-center">{!{ $title }!}</h2>
        <form method="post">
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Salle</legend>

                <div class="uk-margin">
                    <input class="uk-input"
                           type="text"
                           placeholder="Etiquette"
                           name="room[label]"
                        {%
                        if (isset($room)) {
                            {{ 'value="'.$room->getLabel().'"' }};
                        }
                        %}
                    >
                </div>

                <div class="uk-margin uk-align-right">
                    <button class="uk-button uk-button-danger uk-button-large"
                            type="submit"
                    >
                        {%
                        if (isset($room)) {
                            {{ 'Modifier' }};
                        } else {
                            {{ 'Créer' }};
                        }
                        %}
                    </button>
                </div>
            </fieldset>
        </form>
    </div>

{% require_once __DIR__ . '/../principal-layout-bottom.php'; %}