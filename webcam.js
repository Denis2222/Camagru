(function() {


var offset;

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width 	   = 320,
      height       = 0,
	  imgs         = document.getElementsByClassName('toy');

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

						 console.log(imgs);


 for(var i = 0; i < imgs.length; i++)
 {
    imgs.item(i).addEventListener('dragstart', function(e) {
		console.log(e.target);
		var style = window.getComputedStyle(e.target, null);
		console.log(style);
		offset = (parseInt(style.getPropertyValue("left"),10) - e.clientX) + ',' + (parseInt(style.getPropertyValue("top"),10) - e.clientY);


		console.log(e.clientX);
	    console.log(e.clientY);
		//console.log(e);
    });

	imgs.item(i).addEventListener('dragend', function(e) {
		offset = offset.split(',');
		console.log(offset);
		var dm = e.target;
		console.log(dm);
	    dm.style.left = (e.clientX + parseInt(offset[0],10)) + 'px';
	    dm.style.top = (e.clientY + parseInt(offset[1],10)) + 'px';

		console.log(e.clientX);
	    console.log(e.clientY);
    });
 }

 video.addEventListener('dragover', function(e) {
	 //console.log("Je passe sur la video");
	 //console.log(e);
    e.preventDefault(); // Annule l'interdiction de drop
});

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = false;
    }
  }, false);

  function takepicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	canvas.getContext('2d').drawImage(document.getElementById("dino"), 10, 10, 200, 200);
    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
	document.querySelector("#postcache").value = data;
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);

})();
