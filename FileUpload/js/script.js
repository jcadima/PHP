
  $("#fileimage").change(function() {

      var fileList = this.files;
      var w = window.URL || window.webkitURL;

      for(var i = 0; i < fileList.length; i++) {
        var objectUrl = w.createObjectURL(fileList[i]);
        $('.preview-area').append('<img height="200" src="' + objectUrl + '" />');
        window.URL.revokeObjectURL(fileList[i]);
      }
  });


