<?php
include("../fct/fonctions.php");
$notes=["C","D","E","F","G","A","B"];
writehead();


if (isset($_GET['BPM'])) $BPM=$_GET['BPM'];
else $BPM=0;
if (isset($_GET['chordsToLoad'])) $chordsToLoad=$_GET['chordsToLoad'];
else $chordsToLoad="";
if (isset($_GET['percussion'])) $percussion=$_GET['percussion'];
else $percussion="None";
if (isset($_GET['rythm'])) $rythm=$_GET['rythm'];
else $rythm="Once";
if (isset($_GET['melody'])) $melodyToLoad=$_GET['melody'];
else $melodyToLoad="";
if (isset($_GET['volumes'])) $volumes=explode("/",$_GET['volumes']);
else $volumes=["0","0","0"];

    echo "<div class='graydisplay'><div align=center> Hello ".$_SESSION['login']." !</div>
    <button type='button' class='btn btn-light' style ='width:80px'onclick='location.href=\"../page/savedChords.php\"'>Load</button><br>
    <button type='button' class='btn btn-light' style ='margin-top:10px;width:80px'onclick='location.href=\"importexport.php\"'>Import</button><br>
    <button type='button' class='btn btn-light' style ='margin-top:10px;width:80px'onclick='exportChords()'>Export</button><br>
    <button type='button' class='btn btn-warning' style='margin-top:10px;width:80px' onclick='location.href=\"../fct/disconnect.php\"'>Logout</button></div>";

    echo "<div class='container-fluid' align=center style='display:inline-block;'>
                <div class='col-sm-10' style='position:relative;top:-236px;' align=center>
                    <div class='card hide card-default graycarddefault' align=center style=''>
            <div class='card-header graycard'>
            <div class='card-title'><strong> Backing Chords </strong></div>
            </div>
                <div class='card-body graycard'>";

                echo "<span style='float:left;margin-left:20px;position:relative;bottom:7px;'>Chord Length : <select id='chordLength' >";
                echo "<option  name='chordLength' value='4' id='chordLength' checked> Whole";
                echo "<option  name='chordLength' value='2' id='chordLength'> Half";
                echo "</select></span>";

                echo "<span style='float:right;margin-right:10px;position:relative;bottom:7px;'>Chord type : <select class='form-select' style='margin-right:10px'  id='chordtype'>
                  <option selected> maj </option>
                  <option> min </option>
                  <option> maj7 </option>
                  <option> min7 </option>
                  <option> dom7 </option>
                  <option> min7b5 </option>
                  <option> 6 </option>
                  <option> maj9 </option>
                  <option> min9 </option>
                  <option> maj11 </option>
                  <option> min11 </option>
                </select></span>";


                echo "<div class='noterange-group'><div class='noterange title'> Key : 
                <select class='form-select' id='keyselector' onchange='populateNoteRange()'>
                <option selected> ALL </option>
                <option> Amaj/F#min </option>
                <option> A#maj/Gmin </option>
                <option> Bmaj/G#min </option>
                <option> Cmaj/Amin </option>
                <option> C#maj/A#min </option>
                <option> Dmaj/Bmin </option>
                <option> D#maj/Cmin </option>
                <option> Emaj/C#min </option>
                <option> Fmaj/Dmin </option>
                <option> F#maj/D#min </option>
                <option> Gmaj/Emin </option>
                <option> G#maj/Fmin </option>
                </select>
                 </div>


                <div class='noterange' id='keynoterange'>";


          echo "</div></div>
          <div margin-left:20px;'>

                Rythm type : <select class='form-select' id='rythmtype' style='margin-right:10px'>
                <option> Folk </option>
                <option> Folk2 </option>
                <option> Normal </option>
                <option selected> Once </option>
                <option> Arpeggio </option>
                <option> Travis </option>
                <option> Travis2 </option>
                </select>
                
               Percussion : <select class='form-select' id='percussiontype' style='margin-right:10px'>
                <option selected> None </option>
                <option> Metronome </option>
                <option> Simple </option>
                </select>

                
                </div>";

          echo "</div><div class='card-footer noBorder'>
                <div class='noterange noteplayer' id='playednote'>";
                if ($chordsToLoad<>"") {
                    $chordsToLoad=explode(",",$chordsToLoad);
                    foreach ($chordsToLoad as $onechord) {
                        $chordName=$onechord;

                        if ($chordName[1]=="X") $chordName=str_replace("X","#",$chordName);
                        if ($chordName[1]=="#") {
                            $chordValue=explode('#',$chordName);
                            $chordValue=$chordValue[0]."# ".$chordValue[1];
                        }
                        if ($chordName[1]<>"#") {
                            $chordValue=explode($chordName[0],$chordName);
                            $chordValue=$chordName[0]." ".$chordValue[1];
                        }

                       
                        echo "<span class='noteButton2Container chordsButton'>
                            <button value='".$chordValue."' class='btn btn-light  noteButton2' onclick='playMe(this)'>".$chordName."</button>
                            <button onclick=\"delNoteButton()\" class=\"btn btn-danger btn-sm deleteNoteButton\">X</button>
                        </span>";
                    }
                }

          echo "</div>
                </div>";

        echo "<div class ='card-header graycard><div class='card-title'><strong> Melody </strong></div>";
        echo "<div class='card-body graycard'>";
        echo "Note Length : <select id='noteLength' style='margin-right:10px'>";
        echo "<option  name='noteLength' value='4' id='noteLength' checked> Whole";
        //echo "<option  name='noteLength' value='3' id='noteLength' style='margin-left:20px'> 3/4";
        echo "<option  name='noteLength' value='2' id='noteLength' style='margin-left:20px'> Half";
        echo "<option  name='noteLength' value='1' id='noteLength' style='margin-left:20px'> Quarter";
        echo "<option  name='noteLength' value='05' id='noteLength' style='margin-left:20px'> Eigth";

        echo "</select>";
        echo "Octave <select id='noteOctave'>";
        echo "<option value=3 checked> 3";
        echo "<option value=4 checked> 4";
        echo "<option value=5 checked> 5";
        echo "</select>";
         echo "<div class='noterange' id='melodyRangePlayer'>";
            for ($i=0;$i<7;$i++) {
                echo "<button type='button' class='btn btn-light notebutton' onclick='addMelody(this)' value='$notes[$i]'>$notes[$i]</button>";
                if ($notes[$i]<>"B" and $notes[$i]<>"E") {
                    echo "<button type='button' class='btn btn-light notebutton' onclick='addMelody(this)' value='$notes[$i]#'>$notes[$i]#</button>";
                }
            }
            echo "<button type='button' class='btn btn-light notebutton' onClick='addMelody(this)' value='Rest'>Rest</button>";
            echo "</div>";
            
        echo "</div>";

        echo "<div class='card-footer graycard'>";
            echo "<div class='noterange noteplayer' id='melodyRange'>";
            if ($melodyToLoad<>"") {
                    $melodyToLoad=explode(",",$melodyToLoad);
                    foreach ($melodyToLoad as $onechord) {
                        $chordName=explode('/',$onechord)[1];
                        $chordLength=explode('/',$onechord)[0];
                        if ($chordLength=="4")$class="L4";
                        if ($chordLength=="3")$class="L3";
                        if ($chordLength=="2")$class="L2";
                        if ($chordLength=="1")$class="L1";
                        if ($chordLength=="05")$class="L05";

                        $chordName=str_replace("X","#",$chordName);

                       
                        echo "<span class='noteButton2Container ".$class."'>
                            <button value='".$chordLength."' class='btn btn-light noteButton2 ' onclick='playMeNote(this)'>".$chordName."</button>
                            <button onclick=\"delNoteButton()\" class=\"btn btn-danger btn-sm deleteNoteButton\">X</button>
                        </span>";
                    }
                }
       
            echo "</div>";
        echo "</div>";





        
        

          echo "<div class='card-footer noBorder end'>
                <span class='players'>
                <span><span class='volumeLabel'>Percussion</span><span  style='margin-right:10px'><input class='dial' id='volumeKnobPercussion' value='".$volumes[0]."'></span></span>

               <span><span class='volumeLabel'>Chords</span><span  style='margin-right:10px'><input class='dial' id='volumeKnob' value='".$volumes[1]."'></span></span>

                <span><span class='volumeLabel'>Melody</span><span  style='margin-right:10px'><input class='dial' id='volumeKnobMelody' value='".$volumes[2]."'></span></span>

                    <button type='button' id='playmusic' style='margin-top:-35px' class='btn btn-light'><i class='fas fa-play'></i></button>
                    <button type='button' id='stopmusic' style='display:none;margin-top:-35px' class='btn btn-light'><i class='fa fa-pause'></i></button>
                </span>

                
                BPM : <input type='range' min='60' max='200' id='bpmslider'> <span id='bpmcount'> 130</span>
                <span style ='float:left;margin-left:20px'>
                    <button type='button' id='trashchord' class ='btn btn-light'><i class='fas fa-trash'></i></button>
                    <button type='button' id='savechords' onClick='saveChords()' class ='btn btn-light'><i class='fas fa-save'></i></button>
                    <input type='text' size='20' maxlength='19' id='mySaveName' style ='position:relative;top:2px;height:30px;'value='MyChordProgression'>
                </span>
                </div></div>";


                echo "<button type='button' class='btn btn-danger' id='testsound'> TEST </button>";
?>
<script>
    var player;
    var loopers=[];
    var looper2=[];
    var looper3=[];
    var BPMset=<?php echo $BPM; ?>;
    var rythm = "<?php echo $rythm; ?>";
    var percussion ="<?php echo $percussion; ?>";
    populateNoteRange();

    if (BPMset!=0) {
        document.getElementById("bpmslider").value=BPMset;
        document.getElementById("bpmcount").textContent=BPMset;
    }

    if (rythm!="Once") {
        document.getElementById('rythmtype').value=rythm;
    }

    if (percussion!="false") {
        document.getElementById('percussiontype').value=percussion;
    }

    function populateNoteRange() {
        var key = document.getElementById('keyselector').value;
        var notes=["C","C#","D","D#","E","F","F#","G","G#","A","A#","B"];
        if (key=='ALL') {
            document.getElementById('keynoterange').innerHTML="";
            for (const element of notes) {
                var button=document.createElement('BUTTON');
                button.setAttribute("id",element);
                button.setAttribute("onclick","addNote(this)");
                button.innerHTML=element;
                button.classList.add('btn','btn-light','noteButton');
                document.getElementById('keynoterange').appendChild(button);
            }
            var button=document.createElement('BUTTON');
            button.setAttribute("onclick","addNote(this)");
            button.innerHTML="Rest";
            button.classList.add('btn','btn-light','noteButton');
            document.getElementById('keynoterange').appendChild(button);
        }
        else {
            if (key[1]=="#") {
                key=key[0]+key[1];
            }
            else {
                key=key[0];
            }
            var notesNb=[];
            var firstLetter = notes.indexOf(key);
            var firstnote = firstLetter;
            var secondnote=firstnote+2;
            var thirdnote=secondnote+2;
            var fourthnote=thirdnote+1;
            var fifthnote=fourthnote+2;
            var sixthnote=fifthnote+2;
            var seventhnote=sixthnote+2;

            /*if (notes[seventhnote%12][0]==notes[firstnote%12][0]) {
                console.log ("c pareil");
                seventhnote=seventhnote-1;
            }*/

            notesNb.push(firstnote);
            notesNb.push(secondnote);
            notesNb.push(thirdnote);
            notesNb.push(fourthnote);
            notesNb.push(fifthnote);
            notesNb.push(sixthnote);
            notesNb.push(seventhnote);

            document.getElementById('keynoterange').innerHTML="";

            for (const element of notesNb) {
                var button=document.createElement('BUTTON');
                button.setAttribute("id",notes[element%12]);
                button.setAttribute("onclick","addNote(this)");
                button.innerHTML=notes[element%12];
                button.classList.add('btn','btn-light','noteButton3');

                document.getElementById('keynoterange').appendChild(button);
            }
            var button=document.createElement('BUTTON');
            button.setAttribute("onclick","addNote(this)");
            button.innerHTML="Rest";
            button.classList.add('btn','btn-light','noteButton');
            document.getElementById('keynoterange').appendChild(button);
        }

    }

    function saveChords() {

        var chordTab = document.getElementById('playednote').children;
        var name = document.getElementById('mySaveName').value;
        var melodyTab=document.getElementById('melodyRange').children;
        var volumes=document.getElementById('volumeKnobPercussion').value+"/"+document.getElementById('volumeKnob').value+"/"+document.getElementById('volumeKnobMelody').value;

        if (chordTab.length==0 && melodyTab.length==0) {
            alert('Please select at least one chord/one note ! ');
            return;
        }

        var chordsToSave=[];
        var BPM=document.getElementById("bpmslider").value;
        var percussion=document.getElementById('percussiontype').value;
        var rythm = document.getElementById('rythmtype').value;
        for (const element of chordTab) {
            chord=element.children[0].value+"";
            chord=chord.replace(' ','');
            chord=chord.replace('#','X');
            chordsToSave.push(chord);
        }

        var melodyToSave=[];
        
        for (const element of melodyTab) {
            chord=element.children[0].value+"/"+element.children[0].innerHTML;
            chord=chord.replace(' ','');
            chord=chord.replace('#','X');
            melodyToSave.push(chord);
        }
        location.href="../fct/saveChords.php?chordsToSave[]="+chordsToSave+"&BPM="+BPM+"&name="+name+"&percussion="+percussion+"&rythm="+rythm+"&melody[]="+melodyToSave+"&volumes="+volumes;
    }

    function exportChords() {

        var chordTab = document.getElementById('playednote').children;
        var name = document.getElementById('mySaveName').value;
        var melodyTab=document.getElementById('melodyRange').children;

        if (chordTab.length==0 && melodyTab.length==0) {
            alert('Please select at least one chord/one note ! ');
            return;
        }

        var chordsToSave=[];
        var BPM=document.getElementById("bpmslider").value;
        var percussion=document.getElementById('percussiontype').value;
        var rythm = document.getElementById('rythmtype').value;
        for (const element of chordTab) {
            chord=element.children[0].value+"";
            chord=chord.replace(' ','');
            chord=chord.replace('#','X');
            chordsToSave.push(chord);
        }

        var melodyToSave=[];
        
        for (const element of melodyTab) {
            chord=element.children[0].value+"/"+element.children[0].innerHTML;
            chord=chord.replace(' ','');
            chord=chord.replace('#','X');
            melodyToSave.push(chord);
        }
        location.href="importexport.php?chordsToSave[]="+chordsToSave+"&BPM="+BPM+"&name="+name+"&percussion="+percussion+"&rythm="+rythm+"&melody[]="+melodyToSave;

    }

    function delNoteButton() {
      event.target.parentNode.remove();
    }

    document.getElementById("trashchord").onclick=function(){
        document.getElementById("playednote").innerHTML = "";
        document.getElementById("melodyRange").innerHTML = "";
        document.getElementById("bpmslider").value=130;
        document.getElementById("bpmcount").textContent=130;
        document.getElementById("percussiontype").value="None";
        document.getElementById("rythmtype").value="Once";
        document.getElementById("chordtype").value="maj";
    }

    document.getElementById("bpmslider").onchange=function(){
        var text = document.getElementById("bpmslider").value;
        var span=document.getElementById("bpmcount");
        span.textContent=text;

    }

    function getChordList() {
        var chordTab = document.getElementById('playednote').children;
        var notes=["C3","C#3","D3","D#3","E3","F3","F#3","G3","G#3","A3","A#3","B3","C4","C#4","D4","D#4","E4","F4","F#4","G4","G#4","A4","A#4","B4"];
        var chord;
        var basenote;
        var chordtype;
        var chordsToPlay=[];
        var BPM=document.getElementById("bpmslider").value;
        const now = Tone.now();
        var rythmtype=document.getElementById('rythmtype').value;

        for (const element of chordTab){
            chord=element.children[0].value+"";
            chordInner=element.children[0].innerHTML;
            console.log(chordInner);
            basenote=chord.split(" ")[0];
            chordtype=chord.split(" ")[1];
            if (chordInner=='Rest') {
                 var oneChordToPlay=["C0","C0","C0","C0"];
            }
            else {
                if (chordtype=="maj"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+4;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+12;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
                }
                if (chordtype=="min"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+3;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+12;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
                }
                if (chordtype=="maj7"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+4;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+11;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
                }
                if (chordtype=="min7"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+3;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+10;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
                }
                if (chordtype=="dom7"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+4;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+10;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
                }
                if (chordtype=="min7b5"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+3;
                    var thirdnote=firstnote+6;
                    var fourthnote=firstnote+10;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
                    console.log(oneChordToPlay);
                }
                if (chordtype=="6"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+4;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+9;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
                }
                if (chordtype=="maj9"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+4;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+11;
                    var fifthnote=firstnote+14;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24],notes[fifthnote%24]];
                }
                if (chordtype=="min9"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+3;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+9;
                    var fifthnote=firstnote+14;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24],notes[fifthnote%24]];
                }
                if (chordtype=="maj11"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+4;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+11;
                    var fifthnote=firstnote+17;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24],notes[fifthnote%24]];
                }
                if (chordtype=="min11"){
                    var firstnote=notes.indexOf(basenote+"3");
                    var secondnote=firstnote+3;
                    var thirdnote=firstnote+7;
                    var fourthnote=firstnote+10;
                    var fifthnote=firstnote+17;
                    var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24],notes[fifthnote%24]];
                }
            }
            chordsToPlay.push(oneChordToPlay);
        }
         //console.log(chordsToPlay);
         const synth = new Tone.PolySynth().toDestination();
         var Time=new Tone.Time("4n");
         var Time2=new Tone.Time("8n");
         var compteur = 0;
         Tone.Transport.bpm.value=BPM;
         
         for (const element of chordsToPlay) {
            if (rythmtype=="Folk") {
                loopers[compteur] = new Tone.Loop(function(time) {
                synth.triggerAttackRelease(element,Time);
                synth.triggerAttackRelease(element,Time,"+"+Time);
                synth.triggerAttackRelease(element,Time,"+"+(Time*2.5));
                synth.triggerAttackRelease(element,Time,"+"+(Time*3));
                synth.triggerAttackRelease(element,Time,"+"+(Time*3.5));

                }, 4*Time*chordsToPlay.length).start(4*Time*compteur);
                compteur++;
            }
            if (rythmtype=="Normal") {
                loopers[compteur] = new Tone.Loop(function(time) {
                synth.triggerAttackRelease(element,Time/2);
                synth.triggerAttackRelease(element,Time/2,"+"+Time);
                synth.triggerAttackRelease(element,Time/2,"+"+(Time*2));
                synth.triggerAttackRelease(element,Time/2,"+"+(Time*3));


                }, 4*Time*chordsToPlay.length).start(4*Time*compteur);
                compteur++;
            }
            if (rythmtype=="Folk2") {
                loopers[compteur] = new Tone.Loop(function(time) {
                synth.triggerAttackRelease(element,Time);
                synth.triggerAttackRelease(element,Time,"+"+Time);
                synth.triggerAttackRelease(element,Time,"+"+(Time*1.5));
                synth.triggerAttackRelease(element,Time,"+"+(Time*2.5));
                synth.triggerAttackRelease(element,Time,"+"+(Time*3));
                synth.triggerAttackRelease(element,Time,"+"+(Time*3.5));


                }, 4*Time*chordsToPlay.length).start(4*Time*compteur);
                compteur++;
            }
            if (rythmtype=="Once") {
                loopers[compteur] = new Tone.Loop(function(time) {
                synth.triggerAttackRelease(element,Time*4);

                }, 4*Time*chordsToPlay.length).start(4*Time*compteur);
                compteur++;
            }
            if (rythmtype=="Arpeggio"){
                loopers[compteur] = new Tone.Loop(function(time) {
                synth.triggerAttackRelease(element[0],Time);
                synth.triggerAttackRelease(element[1],Time,"+"+Time);
                synth.triggerAttackRelease(element[2],Time,"+"+(Time*2));
                synth.triggerAttackRelease(element[3],Time,"+"+(Time*3));

                }, 4*Time*chordsToPlay.length).start(4*Time*compteur);
                compteur++;
            }
            if(rythmtype=='Travis'){
                loopers[compteur] = new Tone.Loop(function(time) {
                synth.triggerAttackRelease(element[0],Time);
                synth.triggerAttackRelease(element[1],Time,"+"+Time*1);
                synth.triggerAttackRelease(element[2],Time,"+"+(Time*1.5));
                synth.triggerAttackRelease(element[0],Time,"+"+(Time*2));
                synth.triggerAttackRelease(element[3],Time,"+"+(Time*2.5));
                synth.triggerAttackRelease(element[1],Time,"+"+(Time*3));
                synth.triggerAttackRelease(element[2],Time,"+"+(Time*3.5));

                }, 4*Time*chordsToPlay.length).start(4*Time*compteur);
                compteur++;

            }
            if(rythmtype=='Travis2'){
                loopers[compteur] = new Tone.Loop(function(time) {
                synth.triggerAttackRelease(element[0],Time);
                synth.triggerAttackRelease(element[2],Time,"+"+Time*0.5);
                synth.triggerAttackRelease(element[1],Time,"+"+(Time*1));
                synth.triggerAttackRelease(element[3],Time,"+"+(Time*1.5));
                synth.triggerAttackRelease(element[0],Time,"+"+(Time*2));
                synth.triggerAttackRelease(element[2],Time,"+"+(Time*2.5));
                synth.triggerAttackRelease(element[1],Time,"+"+(Time*3));
                synth.triggerAttackRelease(element[3],Time,"+"+(Time*3.5));

                }, 4*Time*chordsToPlay.length).start(4*Time*compteur);
                compteur++;

            }
         }
         var percussiontype=document.getElementById('percussiontype').value;
         const percu = new Tone.MembraneSynth().toDestination();
        if (percussiontype!="None"){
            if (percussiontype=="Metronome") {
                looper2=new Tone.Loop(function(time) {
                    percu.triggerAttackRelease("C1", "4n");
                }, Time).start(0);
            }
            if (percussiontype=="Simple") {
                looper2=new Tone.Loop(function(time) {
                    percu.triggerAttackRelease("C0", "8n");
                    percu.triggerAttackRelease("C1", "8n", "+"+Time2);
                    percu.triggerAttackRelease("C0", "8n", "+"+Time*2);
                    percu.triggerAttackRelease("C0", "8n", "+"+Time*3);
                    percu.triggerAttackRelease("C1", "8n", "+"+Time*3.5);
                }, Time*4).start(0);
            }
        }

        let playing = false;
        synth.volume.value=document.getElementById('volumeKnob').value/10;
        percu.volume.value=document.getElementById('volumeKnobPercussion').value/3;

        var melodyTab=document.getElementById('melodyRange').children;
        var notesToPlay=[];
        /*for (const element2 of melodyTab){
            var note=element2.children[0].innerHTML+"";
            var noteLength=element2.children[0].value;
            var toPush=note+" "+noteLength;
            notesToPlay.push(toPush);
        }*/

        var melodyPlayer=new Tone.PolySynth().toDestination();

        var totalTime=new Tone.Time("1m");
        var noteLength2;
        var noteLengthyplar="0m";
        var multiplicator=0;
        //looper3=new Tone.Loop(function(time) {

                for (const element2 of melodyTab){
                    var note=element2.children[0].innerHTML+"";
                    if (note=='Rest') {
                        note='C0';
                    }
                    console.log(note);
                    var noteLength=element2.children[0].value;
                    if (noteLength=="4") {
                        noteLength2='1m';
                    }
                    if (noteLength=="3") {
                        noteLength2='0.75m';
                    }
                    if (noteLength=="2") {
                        noteLength2='2n';
                    }
                    if(noteLength=='1'){
                        noteLength2="4n";
                    }
                    if (noteLength=='05'){
                        noteLength2="8n";
                    }
                    melodyPlayer.triggerAttackRelease(note, noteLength2,"+"+totalTime*multiplicator);

                    if (noteLength=="4") {
                        multiplicator=multiplicator+1;
                    }
                    if (noteLength=="3") {
                        multiplicator=multiplicator+0.75;
                    }
                    if (noteLength=="2") {
                        multiplicator=multiplicator+0.5;
                    }
                    if(noteLength=='1'){
                        multiplicator=multiplicator+0.25;
                    }
                    if (noteLength=='05'){
                        multiplicator=multiplicator+0.125;
                    }
                    //totalTime=totalTime+"+"+noteLength2;

                    //console.log(noteLengthyplar);
            }

                   
        //}, totalTime*multiplicator).start(0);

        looper3.interval=totalTime*multiplicator;


        melodyPlayer.volume.value=document.getElementById('volumeKnobMelody').value/10;

        
    }


    document.getElementById('playmusic').onclick=function(){
       /* if (document.getElementById('playednote').children.length==0) {
            alert ("Please choose a chord");
            return;
        }*/
        document.getElementById('stopmusic').style.display='';
        this.style.display='none';
        getChordList();
        Tone.Transport.start();
    }

     document.getElementById('stopmusic').onclick=function(){
         document.getElementById('playmusic').style.display='';
        this.style.display='none';
        Tone.Transport.stop();
        for (const element of loopers){
            element.dispose();
        }
        looper2.dispose();
        looper3.dispose();
        melodyPlayer.dispose();
        for (const element of looper2){
            element.dispose();
        }
        for (const element of looper3){
            element.dispose();
        }


    }

    document.getElementById('mySaveName').onfocus=function(){
        if (this.value=="MyChordProgression") {
            this.value="";
        }

    }

    document.getElementById('mySaveName').onfocusout=function(){
        if (this.value=="") {
            this.value="MyChordProgression";
        }

    }

    document.getElementById("mySaveName").onkeypress = function(event) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
    };

    $(function(){
        $(".dial").knob({
            'height':40,
            'width':40,
            'max':50,
            'min':-50,
            'fgColor':'black'

        });
    });

    function playMe(button) {
        var notes=["A3","A#3","B3","C3","C#3","D3","D#3","E3","F3","F#3","G3","G#3","A4","A#4","B4","C4","C#4","D4","D#4","E4","F4","F#4","G4","G#4"];
        var chord=button.value+"";
        console.log(button.value);
        var basenote=chord.split(" ")[0];
        var chordtype=chord.split(" ")[1];

            if (chordtype=="maj"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+4;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+12;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
            }
            if (chordtype=="min"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+3;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+12;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
            }
            if (chordtype=="maj7"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+4;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+11;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
            }
            if (chordtype=="min7"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+3;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+10;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
            }
            if (chordtype=="dom7"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+4;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+10;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
            }
            if (chordtype=="min7b5"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+3;
                var thirdnote=firstnote+6;
                var fourthnote=firstnote+10;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
            }
            if (chordtype=="6"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+4;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+9;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24]];
            }
            if (chordtype=="maj9"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+4;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+11;
                var fifthnote=firstnote+14;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24],notes[fifthnote%24]];
            }
            if (chordtype=="min9"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+3;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+9;
                var fifthnote=firstnote+14;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24],notes[fifthnote%24]];
            }
            if (chordtype=="maj11"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+4;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+11;
                var fifthnote=firstnote+17;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24],notes[fifthnote%24]];
            }
            if (chordtype=="min11"){
                var firstnote=notes.indexOf(basenote+"3");
                var secondnote=firstnote+3;
                var thirdnote=firstnote+7;
                var fourthnote=firstnote+10;
                var fifthnote=firstnote+17;
                var oneChordToPlay=[notes[firstnote%24],notes[secondnote%24],notes[thirdnote%24],notes[fourthnote%24],notes[fifthnote%24]];
            }

        const synth = new Tone.PolySynth().toDestination();
        synth.triggerAttackRelease(oneChordToPlay,"4n");

    }

    function playMeNote(hello){
        var note=hello.innerHTML;
        console.log(note);
        const synthy = new Tone.PolySynth().toDestination();
        synthy.triggerAttackRelease(note,"4n");


    }


    document.getElementById('testsound').onclick=function(){
        var Time=new Tone.Time("4n");
        const synth = new Tone.PolySynth().toDestination();
        var element =["C0"];
                synth.triggerAttackRelease(element[0],"64n");

        Tone.Transport.start();

    }

    function addNote(button) {

        var ok = button.innerHTML;
        var chordtype=document.getElementById("chordtype").value;
        var playednote=document.getElementById("playednote");
        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");
        var texty =ok;
        if (texty=='Rest') {
            var text = document.createTextNode(texty);
            button.setAttribute("value",texty);
        }
        else {
            var text = document.createTextNode(texty+chordtype);
            button.setAttribute("value",texty+" "+chordtype);
        }
        
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));
        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container','chordsButton');
        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    }

    function addMelody(hello) {
        var length=document.getElementById("noteLength").value;
        var playednote=document.getElementById("melodyRange");
        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        var noteOctave=document.getElementById('noteOctave').value;

        buttondel.setAttribute("onclick","delNoteButton()");

        var texty =hello.value;
        if (texty == "Rest") {
            var text = document.createTextNode("Rest");
        }
        else {
            var text = document.createTextNode(texty+noteOctave);
        }
        button.setAttribute("value",length);
        button.setAttribute('onClick','playMeNote(this)');
        button.appendChild(text);

        buttondel.appendChild(document.createTextNode("X"));
        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton');
        button.classList.add('btn','btn-light','noteButton2');
        if (length=="4") { 
            buttondiv.classList.add('L4');
        }
        if (length=="3") { 
            buttondiv.classList.add('L3');
        }
        if (length=="2") { 
            buttondiv.classList.add('L2');
        }
        if (length=="1") { 
            buttondiv.classList.add('L1');
        }
        if (length=="05") { 
            buttondiv.classList.add('L05');
        }
        buttondiv.classList.add('noteButton2Container');
        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    }
    


</script>