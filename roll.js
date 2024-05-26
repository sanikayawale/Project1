var imageBar = document.getElementById('imageBar');
    var images = imageBar.getElementsByTagName('img');
    var currentIndex = 0;

    function showImage(index) {
      for (var i = 0; i < images.length; i++) {
        if (i === index) {
          images[i].style.display = 'inline-block';
        } else {
          images[i].style.display = 'none';
        }
      }
    }

    function showNextImage() {
      currentIndex = (currentIndex + 1) % images.length;
      showImage(currentIndex);
    }

    function showPreviousImage() {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      showImage(currentIndex);
    }

    var prevButton = document.getElementById('prevButton');
    var nextButton = document.getElementById('nextButton');

    prevButton.addEventListener('click', showPreviousImage);
    nextButton.addEventListener('click', showNextImage);