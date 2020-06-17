URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording
var counterClick = 0;
var secondAudioRecord = 0;

var base = 60;
var clocktimer,dateObj,dh,dm,ds,ms;
var h=1,m=1,tm=1,s=0,ts=0,ms=0,init=0;

var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record
var record_control = document.getElementById('record-control');
var record_panel = document.getElementById('record-panel');

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var cancelButton = document.getElementById("cancelButton");
var deleteButton = document.getElementById("deleteButton");

recordButton.addEventListener("mouseup", startRecording);
stopButton.addEventListener("mouseup", stopRecording);
cancelButton.addEventListener("mouseup", cancelRecording);
deleteButton.addEventListener("mouseup", deleteRecording);

function startRecording() {
    var constraints = { audio: true, video:false }

    recordButton.disabled = false;

    navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
        if (counterClick) {
            audioContext = new AudioContext();

            gumStream = stream;

            input = audioContext.createMediaStreamSource(stream);

            rec = new Recorder(input, {numChannels: 1})

            //start the recording process
            rec.record()

	        startStop();

	        record_control.classList.add("active");
        }

        counterClick++;
    }).catch(function(err) {
        recordButton.disabled = false;
    });
}

function pauseRecording(){
    if (counterClick) {
        if (rec.recording) {
            //pause
            rec.stop();
            pauseButton.innerHTML = "Resume";
        } else {
            //resume
            rec.record()
            pauseButton.innerHTML = "Pause";

        }
    }
}

function stopRecording() {
    if (counterClick) {
        console.log("stopButton clicked");

        recordButton.disabled = false;

        rec.stop();

        gumStream.getAudioTracks()[0].stop();

        rec.exportWAV(createDownloadLink);

	    clearClock();

	    record_panel.classList.add('active');
    }
}

function cancelRecording() {
	stopRecording();
	deleteRecording();
}

function createDownloadLink(blob) {
    let url = URL.createObjectURL(blob);
    let au = document.createElement('audio');
    let div = document.createElement('div');
    let filename = new Date().toISOString() + sendingData.thread_id + '_' + sendingData.user_id;

    au.controls = true;
    au.src = url;

    div.appendChild(au);

    let xhr = new XMLHttpRequest();
    let fd = new FormData();
    fd.append("audio_data", blob, filename);
    xhr.open("POST", upload_file,true);
    xhr.onload=function(e) {
        if(this.readyState === 4) {
            sendingData.audio = filename + ".wav";
            sendingData.timing = secondAudioRecord;
        }
    };
    xhr.send(fd);

    //add the li element to the ol
    recordingsList.innerHTML = "";
    recordingsList.appendChild(div);
}

function deleteRecording() {
	setTimeout(async function(){
		let audio = record_panel.querySelector('audio');
		if (!audio.paused) {
			audio.pause();
			audio.currentTime = 0;
		}
	}, 1000);

	record_control.classList.remove('active');
	record_panel.classList.remove('active');

}

//функция для старта секундомера
function startTime() {
	if (secondAudioRecord === 30) {
		stopRecording();
	} else {
		let cdateObj = new Date();
		let t = (cdateObj.getTime() - dateObj.getTime())-(s*1000);

		if (t>999) { s++; }

		if (s>=(m*base)) {
			ts=0;
			m++;
		} else {
			ts=parseInt((ms/100)+s);
			if(ts>=base) { ts=ts-((m-1)*base); }
		}
		if (m>(h*base)) {
			tm=1;
			h++;
		} else {
			tm=parseInt((ms/100)+m);
			if(tm>=base) { tm=tm-((h-1)*base); }
		}
		ms = Math.round(t/10);
		if (ms>99) {ms=0;}
		if (ms===0) {ms='00';}
		if (ms>0&&ms<=9) { ms = '0'+ms; }
		if (ts>0) { ds = ts; if (ts<10) { ds = '0'+ts; }} else { ds = '00'; }

		secondAudioRecord = ds;

		document.getElementById('timing').innerText = ds + ',' + ms;
		clocktimer = setTimeout("startTime()",1);
	}
}

//Функция запуска и остановки
function startStop() {
	clearClock();
	dateObj = new Date();
	startTime();
}
//функция для очистки поля
function clearClock() {
	clearTimeout(clocktimer);
	s=0;ts=0;ms=0;secondAudioRecord = 0;
	document.getElementById('timing').innerText = '0,00';
}