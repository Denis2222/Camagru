(function() {
    //DISABLE RIGHT CLICK
    document.body.oncontextmenu = function(){return false;}

    var streaming = false,
        video = document.querySelector('#video'),
        cover = document.querySelector('#cover'),
        cam   = document.querySelector('#cam'),
        canvas = document.querySelector('#canvas'),
        photo = document.querySelector('#photo'),
        startbutton = document.querySelector('#startbutton'),
        width = 640,
        height = 480,
        imgs = document.getElementsByClassName('toy');

    var imgSelected;
    var scale;

    navigator.getMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    var cumulativeOffset = function(element) {
        var top = 0, left = 0;
        do {
            top += element.offsetTop  || 0;
            left += element.offsetLeft || 0;
            element = element.offsetParent;
        } while(element);

        return {
            top: top,
            left: left
        };
    };

    function mouseUp() {
      console.log("mouseUp");
        window.removeEventListener('mousemove', divMove, true);
        window.removeEventListener('mousemove', divMoveWidth, true);

        if (imgSelected) {
          console.log(cumulativeOffset(video));
          console.log(cumulativeOffset(imgSelected));

          if (cumulativeOffset(imgSelected).left > 600 )
          {
            imgSelected.removeEventListener('mousedown', mouseDown, false);
            imgSelected.removeEventListener('mouseup', mouseDown, false);
            imgSelected.parentNode.removeChild(imgSelected);
          }
          imgSelected = null;
        }
        takepicture();
    }

    function handler(event) {
         event = event || window.event;

         if (event.stopPropagation)
             event.stopPropagation();

         event.cancelBubble = true;
         return false;
     }

    function mouseDown(e) {
      console.log(e.which);

      e.preventDefault();

      handler(e);
      var div = e.target;
      imgSelected = div;
      offY= e.clientY-parseInt(div.offsetTop);
      offX= e.clientX-parseInt(div.offsetLeft);
      if (e.which == 1)
        window.addEventListener('mousemove', divMove, true);
      scale = (e.clientX-offX);
      if (e.which == 3)
        window.addEventListener('mousemove', divMoveWidth, true);
    }

    function divMove(e) {
      var div = imgSelected;
      div.style.top = (e.clientY-offY) + 'px';
      div.style.left = (e.clientX-offX) + 'px';
    }

    function divMoveWidth(e) {
      console.log("moveWidth");
      var div = imgSelected;

      console.log((e.clientX-offX));
      div.style.width = div.clientWidth+(e.clientX-offX-scale)/10 + 'px';
    }

    for (var i = 0; i < imgs.length; i++) {
        imgs.item(i).addEventListener('mousedown', mouseDown, false);
        window.addEventListener('mouseup', mouseUp, false);
    }

    function addtoy(e) {
      e.preventDefault();
      var elem = e.target;
      var newelem = elem.cloneNode(true);

      newelem.className = "toy";
      newelem.style.position = "absolute";
      newelem.style.top = "0px";
      newelem.style.left = "0px";
      newelem.style.width = "80px";
      newelem.addEventListener('mousedown', mouseDown, false);
      newelem.addEventListener('mouseup', mouseUp, false);
      cam.appendChild(newelem);
    }

    var addables = document.getElementsByClassName('addabletoy');
    for (var i = 0; i < addables.length; i++) {
        addables.item(i).addEventListener('click', addtoy, false);
    }

    navigator.getMedia({
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
            photo.style.visibility = 'hidden';
        },
        function(err) {

          console.log("An error occured! " , err);
        }
    );

    video.addEventListener('canplay', function(ev) {
      photo.parentNode.removeChild(photo);
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = false;
        }
    }, false);

    function takepicture() {

      var toys = document.getElementsByClassName('toy');

        if (toys.length == 0) {
          alert("Minimum une image");
          return (0);
        }
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);

        function getStyle(elem,type) {
          return parseInt(elem.style[type]);
        }
        var tab = [];
        for (var i = 0; i < toys.length; i++) {
          var toy = {
            top:parseInt(toys.item(i).style.top),
            left:parseInt(toys.item(i).style.left),
            width:parseInt(toys.item(i).style.width),
            src:toys.item(i).src
          }
          tab.push(toy);
        }
        console.log(tab);
        document.querySelector("#jsoncache").value = JSON.stringify(tab);
        document.querySelector("#postcache").value = canvas.toDataURL('image/png');
    }
})();
