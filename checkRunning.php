<?php
if(shell_exec("pgrep -l main") == true){
    echo "<font style='color: red; font-size: 20px;'>Bot is running!!!</font>";
    echo "<script>document.getElementById('promptSubmit').disabled = true;</script>";
    echo "<script>$('#serverOutput').css('border','10px solid red');</script>";
} else {
    echo "<font style='color: green; font-size: 20px'>Bot is NOT running. Ready for new prompt.</font>";
    echo "<script>document.getElementById('promptSubmit').disabled = false;</script>";
    echo "<script>$('#serverOutput').css('border','10px solid green');</script>";
}
?>