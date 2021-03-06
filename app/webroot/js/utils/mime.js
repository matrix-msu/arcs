// Generated by CoffeeScript 1.10.0
(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  arcs.utils.mime = arcs.mime = {
    imageTypes: function() {
      return {
        'image/png': 'png',
        'image/jpeg': 'jpeg',
        'image/jpg': 'jpg',
        'image/gif': 'gif',
        'image/tiff': 'tiff'
      };
    },
    documentTypes: function() {
      return {
        'application/pdf': 'pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 'docx',
        'application/msword': 'doc',
        'text/plain': 'plaintext',
        'text/richtext': 'richtext',
        'text/rtf': 'rtf'
      };
    },
    videoTypes: function() {
      return {
        'video/mpeg': 'mpeg',
        'video/msvideo': 'avi',
        'video/quicktime': 'mov',
        'video/mp4': 'mp4'
      };
    },
    isDocument: function(mime) {
      return indexOf.call(_.keys(this.documentTypes), mime) >= 0;
    },
    isImage: function(mime) {
      return indexOf.call(_.keys(this.imageTypes), mime) >= 0;
    },
    isVideo: function(mime) {
      return indexOf.call(_.keys(this.videoTypes), mime) >= 0;
    },
    types: function() {
      return _.extend(this.videoTypes, this.documentTypes, this.imageTypes);
    },
    getInfo: function(mime) {
      var obj, result, type, types, undef;
      undef = {
        type: 'undefined',
        ext: null
      };
      types = {
        image: this.imageTypes,
        document: this.documentTypes,
        video: this.videoTypes
      };
      for (type in types) {
        obj = types[type];
        if (indexOf.call(_.keys(types[type]), mime) >= 0) {
          result = {
            type: type,
            ext: types[type][mime]
          };
        }
      }
      return result || undef;
    }
  };

  _.bindAll(arcs.utils.mime, 'imageTypes', 'documentTypes', 'videoTypes', 'isDocument', 'isImage', 'isVideo', 'types', 'getInfo');

}).call(this);
