<?php

use Afip\Planning\Components\Messenger\Messenger;

$messages = Messenger::getMessages();

?>

<script>
    $(document).ready(function() {
        <?php
        foreach ($messages as $message) {
        ?>
        UIkit.notification("<?php echo \addslashes($message[0]) ?>", "<?php echo $message[1] ?>");
        <?php
        }
        ?>
    } );
</script>

</body>
</html>