var firstStartToggle = 0;
var startSettingName = "";
time = new Date().getTime();

//updaing fonts and backgrounds
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
        hiddenOutputName = $("#hiddenOutputName").val();
        currentFontSize = parseFloat(currentFontSize);
        currentFontSize = Math.floor(currentFontSize);

        if(currentFontSize > 8 && (+currentFontSize - 2) > 8){
        newFontSize = +currentFontSize - 2;
        $("#loadedFontSize").val(newFontSize);
        $('#serverOutput').load("loadOutput.php?var1=" + hiddenOutputName + "&var2=" + newFontSize + "px");
        }
    });

    $('#outputFontBigger').click(function() {
        currentFontSize = $("#botOutputText").css('font-size');
        hiddenOutputName = $("#hiddenOutputName").val();
        currentFontSize = parseFloat(currentFontSize);
        currentFontSize = Math.floor(currentFontSize);

        if(currentFontSize > 8){
        newFontSize = +currentFontSize + 2;
        $("#loadedFontSize").val(newFontSize);
        $('#serverOutput').load("loadOutput.php?var1=" + hiddenOutputName + "&var2=" + newFontSize + "px");
        }
    });
});

//opens a seperate tab that displays all the output.txt's that the user has generated.
function viewOutputArchive(){
    window.open('displayArchive.php', 'Output Archive'); 
}

//submit prompt
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
    outputNameAppend = $('#outputNameAppend').val();
    disableHChoice = $('input[name="disableHChoice"]:checked').val();
    altOutputName = $('#altOutputName').val();
    pT = encodeURI(pT);
    prefPrompt = encodeURI(prefPrompt);

    $('#serverOutput').load('newPrompt.php?var1=' + pT + '&var2=' + tokens + '&var3=' + temp + '&var4=' + topk + '&var5=' + topp + '&var6=' + promptType + '&var7=' + modelType 
    + '&var8=' + contextSize + '&var9=' + repeatP + '&var10=' + ramChoice + '&var11=' + eosChoice + '&var12=' + stampChoice + '&var13=' + keepChoice + '&var14=' + lastNPChoice
    + '&var15=' + seedChoice + '&var16=' + randomPrompt + '&var17=' + threadChoice + '&var18=' + outputTxtSize + '&var19=' + prefPrompt + '&var20=' + outputNameAppend
    + "&var21=" + disableHChoice + "&var22=" + altOutputName);

    console.log('newPrompt.php?var1=' + pT + '&var2=' + tokens + '&var3=' + temp + '&var4=' + topk + '&var5=' + topp + '&var6=' + promptType + '&var7=' + modelType 
    + '&var8=' + contextSize + '&var9=' + repeatP + '&var10=' + ramChoice + '&var11=' + eosChoice + '&var12=' + stampChoice + '&var13=' + keepChoice + '&var14=' + lastNPChoice
    + '&var15=' + seedChoice + '&var16=' + randomPrompt + '&var17=' + threadChoice + '&var18=' + outputTxtSize + '&var19=' + prefPrompt + '&var20=' + outputNameAppend
    + "&var21=" + disableHChoice + "&var22=" + altOutputName);

    $("#selectOutput").val(outputNameAppend);
}

//kill the running generation
function killPrompt(){
    hiddenOutputName = $("#hiddenOutputName").val();
    $('#serverOutput').load('kill.php?var1=' + hiddenOutputName);
}

//pause the output of the screen (otherwise it just keeps updating and you can select text from it)
function pauseOutput(){
    $("#checkScreenPause").css("display","inline"); 
    $("#checkScreenResume").css("display","none");
    clearInterval(timeout);
}

//continues the output after pausing
    function resumeOutput(){
    $("#checkScreenResume").css("display","inline"); 
    $("#checkScreenPause").css("display","none");
    var timeout = setInterval(reloadChat, 2000); 
}

//rescans the model folders in llama.cpp then saves them to a .txt for the website to use.
function rescanModels(){
    $('#serverOutput').load('scanModels.php?t=' + time);
}

//rescans the prompt folders in llama.cpp then saves them to a .txt for the website to use.
function rescanPrompts(){
    $('#serverOutput').load('scanPrompts.php?t=' + time);
}

//rescans the output.txt's in the root folder and collects them for further use...
function rescanOutputs(){
    $('#serverOutput').load('getOutputs.php?t=' + time);
}

//same thing as above but with settings.txt
function rescanSettings(){
    $('#serverOutput').load('getSettings.php?t=' + time);
}

//clears output name on click of the new settings name field.
$(document).ready(function() {
    $('#saveSettingName').click(function(e) {
        $('#outputNameAppend').val("");
    });
});

function disableSubmitButton(){
    $('#promptSubmit').hide();
}

function openAltOutputFile(){
    var url = $("#altOutputName").val();
    window.open(url, '_blank');
}

function displayFullPrompt(){
    selectedPrompt = $('#selectPrePrompt').val();
    loadedFontSize = $("#loadedFontSize").val();
    $('#displayFullPrompt').load("loadPromptDisplay.php?var1=" + selectedPrompt + "&var2=" + loadedFontSize + "&t=" + time);
    $("#sOD").css({"width": "50%", "display":"inline-block"});
    $("#showDisplayFullPrompt").hide();
    $("#hideDisplayFullPrompt").show();
    $('#displayFullPrompt').show();
}

function hideFullPrompt(){
    $("#showDisplayFullPrompt").show();
    $("#hideDisplayFullPrompt").hide();
    $('#displayFullPrompt').hide();
    $("#sOD").css("width", "100%");
}

//saves settings, grabs the data via jQuery and bundles them into a request for saveSettings.php which then saves them as a .txt file.
function saveSettings(data){
    $('#outputNameAppend').val("");
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
    backgroundImage = $('body').attr('class'); 
    fontSize = $('#botOutputText').css('font-size'); 
    fontType = $('#serverOutput').attr('class');
    autoLoad = $('input[name="alChoice"]:checked').val();
    outputNameAppend = $('#outputNameAppend').val();
    saveName = $('#saveSettingName').val();
    saveAsMode = data;
    disableHChoice = $('input[name="disableHChoice"]:checked').val();
    altOutputName = $('#altOutputName').val(); 

    outputName = saveName;
    outputName = outputName.replace('.txt', '');
    outputName = outputName.replace('settings-', '');
    outputName = "output-" + outputName + ".txt";
    
    console.log(outputName + "-save");

    console.log(data);
    console.log(saveName);
    
    pT = encodeURI(pT);
    prefPrompt = encodeURI(prefPrompt);

    $('#serverOutput').load('saveSettings.php?var1=' + pT + '&var2=' + tokens + '&var3=' + temp + '&var4=' + topk + '&var5=' + topp + '&var6=' + promptType + '&var7=' + modelType 
    + '&var8=' + contextSize + '&var9=' + repeatP + '&var10=' + ramChoice + '&var11=' + eosChoice + '&var12=' + stampChoice + '&var13=' + keepChoice + '&var14=' + lastNPChoice
    + '&var15=' + seedChoice + '&var16=' + randomPrompt + '&var17=' + threadChoice + '&var18=' + outputTxtSize + '&var19=' + prefPrompt + '&var20=' + backgroundImage + '&var21=' + fontSize
    + '&var22=' + fontType + '&var23=' + autoLoad + '&var24=' + outputName + '&var25=' + saveName + '&var26=' + saveAsMode + '&var27=' + disableHChoice
    + '&var28=' + altOutputName);

    $('#outputNameAppend').val(outputName);
}

//opens the adminSettings.txt and grabs the setting name that was saved at the bottom, this happens once per page reload.
function loadSetDefaultSettings(){
    if(firstStartToggle == 0){
    console.log(firstStartToggle + "-1");
      $.get("adminSettings.txt" + "?v=" + time, function(data2){
      var lines2 = data2.split("\n");
        for (i in lines2) {
          if(lines2[i].startsWith("AUTOLOAD=")){
            settingName = lines2[i].split("=");
            settingName = settingName[1];
            $('#saveSettingName').val(settingName);
            $("#selectSetting").val(settingName);
            $("#hiddenOutputName").val(settingName);
            $("#hiddenSavedSettingName").val(settingName);
            $("#currentSettingName").val(settingName);
            firstStartToggle = 1;
            startSettingName = settingName;
            console.log(firstStartToggle + "-2");
          }
        }
      });
    }
}

//loads settings from a file, uses JQuery to place data in the correct places.
function loadSettings(){
    rescanPrompts();
    rescanModels();
    rescanOutputs();
    rescanSettings();

    settingName = $('#saveSettingName').val();

    $.get(settingName + "?v=" + time, function (data){
      var lines = data.split("\n");

      $('#promptText').val(lines[0]);
      $('#tokens').val(lines[1]);
      $('#temp').val(lines[2]);
      $('#topk').val(lines[3]);
      $('#topp').val(lines[4]);
      $("#selectPrePrompt").val(lines[5]);
      $("#selectModel").val(lines[6]);
      $('#cSize').val(lines[7]);
      $('#repeatP').val(lines[8]);
      $('input[name="ramChoice"]').val([lines[9]]);
      $('input[name="eosChoice"]').val([lines[10]]);
      $('input[name="stampChoice"]').val([lines[11]]);

      $('#keepChoice').val(lines[12]);
      $('#lastNPChoice').val(lines[13]);
      $('#seedChoice').val(lines[14]);
      $('input[name="randomPrompt"]').val([lines[15]]);

      $('#threadChoice').val(lines[16]);
      $('#outputTxtSize').val(lines[17]);
      $('#prefPromptText').val(lines[18]);
      

      cBC = $('body').attr('class'); 
      $("body").removeClass(cBC);
      $('body').addClass(lines[19]);

      $savedFontSize = lines[20];
      $('#serverOutput').load("loadOutput.php?var1=" + lines[23] + "&var2=" + $savedFontSize + "px");
      $('#loadedFontSize').val(lines[20]);
      $("#hiddenOutputName").val(lines[23]);
      $("#hiddenSavedSettingName").val(settingName);

      cFs = $('#serverOutput').attr('class');
      $('#serverOutput').addClass(lines[21]).removeClass(cFs); 

      $autoLoad = lines[22];
      if($autoLoad == "~AUTOLOAD~"){
        $al = 2;
      } else {
        $al = 1;
      }
      $('input[name="alChoice"]').val([$al]);

      $('#outputNameAppend').val(lines[23]);
      $('#selectSetting').val(settingName);
      $('#selectOutput').val(lines[23]);

      $("#currentSettingName").val(settingName);

      $('input[name="disableHChoice"]').val([lines[24]]);
      $('#altOutputName').val([lines[25]]); 
    });
}

//does the first setting load of a page refresh and also changes certain dropdown menus on change.
$(document).ready(function() {
    $("#checkScreenResume").css("display","inline");
    $('#serverStatus').load('serverStatus.php');
    loadSetDefaultSettings();
    setTimeout(() => {
        loadSettings();
    }, 100);

    outputName = $("#selectOutput option:selected").text();
    $('#outputNameAppend').val(outputName);
    $('#selectOutput').val(outputName);

    settingName = $("#selectSetting option:selected").text();
    settingName = settingName.replace('.txt', '');
    settingName = settingName.replace('settings-', '');
    $('#saveSettingName').val("settings-" + settingName + ".txt");
    $('#selectSetting').val("settings-" + settingName + ".txt");

    $('#selectOutput').on('change', function() {
      outputName = $("#selectOutput option:selected").text();
      $('#outputNameAppend').val(outputName);
      $('#selectOutput').val(outputName);
    });

    $('#selectSetting').on('change', function() {
      settingName = $("#selectSetting option:selected").text();
      settingName = settingName.replace('.txt', '');
      settingName = settingName.replace('settings-', '');
      $('#saveSettingName').val("settings-" + settingName + ".txt");
      $('#selectSetting').val(settingName);
      $('#selectOutput').val(settingName);
      setTimeout(() => {
        loadSettings();
      }, 100);
    });
});

//constantly refreshes output div/screen
function reloadChat(){
    settingName = $("#hiddenSavedSettingName").val();
    loadedFontSize = $("#loadedFontSize").val();
    outputAppend = $("#outputNameAppend").val();

    // if(outputAppend = ''){
    //     outputAppend = 'output-default.txt';
    // }

    $('#serverOutput').load('loadOutput.php?var1=' + outputAppend + "&var2=" + loadedFontSize + "&t=" + time);
}
var timeout = setInterval(reloadChat, 500); 

//checks every 2 seconds if the server is generating text and changes css values to red or green
$('#isRunning').load('checkRunning.php');
function reloadChat2(){
    $('#isRunning').load('checkRunning.php');
}
var timeout2 = setInterval(reloadChat2, 500); 

//same thing as above but theres also text to tell the user if the bot is generating.
$('#serverStatus').load('serverStatus.php');
function reloadChat3(){
    $('#serverStatus').load('serverStatus.php');
}
var timeout3 = setInterval(reloadChat3, 5000);

//rescans outputs and settings every page load.
rescanOutputs();rescanSettings();rescanPrompts();rescanModels();

