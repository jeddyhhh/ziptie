<!-- ZIPTIE: a llama.cpp web-ui written in Javascript and PHP - Jed Hyndman 2023 -->
<?php
session_start();
$_SESSION['fontSize'] = '12px';
?>
<html>

  <head>
    <link rel="stylesheet" href="includes/style.css">
    <script src="includes/jquery-3.6.4.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ZIPTIE: The ai bot server that is held together with zipties.</title>
  </head>

  <body class='img1'>
    <div id='mainDiv'>

      <div id='screenOutputMain'>
        <div id='serverOutput' class="font1">
        </div>
      </div>
      <font id='checkScreenPause' style='display:none'>Screen is paused.</font>
      <font id='checkScreenResume' style='display:none;'>Screen is running.</font>
      <button id='pauseOutput' onclick='pauseOutput();'>Pause Output Display</button>
      <button id='resumeOutput' onclick='resumeOutput();'>Resume Output Display</button>
      <button id='viewOutputArchive' onclick='viewOutputArchive();'>View Output Archive (opens new tab)</button>
      <button id='outputFontSmaller' style='float:right; display:inline'>Font \/</button>
      <button id='outputFontBigger' style='float:right; display:inline'>Font /\</button>
      <button id='changeOutputFont' style='float:right; display:inline'>Change Screen Font</button>
      <button id='changeBackgroundButton' style='float:right; display:inline'>Change Site Background</button>
      
      <!-- background/font change -->
      <script>
        $(document).ready(function() {
          $('#changeBackgroundButton').click(function() {
            cBC = $('body').attr('class'); 
            cBCNum = cBC.replace(/^\D+/g, '');

            if(cBCNum < 20){
              $('body').addClass('img' + (+cBCNum + 1)).removeClass(cBC);
            } else {
              $('body').addClass('img1').removeClass(cBC);
            }
          });

          $('#changeOutputFont').click(function() {
            cOC = $('#serverOutput').attr('class'); 
            cOCNum = cOC.replace(/^\D+/g, '');

            if(cOCNum < 6){
              $('#serverOutput').addClass('font' + (+cOCNum + 1)).removeClass(cOC);
            } else {
              $('#serverOutput').addClass('font1').removeClass(cOC);
            }
          });

          $('#outputFontSmaller').click(function() {
            currentFontSize = $("#botOutputText").css('font-size');
            currentFontSize = parseFloat(currentFontSize);
            currentFontSize = Math.floor(currentFontSize);

            if(currentFontSize > 8 && (+currentFontSize - 2) > 8){
              newFontSize = +currentFontSize - 2;
              $('#serverOutput').load('loadOutput.php?var1=' + newFontSize + "px");
            }
          });

          $('#outputFontBigger').click(function() {
            currentFontSize = $("#botOutputText").css('font-size');
            currentFontSize = parseFloat(currentFontSize);
            currentFontSize = Math.floor(currentFontSize);

            if(currentFontSize > 8){
              newFontSize = +currentFontSize + 2;
              $('#serverOutput').load('loadOutput.php?var1=' + newFontSize + "px");
            }
          });

        });
      </script>

      <br>

      <script>
        $('#serverOutput').load('loadOutput.php');
        $("#checkScreenResume").css("display","inline");

        function reloadChat(){
          $('#serverOutput').load('loadOutput.php');
        }
        var timeout = setInterval(reloadChat, 2000); 
        
        function viewOutputArchive(){
          window.open('displayArchive.php', 'Output Archive'); 
        }
      </script>

      <script>
        function submitPrompt(){
          pT = $('#promptText').val();
          tokens = $('#tokens').val();
          temp = $('#temp').val();
          topk = $('#topk').val();
          topp = $('#topp').val();
          promptType = $('#selectPrePrompt').val();
          modelType = $('#selectModel').val();
          contextSize = $('#cSize').val();
          repeatP = $('#repeatP').val();
          ramChoice = $('input[name="ramChoice"]:checked').val();
          eosChoice = $('input[name="eosChoice"]:checked').val();
          stampChoice = $('input[name="stampChoice"]:checked').val();
          keepChoice = $('#keepChoice').val();
          lastNPChoice = $('#lastNPChoice').val();
          seedChoice = $('#seedChoice').val();
          randomPrompt = $('input[name="randomPrompt"]:checked').val();
          threadChoice = $('#threadChoice').val();
          prefPrompt = $('#prefPromptText').val();
          outputTxtSize = $('#outputTxtSize').val();
          pT = encodeURI(pT);
          prefPrompt = encodeURI(prefPrompt);
          $('#serverOutput').load('newPrompt.php?var1=' + pT + '&var2=' + tokens + '&var3=' + temp + '&var4=' + topk + '&var5=' + topp + '&var6=' + promptType + '&var7=' + modelType 
          + '&var8=' + contextSize + '&var9=' + repeatP + '&var10=' + ramChoice + '&var11=' + eosChoice + '&var12=' + stampChoice + '&var13=' + keepChoice + '&var14=' + lastNPChoice
          + '&var15=' + seedChoice + '&var16=' + randomPrompt + '&var17=' + threadChoice + '&var18=' + outputTxtSize + '&var19=' + prefPrompt);
          console.log('newPrompt.php?var1=' + pT + '&var2=' + tokens + '&var3=' + temp + '&var4=' + topk + '&var5=' + topp + '&var6=' + promptType + '&var7=' + modelType 
          + '&var8=' + contextSize + '&var9=' + repeatP + '&var10=' + ramChoice + '&var11=' + eosChoice + '&var12=' + stampChoice + '&var13=' + keepChoice + '&var14=' + lastNPChoice
          + '&var15=' + seedChoice + '&var16=' + randomPrompt + '&var17=' + threadChoice + '&var18=' + outputTxtSize + '&var19=' + prefPrompt);
        }

        function killPrompt(){
          //document.getElementById("promptSubmit").disabled = false;
          $('#serverOutput').load('kill.php');
        }

        function pauseOutput(){
          $("#checkScreenPause").css("display","inline"); 
          $("#checkScreenResume").css("display","none");
          clearInterval(timeout);
          console.log("Output paused. Maybe.");
        }

        function resumeOutput(){
          $("#checkScreenResume").css("display","inline"); 
          $("#checkScreenPause").css("display","none");
          var timeout = setInterval(reloadChat, 2000); 
          console.log("Output resumed. Maybe.");
        }
      </script>

      <br>

      <div id='promptInputDivOptions'>
        ~Options~
        <br>
        Model: <select id="selectModel">
                  <option value="1">Vicuna 7B 1.0 (8gb+)</option>
                  <option value="6">Vicuna 7B 1.0 Uncensored (8gb+)</option>
                  <option value="10">Vicuna 13B 1.0 (16gb+)</option>
                  <option value="12">Vicuna 13B 1.1 (16gb+)</option>
                  <option value="11">GPT4xAlpaca 13B (16gb+)</option>
                  <option value="4">GPT4ALL 7B (8gb+)</option>
                  <option value="2">Alpaca 7B (8gb+)</option>
                  <option value="9">Alpaca 7B LoRa (8gb+)</option>
                  <option value="13">Koala 13B (16gb+)</option>
                  <option value="14">Instruct 13B (Slow) (16gb+)</option>
                  <option value="5">Aleksey Vicuna 7B (Slow) (8gb+)</option>
                  <option value="3">Koala 7B (Slow) (8gb+)</option>
                  <option value="7">Vicuna 7B 1.1 (Slow) (8gb+)</option>
                  <option value="8">Vicuna 7B 1.1 2 (Slow) (8gb+)</option>
                </select>
        <br>
        Pre Prompt: <select id="selectPrePrompt">
                      <option value="1">Default Vicuna</option>
                      <option value="2">Do It Anyway (DIA)</option>
                      <option value="3">Default Alpaca</option>
                      <option value="4">Do Anything Now (DAN)</option>
                      <option value="5">Chat with Bob</option>
                      <option value="6">Default Koala</option>
                      <option value="7">No Pre Prompt</option>
                      <option value="8">Aleksey Vicuna Default</option>
                    </select>

        <br>
        Prefix Prompt (not required): <input type='text' id='prefPromptText' value=''></input>
        <br>
        Prompt:
        <br>
        <input type='text' id='promptText' rows='2' value='Write a screenplay set in the world of "Seinfeld", the gang gets up to mischief, make it funny.'></input>
        <br>
        Generate Random Prompt? (Ignores all pre and user prompts):  <input type="radio" id="randomPrompt1" name="randomPrompt" value="1" checked="checked" />
                                  <label for="randomPrompt1">No</label>

                                  <input type="radio" id="randomPrompt2" name="randomPrompt" value="2" />
                                  <label for="randomPrompt2">Yes</label>
        <br>
        <br>
        Tokens: <input type="number" id="tokens" min="10" max="10000" value='1000'></input>
        Context Size: <input type="number" id="cSize" min="1" max="2048" value='2048'></input>
        Temp: <input type="number" id="temp" min="0.1" max="1.0" value='0.8'></input>
        Top_k: <input type="number" id="topk" min="1" max="100" value='50'></input>
        Top_p: <input type="number" id="topp" min="0.1" max="1.0" value='0.9'></input>
        Repeat Penalty: <input type="number" id="repeatP" min="0.1" max="2.0" value='1.2'></input>
        Seed: <input type="number" id="seedChoice" min="1" max="99999999" value='-1'></input> (-1 = random seed)
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
        Maximum size of output.txt before archiving (in bytes): <input type="number" id="outputTxtSize" min="1" max="99999999" value='100000'></input>
        <br>
        <br>

        <div id='promptSubmitKillOptions'>
          <div id='botStatus'>
            <div id='isRunning'>
            </div>
          </div>
          <button id='promptSubmit' onclick='submitPrompt()'>Submit Prompt</button>
          <br>
          <button id='killPrompt' onclick='killPrompt()'>Kill Bot Generation</button>
        </div>

      </div>

      <script>
        $('#isRunning').load('checkRunning.php');
        function reloadChat2(){
          $('#isRunning').load('checkRunning.php');
        }
        var timeout2 = setInterval(reloadChat2, 2000); 
      </script>

      <br>

      <div id="serverStatusDiv">
        <textarea id='serverStatus' style='background-color: white'></textarea>
      </div>

      <script>
        $('#serverStatus').load('serverStatus.php');
        function reloadChat2(){
          $('#serverStatus').load('serverStatus.php');
        }
        var timeout2 = setInterval(reloadChat2, 5000);
      </script>

    </div>

  </body>
</html>
