<?php
if(shell_exec("pgrep -l main") == true){
    echo "<font style='color: red; font-size: 20px;'>Bot is running!!!</font>";

    $filename = 'adminSettings.txt';
    $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
    foreach($eachlines as $lines){
        $setting = explode("=", $lines);
        $settingName = $setting[0];
        $settingValue = $setting[1];

        if($settingName == "SubmitPromptLock" && $settingValue == "on"){
            echo "<script>document.getElementById('promptSubmit').disabled = true;</script>";
        } else if($settingName == "SubmitPromptLock" && $settingValue == "off"){
            echo "<script>document.getElementById('promptSubmit').enabled = true;</script>";
        }

        if($settingName == "KillGenerationLock" && $settingValue == "on"){
            echo "<script>document.getElementById('killPrompt').disabled = true;</script>";
        } else if($settingName == "KillGenerationLock" && $settingValue == "off"){
            echo "<script>document.getElementById('killPrompt').enabled = true;</script>";
        }

        if($settingName == "TokensLock" && $settingValue > 0){
            echo "<script>$('#tokens').val('$settingValue');</script>";
            echo "<script>$('#tokens').prop('disabled', true);</script>";
        }

        if($settingName == "SaveAsDefaultLock" && $settingValue == "on"){
            echo "<script>document.getElementById('saveAsDefaultSettings').disabled = true;</script>";
        } else if($settingName == "SaveAsDefaultLock" && $settingValue == "off"){
            echo "<script>document.getElementById('saveAsDefaultSettings').enabled = true;</script>";
        }

        if($settingName == "ThreadsLock" && $settingValue > 0){
            echo "<script>$('#threadChoice').val('$settingValue');</script>";
            echo "<script>$('#threadChoice').prop('disabled', true);</script>";
        }

        if($settingName == "ModelLock" && $settingValue !== ""){
            echo "<script>$('#selectModel').prop('disabled', true);</script>";
            
            echo "<script>
            $('#selectModel option').each(function() {
                if ($(this).text() == '$settingValue') {
                      $(this).prop('selected', true);
                }
            });
            </script>";
        }

        if($settingName == "InitPromptLock" && $settingValue !== ""){
            echo "<script>
            $('#selectPrePrompt option').each(function() {
                if ($(this).text() == '$settingValue') {
                      $(this).prop('selected', true);
                }
            });
            </script>";

            echo "<script>$('#selectPrePrompt').prop('disabled', true);</script>";
        }

        if($settingName == "OutputLock" && $settingValue == "on"){
            echo "<script>document.getElementById('selectOutput').disabled = true;</script>";
            echo "<script>document.getElementById('outputNameAppend').disabled = true;</script>";
            echo "<script>document.getElementById('outputTxtSize').disabled = true;</script>";
        } else if($settingName == "OutputLock" && $settingValue == "off"){
            echo "<script>document.getElementById('selectOutput').enabled = true;</script>";
            echo "<script>document.getElementById('outputNameAppend').enabled = true;</script>";
            echo "<script>document.getElementById('outputTxtSize').enabled = true;</script>";
        }

    }

    echo "<script>$('#serverOutput').css('border','10px solid red');</script>";
} else {
    echo "<font style='color: green; font-size: 20px'>Bot is NOT running. Ready for new prompt.</font>";
    echo "<script>document.getElementById('promptSubmit').disabled = false;</script>";
    echo "<script>$('#serverOutput').css('border','10px solid green');</script>";
    echo "<script>$('#promptSubmit').show();</script>";

    $filename = 'adminSettings.txt';
    $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
    foreach($eachlines as $lines){
        $setting = explode("=", $lines);
        $settingName = $setting[0];
        $settingValue = $setting[1];

        if($settingName == "TokensLock" && $settingValue > 0){
            echo "<script>$('#tokens').val('$settingValue');</script>";
            echo "<script>$('#tokens').prop('disabled', true);</script>";
        }

        if($settingName == "ThreadsLock" && $settingValue > 0){
            echo "<script>$('#threadChoice').val('$settingValue');</script>";
            echo "<script>$('#threadChoice').prop('disabled', true);</script>";
        }

        if($settingName == "ModelLock" && $settingValue !== ""){
            echo "<script>$('#selectModel').prop('disabled', true);</script>";
            
            echo "<script>
            $('#selectModel option').each(function() {
                if ($(this).text() == '$settingValue') {
                      $(this).prop('selected', true);
                }
            });
            </script>";
        }

        if($settingName == "InitPromptLock" && $settingValue !== ""){
            echo "<script>
            $('#selectPrePrompt option').each(function() {
                if ($(this).text() == '$settingValue') {
                      $(this).prop('selected', true);
                }
            });
            </script>";

            echo "<script>$('#selectPrePrompt').prop('disabled', true);</script>";
        }

        if($settingName == "OutputLock" && $settingValue == "on"){
            echo "<script>document.getElementById('selectOutput').disabled = true;</script>";
            echo "<script>document.getElementById('outputNameAppend').disabled = true;</script>";
            echo "<script>document.getElementById('outputTxtSize').disabled = true;</script>";
        } else if($settingName == "OutputLock" && $settingValue == "off"){
            echo "<script>document.getElementById('selectOutput').enabled = true;</script>";
            echo "<script>document.getElementById('outputNameAppend').enabled = true;</script>";
            echo "<script>document.getElementById('outputTxtSize').enabled = true;</script>";
        }

        if($settingName == "SaveAsDefaultLock" && $settingValue == "on"){
            echo "<script>document.getElementById('saveAsDefaultSettings').disabled = true;</script>";
        } else if($settingName == "SaveAsDefaultLock" && $settingValue == "off"){
            echo "<script>document.getElementById('saveAsDefaultSettings').enabled = true;</script>";
        }

    }
}
?>