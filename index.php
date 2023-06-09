<!-- ZIPTIE: a llama.cpp web-ui written in Javascript, jQuery and PHP - Jed Hyndman 2023 -->
<!-- llama.cpp - https://github.com/ggerganov/llama.cpp -->
<?php
session_start();
?>
<html>

  <head>
    <link rel="stylesheet" href="includes/style.css">
    <script src="includes/jquery-3.6.4.min.js"></script>
    <script src="scripts.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ZIPTIE: llama.cpp web interface.</title>
  </head>

  <body class='img1'>
    <input type='hidden' id='loadedFontSize'></input>
    <div id='mainDiv'>

      <div id='screenOutputMain'>
        <div id='sOD'>
          <div id='serverOutput' class="font1"></div>
        </div>
        <div id='displayFullPrompt' class="font1"></div>
      </div>
      <font id='checkScreenPause' style='display:none'>Display is paused.</font>
      <font id='checkScreenResume' style='display:none;'>Display is running.</font>
      <button id='pauseOutput' onclick='pauseOutput();'>Pause Display</button>
      <button id='resumeOutput' onclick='resumeOutput();'>Resume Display</button>
      <button id='viewOutputArchive' onclick='viewOutputArchive();'>View Display Archive</button>
      <?php
      $filename = 'avaliableOutputs.txt';
      $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
      ?>
      <font id='avaliableOutputLabel'>Display Files:</font><select id="selectOutput">
          <?php
            foreach($eachlines as $lines){
              $outputName = $lines;
              echo "<option value='".$outputName."'>$outputName</option>";
            }
          ?>
      </select>
      <button id='outputFontSmaller' style='float:right; display:inline'>Font \/</button>
      <button id='outputFontBigger' style='float:right; display:inline'>Font /\</button>
      <button id='changeOutputFont' style='float:right; display:inline'>Change Display Font</button>
      <button id='changeBackgroundButton' style='float:right; display:inline'>Change Background</button>
      
      <br>
      <br>

      <div id='promptInputDivOptions'>
        ~Settings~
        Setting Name: 
        <button id='saveSettings' onclick="saveSettings(1);">Save</button>
        <button id='saveAsDefaultSettings' onclick="saveSettings(2);">Save as default</button>
        Save Name: <input type='text' id='saveSettingName' size="12"></input>
        <input type='hidden' id='hiddenOutputName'></input>
        <input type='hidden' id='hiddenSavedSettingName'></input>
        
        
        <?php
          $filename = 'avaliableSettings.txt';
          $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
        ?>
        Load Setting: <select id="selectSetting">
          <option id='blankOption' value='settings-default.txt'></option>
            <?php
              foreach($eachlines as $lines){
                $settingName = $lines;
                echo "<option value='".$settingName."'>$settingName</option>";
              }
            ?>
        </select>
        <button id='reloadSettingsButton' onclick='window.location.reload();'>Reload/Rescan All Settings/Models and Prompts</button>
        <br>
        <?php
        $filename = 'avaliableModels.txt';
        $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
        ?>
        Model: <select id="selectModel">
            <?php
              foreach($eachlines as $lines){
                $model = explode("~", $lines);
                $modelName = $model[0];
                $modelFileName = $model[1];
                echo "<option value='".$modelFileName."'>$modelName</option>";
              }
            ?>
        </select>

        <br>

        <?php
        $filename2 = 'avaliablePrompts.txt';
        $eachlines2 = file($filename2, FILE_IGNORE_NEW_LINES);
        ?>
        Prompt: <select id="selectPrePrompt">
            <?php
              foreach($eachlines2 as $lines){
                $prompt = explode("~", $lines);
                $promptName = $prompt[0];
                $promptlFileName = $prompt[1];
                echo "<option value='".$promptlFileName."'>$promptName</option>";
              }
            ?>
        </select>
        Est. Token Length: <input type='number' id='estimateTokenDisplay'></input>
        <button id='showDisplayFullPrompt' onclick='displayFullPrompt()'>Display Full Prompt</button>
        <button id='hideDisplayFullPrompt' onclick='hideFullPrompt()'>Hide Full Prompt</button>
        <font id='createNewPromptFileLabel'>Save as: </font>
        <input type='text' id='newPromptFilename' value='user-pre-prompt-1.txt'></input>
        <button id='saveEditedPromptButton' onclick='saveEditedPrompt()'>Save Edited Prompt</button>
        <button id='saveNewPromptButton' onclick='saveNewUserPrompt()'>Save New Prompt</button>
        <button id='createNewPromptButton' onclick='createNewPrompt()'>Create New Prompt</button>
        
        <br>

        <!-- Prefix Prompt (not required): <input type='text' id='prefPromptText' value=''></input> -->
        <!-- <br> -->
        <!-- User Prompt:
        <br>
        <input type='text' id='promptText' rows='2' value=''></input>
        <br> -->
        Generate Random Prompt? (Ignores all init and user prompts):  <input type="radio" id="randomPrompt1" name="randomPrompt" value="1" checked="checked" />
                                  <label for="randomPrompt1">No</label>

                                  <input type="radio" id="randomPrompt2" name="randomPrompt" value="2" />
                                  <label for="randomPrompt2">Yes</label>
        <br>
        Tokens: <input type="number" id="tokens" min="10" max="10000" value='1000'></input>
        Context Size: <input type="number" id="cSize" min="1" max="2048" value='2048'></input>
        Temp: <input type="number" id="temp" min="0.1" max="1.0" value='0.8'></input>
        Top_k: <input type="number" id="topk" min="1" max="100" value='50'></input>
        Top_p: <input type="number" id="topp" min="0.1" max="1.0" value='0.9'></input>
        Repeat Penalty: <input type="number" id="repeatP" min="0.1" max="2.0" value='1.2'></input>
        TFS: <input type="number" id="tfs" min="1.0" max="100" value='1.0'></input>
        Typical Sampling: <input type="number" id="tSampling" min="1.0" max="100" value='1.0'></input>
        <!-- <button id='genRandomSeed' onclick='genRandomSeed()'>Generate Random Seed</button> -->
        <br>
        Seed: <input type="number" id="seedChoice" min="1" max="99999999" value='-1'></input>
        Use Random Seed?: <input type="radio" id="randomSeedChoice1" name="randomSeedChoice" value="1"  />
                          <label for="randomSeedChoice1">No</label>

                          <input type="radio" id="randomSeedChoice2" name="randomSeedChoice" value="2" checked="checked" />
                          <label for="randomSeedChoice2">Yes</label>
        <br>
        Mirostat: <input type="number" id="mirostat_N" min="0" max="2" value='0'></input>
        Mirostat LR: <input type="number" id="mirostat_LR" min="0" max="100" value='0.1'></input>
        Mirostat Entropy: <input type="number" id="mirostat_E" min="0" max="100" value='5.0'></input>
        Presence Penalty: <input type="number" id="pres_pen" min="0" max="100" value='0.0'></input>
        Freq Penalty: <input type="number" id="freq_pen" min="0" max="100" value='0.0'></input>
        <br>
        Prompt cache file name (.bin): <input type='text' id='promptCacheFileName' value=''></input>
        Cache all prompts?: <input type="radio" id="promptCacheAllChoice1" name="promptCacheAllChoice" value="1" checked="checked" />
                          <label for="promptCacheAllChoice1">No</label>

                          <input type="radio" id="promptCacheAllChoice2" name="promptCacheAllChoice" value="2" />
                          <label for="promptCacheAllChoice2">Yes</label>
        <br>
        Logit Bias (use comma to seperate): <input type='text' id='logitBias' value=''></input>
        <?php
        // $filename = 'avaliableLoRaAdapters.txt';
        // $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
        ?>
        <!-- LoRa Adapter: <select id="selectLoraAdapter"> -->
            <?php
            //   foreach($eachlines as $lines){
            //     $lAdapter = explode("~", $lines);
            //     $lAdapterName = $lAdapter[0];
            //     $lAdapterFileName = $lAdapter[1];
            //     echo "<option value='".$lAdapterFileName."'>$lAdapterName</option>";
            //   }
            // ?>
        <!-- </select> -->
        <?php
        // $filename = 'avaliableLoRaBases.txt';
        // $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
        ?>
        <!-- LoRa Base: <select id="selectLoraBase"> -->
            <?php
              // foreach($eachlines as $lines){
              //   $lBase = explode("~", $lines);
              //   $lBaseName = $lBase[0];
              //   $lBaseFileName = $lBase[1];
              //   echo "<option value='".$lBaseFileName."'>$lBaseName</option>";
              // }
            ?>
        <!-- </select> -->
        <br>
        Keep Model in RAM (No swap usage)?: <input type="radio" id="ramChoice1" name="ramChoice" value="1" checked="checked" />
                            <label for="ramChoice1">No</label>

                            <input type="radio" id="ramChoice2" name="ramChoice" value="2" />
                            <label for="ramChoice2">Yes</label>
        <br>
        Ignore End of Stream?: <input type="radio" id="eosChoice1" name="eosChoice" value="1" />
                               <label for="eosChoice1">No</label>

                               <input type="radio" id="eosChoice2" name="eosChoice" value="2" checked="checked" />
                               <label for="eosChoice1">Yes</label>
        <br>
        Add timestamp to output?: <input type="radio" id="stampChoice1" name="stampChoice" value="1" />
                                  <label for="stampChoice1">No</label>

                                  <input type="radio" id="stampChoice2" name="stampChoice" value="2" checked="checked" />
                                  <label for="stampChoice2">Yes</label>
        
        <br>                          
        Number of Tokens to keep from initial prompt: <input type="number" id="keepChoice" min="-1" max="1000" value='-1'></input> (-1 = all)
        <br>                          
        Last number of tokens to consider penalizing: <input type="number" id="lastNPChoice" min="0" max="4096" value='1024'></input>
        <br>                          
        CPU threads to be used: <input type="number" id="threadChoice" min="1" max="512" value='-1'></input> (-1 = all)
        <br>

        <br>

        <div id='promptSubmitKillOptions'>
          <div id='botStatus'>
            <div id='isRunning'>
            </div>
          </div>
          <button id='promptSubmit' onclick='submitPrompt();disableSubmitButton();'>Submit Prompt</button>
          Max size of output.txt before archiving (bytes): <input type="number" id="outputTxtSize" min="1" max="99999999" value='100000'></input>
          Output file name: <input type='text' id='outputNameAppend' size="12"></input>
          Disable new generation info?: <input type="radio" id="disableHChoice1" name="disableHChoice" value="1" checked="checked" />
                               <label for="disableHChoice1">No</label>

                               <input type="radio" id="disableHChoice2" name="disableHChoice" value="2" />
                               <label for="disableHChoice2">Yes</label>
          <br>
          <button id='killPrompt' onclick='killPrompt();'>Kill Bot Generation</button>
          Alt. Output file name: <input type='text' id='altOutputName' value=''></input>
          <button id='saveSettings' onclick="openAltOutputFile();">Open Alt. Output file in new tab</button>
        </div>

      </div>

      <br>

      <div id="serverStatusDiv">
        <textarea id='serverStatus' style='background-color: white'></textarea>
      </div>

    </div>

  </body>
</html>
