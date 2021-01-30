<script>
  
</script>

<?php


include("../fct/fonctions.php");
$notes=["A","B","C","D","E","F","G"];
writehead();
if (!isset($_SESSION['login'])) header("Location: ../page/login.php");
if (isset($_GET['BPM'])) $BPM=$_GET['BPM'];
else $BPM=0;
if (isset($_GET['chordsToLoad'])) $chordsToLoad=$_GET['chordsToLoad'];
else $chordsToLoad="";
if (isset($_GET['percussion'])) $percussion=$_GET['percussion'];
else $percussion="false";
if (isset($_GET['rythm'])) $rythm=$_GET['rythm'];
else $rythm="Folk";

    echo "<div class='graydisplay'><div align=center> Hello ".$_SESSION['login']." !</div>
    <button type='button' class='btn btn-light' style ='width:80px'onclick='location.href=\"../page/savedChords.php\"'>Load</button><br>
    <button type='button' class='btn btn-light' style='margin-top:10px;width:80px' onclick='location.href=\"../fct/disconnect.php\"'>Logout</button></div>";

    echo "<div class='container-fluid' align=center style='display:inline-block;'>
                <div class='col-sm-8' style='position:relative;top:-140px;' align=center>
                    <div class='card hide card-default graycarddefault' align=center style=''>
            <div class='card-header graycard'>
            <div class='card-title'><strong> Music tab </strong></div>
            </div>
                <div class='card-body graycard'>
                <div style='float:left;bottom:10px;margin-left:20px;position: relative;'>
               Chord type : <select class='form-select' style='margin-right:10px'  id='chordtype'>
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
                </select>
                Rythm type : <select class='form-select' id='rythmtype'>
                <option selected> Folk </option>
                <option> Folk2 </option>
                <option> Normal </option>
                <option> Once </option>
                </select>
                </div>
               <div style='float:right;margin-right:20px;position:relative;bottom:10px'>
               Percussion : <input type='checkbox' id='percussion' style='margin-right:10px'>
                 BPM : <input type='range' min='60' max='200' id='bpmslider'> <span id='bpmcount'> 130</span>
                </div>

                <div class='noterange-group'><div class='noterange title'> Chords </div>
                <div class='noterange'>";

          for ($i=0;$i<7;$i++){
            echo "<button type='button' id = \"$notes[$i]\"  class='btn btn-light noteButton'>$notes[$i]</button>";
            if ($notes[$i]<>"B" and $notes[$i]<>"E") echo "<button type='button' id = '$notes[$i]#' class='btn btn-light  noteButton'>$notes[$i]#</button>";
          }

          echo "</div></div></div><div class='card-footer noBorder'>
                <div class='noterange noteplayer' id='playednote'>";
                if ($chordsToLoad<>"") {
                    $chordsToLoad=explode(",",$chordsToLoad);
                    foreach ($chordsToLoad as $onechord) {
                        $chordName=$onechord;

                        if ($chordName[1]=="d") $chordName=str_replace("d","#",$chordName);
                        if ($chordName[1]=="#") {
                            $chordValue=explode('#',$chordName);
                            $chordValue=$chordValue[0]."# ".$chordValue[1];
                        }
                        if ($chordName[1]<>"#") {
                            $chordValue=explode($chordName[0],$chordName);
                            $chordValue=$chordName[0]." ".$chordValue[1];
                        }

                       
                        echo "<span class='noteButton2Container'>
                            <button value='".$chordValue."' class='btn btn-light  noteButton2'>".$chordName."</button>
                            <button onclick=\"delNoteButton()\" class=\"btn btn-danger btn-sm deleteNoteButton\">X</button>
                        </span>";
                    }
                }

          echo "</div>
                </div>";

          echo "<div class='card-footer noBorder end'>
                <span class='players'>
                <span  style='margin-right:10px'><input class='dial' id='volumeKnob' value='0'></span>
                    <button type='button' id='playmusic' style='margin-top:-35px' class='btn btn-light'><i class='fas fa-play'></i></button>
                    <button type='button' id='stopmusic' style='display:none;margin-top:-35px' class='btn btn-light'><i class='fa fa-pause'></i></button>
                </span>

                

                <span style ='float:left;margin-left:20px'>
                    <button type='button' id='trashchord' class ='btn btn-light'><i class='fas fa-trash'></i></button>
                    <button type='button' id='savechords' onClick='saveChords()' class ='btn btn-light'><i class='fas fa-save'></i></button>
                    <input type='text' size='20' maxlength='19' id='mySaveName' style ='position:relative;top:2px;height:30px;'value='MyChordProgression'>
                </span>
                </div></div>
                 ";

?>



<script>
    var player;
    var loopers=[];
    var looper2;
    var BPMset=<?php echo $BPM; ?>;
    var rythm = "<?php echo $rythm; ?>";
    var percussion ="<?php echo $percussion; ?>";

    if (BPMset!=0) {
        document.getElementById("bpmslider").value=BPMset;
        document.getElementById("bpmcount").textContent=BPMset;
    }

    if (rythm!="Folk") {
        document.getElementById('rythmtype').value=rythm;
    }

    if (percussion!="false") {
        document.getElementById('percussion').checked=true;
    }



    function saveChords() {

        var chordTab = document.getElementById('playednote').children;
        var name = document.getElementById('mySaveName').value;

        if (chordTab.length==0) {
            alert('Please select at least one chord ! ');
            return;
        }

        var chordsToSave=[];
        var BPM=document.getElementById("bpmslider").value;
        var percussion=document.getElementById('percussion').checked;
        var rythm = document.getElementById('rythmtype').value;
        for (const element of chordTab) {
            chord=element.children[0].value+"";
            chord=chord.replace(' ','');
            chord=chord.replace('#','d');
            chordsToSave.push(chord);
        }
        location.href="../fct/saveChords.php?chordsToSave[]="+chordsToSave+"&BPM="+BPM+"&name="+name+"&percussion="+percussion+"&rythm="+rythm;
    }

    function delNoteButton() {
      event.target.parentNode.remove();
    }

    document.getElementById("trashchord").onclick=function(){
        document.getElementById("playednote").innerHTML = "";
        document.getElementById("bpmslider").value=130;
        document.getElementById("bpmcount").textContent=130;
        document.getElementById("percussion").checked=false;
        document.getElementById("rythmtype").value="Folk";
        document.getElementById("chordtype").value="maj";
    }

    document.getElementById("bpmslider").onchange=function(){
        var text = document.getElementById("bpmslider").value;
        var span=document.getElementById("bpmcount");
        span.textContent=text;

    }

    function getChordList() {
        var chordTab = document.getElementById('playednote').children;
        var notes=["A3","A#3","B3","C3","C#3","D3","D#3","E3","F3","F#3","G3","G#3","A4","A#4","B4","C4","C#4","D4","D#4","E4","F4","F#4","G4","G#4"];
        var chord;
        var basenote;
        var chordtype;
        var chordsToPlay=[];
        var BPM=document.getElementById("bpmslider").value;
        const now = Tone.now();
        var rythmtype=document.getElementById('rythmtype').value;

        for (const element of chordTab){
            chord=element.children[0].value+"";
            basenote=chord.split(" ")[0];
            chordtype=chord.split(" ")[1];

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
            chordsToPlay.push(oneChordToPlay);
        }
        console.log(chordsToPlay);
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
                synth.triggerAttackRelease(element,Time);
                synth.triggerAttackRelease(element,Time,"+"+Time);
                synth.triggerAttackRelease(element,Time,"+"+(Time*2));
                synth.triggerAttackRelease(element,Time,"+"+(Time*3));


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
         }
        if (document.getElementById('percussion').checked==true){
                const percu = new Tone.MembraneSynth().toDestination();
                looper2=new Tone.Loop(function(time) {
                    percu.triggerAttackRelease("C1", "8n");
                }, Time).start(0);
                percu.volume.value=(document.getElementById('volumeKnob').value/10)*2;
        }

        let playing = false;
        synth.volume.value=document.getElementById('volumeKnob').value/10;
        Tone.Transport.start();
    }


    document.getElementById('playmusic').onclick=function(){
        if (document.getElementById('playednote').children.length==0) {
            alert ("Please choose a chord");
            return;
        }
        document.getElementById('stopmusic').style.display='';
        this.style.display='none';
        getChordList();
    }

     document.getElementById('stopmusic').onclick=function(){
         document.getElementById('playmusic').style.display='';
        this.style.display='none';
        Tone.Transport.stop();
        for (const element of loopers){
            element.dispose();
        }
        looper2.dispose();

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

        const synth = new Tone.PolySynth().toDestination();
        synth.triggerAttackRelease(oneChordToPlay,"4n");
    }


</script>










































<script>
     document.getElementById("A").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("A").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;

    document.getElementById("A#").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("A#").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("B").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("B").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("C").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("C").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("C#").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("C#").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("D").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("D").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    };
     document.getElementById("D#").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("D#").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("E").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("E").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("F").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("F").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("F#").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("F#").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("G").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("G").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    } ;
    document.getElementById("G#").onclick=function(){
        var chordtype=document.getElementById("chordtype").value;

        var playednote=document.getElementById("playednote");

        var button = document.createElement('BUTTON');
        var buttondiv=document.createElement('SPAN');
        var buttondel=document.createElement('BUTTON');
        buttondel.setAttribute("onclick","delNoteButton()");
        button.setAttribute("onclick","playMe(this)");

        var texty =document.getElementById("G#").id;
        var text = document.createTextNode(texty+chordtype);

        button.setAttribute("value",texty+" "+chordtype);
        button.appendChild(text);
        buttondel.appendChild(document.createTextNode("X"));

        buttondel.classList.add('btn','btn-danger','btn-sm','deleteNoteButton'); 
        button.classList.add('btn','btn-light','noteButton2');
        buttondiv.classList.add('noteButton2Container');


        buttondiv.appendChild(button);
        buttondiv.appendChild(buttondel);
        playednote.appendChild(buttondiv);
    }
</script>















