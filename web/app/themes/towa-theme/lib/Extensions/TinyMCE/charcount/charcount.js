/* eslint-disable */
(function() {
  var charcount = (function() {
    "use strict";

    var global = tinymce.util.Tools.resolve("tinymce.PluginManager");

    function decodeHtml(html) {
      var txt = document.createElement("textarea");
      txt.innerHTML = html;
      return txt.value;
    }

    var getCount = function(editor) {
      var tx = editor.getContent({
        format: "raw"
      });
      var decoded = decodeHtml(tx);
      var decodedStripped = decoded.replace(/(<([^>]+)>)/gi, "").trim();
      return decodedStripped.length;
    };

    var $_e3zt0csnjh8lz3i0 = {
      getCount: getCount
    };

    var get = function(editor) {
      var getCount = function() {
        return $_e3zt0csnjh8lz3i0.getCount(editor);
      };
      return {
        getCount: getCount
      };
    };

    var $_c38nf7smjh8lz3hz = {
      get: get
    };

    var getMaxLength = function(editor) {
      var current = editor.editorContainer;

      while (!current.classList.contains("acf-field-wysiwyg")) {
        current = current.parentNode;
      }
      var containsMaxClass = current.classList.value.indexOf("maxlength");

      if (containsMaxClass >= 0) {
        return (
          " / " +
          current.classList.value.substring(
            containsMaxClass + "maxlength--".length
          )
        );
      }

      return "";
    };

    var global$1 = tinymce.util.Tools.resolve("tinymce.util.Delay");
    var global$2 = tinymce.util.Tools.resolve("tinymce.util.I18n");

    var setup = function(editor) {
      var checkMaxLength = function(editor) {
        return getMaxLength(editor);
      };
      var charsToText = function(editor) {
        return global$2.translate([
          "{0}{1} Zeichen",
          $_e3zt0csnjh8lz3i0.getCount(editor),
          checkMaxLength(editor)
        ]);
      };
      var update = function() {
        editor.theme.panel.find("#charcount").text(charsToText(editor));
      };
      editor.on("init", function() {
        var statusbar =
          editor.theme.panel && editor.theme.panel.find("#statusbar")[0];
        var debouncedUpdate = global$1.debounce(update, 300);
        if (statusbar) {
          global$1.setEditorTimeout(
            editor,
            function() {
              statusbar.insert(
                {
                  type: "label",
                  name: "charcount",
                  text: charsToText(editor),
                  classes: "charcount",
                  disabled: editor.settings.readonly
                },
                0
              );
              editor.on(
                "setcontent beforeaddundo undo redo keyup",
                debouncedUpdate
              );
            },
            0
          );
        }
      });
    };
    var $_40dxcostjh8lz3ie = {
      setup: setup
    };

    global.add("charcount", function(editor) {
      $_40dxcostjh8lz3ie.setup(editor);
      return $_c38nf7smjh8lz3hz.get(editor);
    });

    function Plugin() {}

    return Plugin;
  })();
})();
